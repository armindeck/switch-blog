<?php
/*
MIT License

Copyright (c) 2026 Armin Deck

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

namespace Actions;

class Actions {
    public function addListAniPelis($list, $model): void {
        if (isset($_POST["add"]) || !empty($_POST["add"])){
            $title = secureString($_POST["title"] ?? "");
            $url = htmlspecialchars($_POST["url"] ?? "", ENT_QUOTES, 'UTF-8');
            $episode = secureString($_POST["episode"] ?? "");
            $episodes = secureString($_POST["episodes"] ?? "");
            $season = secureString($_POST["season"] ?? "");
            $state = secureString($_POST["state"] ?? "");
            $type = secureString($_POST["type"] ?? "");
            $stars = secureString($_POST["stars"] ?? "");

            if (empty($title) || empty($episode) || empty($state) || empty($type)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = array_post(title: $title, url: $url, episode: $episode, episodes: $episodes, season: $season, state: $state, type: $type, stars: $stars);
                redirect(route("anipelis"));
            }

            if (!empty($url) && filter_var($_POST["url"] ?? "", FILTER_VALIDATE_URL) === false) {
                message("error", language("error"));
                redirect(route("anipelis"));
            }

            $id = secureStringFile($_POST["title"] ?? "");
            $search = isset($list[$_SESSION["user"]][$id]);
            
            $list[$_SESSION["user"]][$id] = array_post(title: $title, url: $url, episode: $episode, episodes: $episodes, season: $season, state: $state, type: $type, stars: $stars);

            $confirm = write(pathFiles("list"), $list);

            message($confirm ? "success" : "error", $confirm ? language($search ? "updated" : "added") : language("fail"));
            redirect(route("anipelis"));
        }
    }

    public function deleteListAniPelis($list, $model): void {
        if (isset($_GET["action"]) && $_GET["action"] == "delete" && !empty($list) && isset($_GET["id"])){
            $id = secureString($_GET["id"] ?? "");

            $search = isset($list[$_SESSION["user"]][$id]);
            if($search){
                unset($list[$_SESSION["user"]][$id]);

                $confirm = write(pathFiles("list"), $list);
                message($confirm ? "success" : "error", language($confirm ? "deleted" : "fail"));
                redirect(route("anipelis"));
            }
        }
    }

    public function addBirthday($list): void {
        if (isset($_POST["add"]) || !empty($_POST["add"])){
            $name = secureString($_POST["name"] ?? "");
            $date = secureString($_POST["date"] ?? "");

            if (empty($name) || empty($date)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = ["name" => $name, "date" => $date];
                redirect(route("birthday"));
            }

            $id = secureStringFile($_POST["name"] ?? "");
            $search = isset($list[$_SESSION["user"]][$id]);
            
            $list[$_SESSION["user"]][$id] = ["name" => $name, "date" => $date];

            $confirm = write(pathFiles("birthday"), $list);

            message($confirm ? "success" : "error", $confirm ? language($search ? "updated" : "added") : language("fail"));
            redirect(route("birthday"));
        }
    }

    public function deleteBirthday($list): void {
        if (isset($_GET["action"]) && $_GET["action"] == "delete" && !empty($list) && isset($_GET["id"])){
            $id = secureString($_GET["id"] ?? "");

            $search = isset($list[$_SESSION["user"]][$id]);
            if($search){
                unset($list[$_SESSION["user"]][$id]);

                $confirm = write(pathFiles("birthday"), $list);
                message($confirm ? "success" : "error", language($confirm ? "deleted" : "fail"));
                redirect(route("birthday"));
            }
        }
    }

    public function addNotes($list): void {
        if (isset($_POST["add"]) || !empty($_POST["add"])){
            $type = secureString($_POST["add"] ?? "");
            $title = secureString($_POST["title"] ?? "");
            $content = secureString($_POST["content"] ?? "");
            $date = date_year_month_day_minute_second();
            $date_created = $date;
            $id = secureStringFile($date);
            $id_origin = $type == "edit" && !empty($_POST["id"]) ? secureStringFile($_POST["id"]) : $id;
            $id_modified = $type == "edit" ? $id_origin != $id : false;
            $search = isset($list[$_SESSION["user"]][$id]);
            $search_id_origin = isset($list[$_SESSION["user"]][$id_origin]);
            $dates_db = $search_id_origin ? $list[$_SESSION["user"]][$id_origin] ?? [] : [];

            if (empty($title) || empty($content)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = ["title" => $title, "content" => $content, "date" => $date];
                redirect(route("notes"));
            }

            $new_list = ["id" => $id, "title" => $title, "content" => $content, "date" => $date, "date_created" => !empty($dates_db["date_created"]) ? $dates_db["date_created"] : $date_created];
            
            if($id_modified && $search_id_origin){
                unset($list[$_SESSION["user"]][$id_origin]);
            }

            $list[$_SESSION["user"]][$id] = $new_list;

            $confirm = write(pathFiles("notes"), $list);

            message($confirm ? "success" : "error", $confirm ? language($search ? "updated" : "added") : language("fail"));
            redirect(route("notes"));
        }
    }

    public function deleteNotes($list): void {
        if (isset($_GET["action"]) && $_GET["action"] == "delete" && !empty($list) && isset($_GET["id"])){
            $id = secureString($_GET["id"] ?? "");

            $search = isset($list[$_SESSION["user"]][$id]);
            if($search){
                unset($list[$_SESSION["user"]][$id]);

                $confirm = write(pathFiles("notes"), $list);
                message($confirm ? "success" : "error", language($confirm ? "deleted" : "fail"));
                redirect(route("notes"));
            }
        }
    }

    public function addDiary($list): void {
        if (isset($_POST["add"]) || !empty($_POST["add"])){
            $type = secureString($_POST["add"] ?? "");
            $title = secureString($_POST["title"] ?? "");
            $content = secureString($_POST["content"] ?? "");
            $auto_date = !empty($_POST["auto_date"]);
            $date = $auto_date ? date_year_month_day() : ($_POST["date"] ? secureString($_POST["date"]) : date_year_month_day());
            $id = secureStringFile($date);
            $id_origin = $type == "edit" && !empty($_POST["id"]) ? secureStringFile($_POST["id"]) : $id;
            $id_modified = $type == "edit" ? $id_origin != $id : false;
            $search = isset($list[$_SESSION["user"]][$id]);
            $search_id_origin = isset($list[$_SESSION["user"]][$id_origin]);
            $dates_db = $search_id_origin ? $list[$_SESSION["user"]][$id_origin] ?? [] : [];
            $replace = $search && !empty($_POST["replace_note"]);

            if (empty($title) || empty($content)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = ["title" => $title, "content" => $content, "date" => $date, "auto_date" => $auto_date];
                redirect(route("diary"));
            }

            if ($search && !$replace && ($id_modified || $type == "add")){
                message("error", language("diary_note_exists"));
                $_SESSION["tmp_form"] = ["id" => $search && $id_modified ? $id_origin : $id, "title" => $title, "content" => $content, "date" => $date, "auto_date" => $auto_date, "alert_note_exists_confirm" => true];
                redirect(route("diary"));
            }

            $new_list = ["id" => $id, "title" => $title, "content" => $content, "date" => $date, "date_created" => !empty($dates_db["date_created"]) ? $dates_db["date_created"] : date_year_month_day_minute_second()];
            
            if($id_modified && $search_id_origin){
                unset($list[$_SESSION["user"]][$id_origin]);
            }

            $list[$_SESSION["user"]][$id] = $new_list;

            $confirm = write(pathFiles("diary"), $list);

            message($confirm ? "success" : "error", $confirm ? language($search ? "updated" : "added") : language("fail"));
            redirect(route("diary"));
        }
    }

    public function deleteDiary($list): void {
        if (isset($_GET["action"]) && $_GET["action"] == "delete" && !empty($list) && isset($_GET["id"])){
            $id = secureString($_GET["id"] ?? "");

            $search = isset($list[$_SESSION["user"]][$id]);
            if($search){
                unset($list[$_SESSION["user"]][$id]);

                $confirm = write(pathFiles("diary"), $list);
                message($confirm ? "success" : "error", language($confirm ? "deleted" : "fail"));
                redirect(route("diary"));
            }
        }
    }

    public function addGoals($list): void {
        if (isset($_POST["add"]) || !empty($_POST["add"])){
            $goal = secureString($_POST["goal"] ?? "");
            $state = secureString($_POST["state"] ?? "");
            $time = secureString($_POST["time"] ?? "");
            $date = secureString($_POST["date"] ?? "");

            $dates = ["goal" => $goal, "state" => $state, "time" => $time, "date" => $date];

            if (empty($goal) || empty($state) || empty($time) || empty($date)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = $dates;
                redirect(route("goals"));
            }

            $id = secureStringFile($_POST["goal"] ?? "");
            $search = isset($list[$_SESSION["user"]][$id]);
            
            $list[$_SESSION["user"]][$id] = $dates;

            $confirm = write(pathFiles("goals"), $list);

            message($confirm ? "success" : "error", $confirm ? language($search ? "updated" : "added") : language("fail"));
            redirect(route("goals"));
        }
    }

    public function deleteGoals($list): void {
        if (isset($_GET["action"]) && $_GET["action"] == "delete" && !empty($list) && isset($_GET["id"])){
            $id = secureString($_GET["id"] ?? "");

            $search = isset($list[$_SESSION["user"]][$id]);
            if($search){
                unset($list[$_SESSION["user"]][$id]);

                $confirm = write(pathFiles("goals"), $list);
                message($confirm ? "success" : "error", language($confirm ? "deleted" : "fail"));
                redirect(route("goals"));
            }
        }
    }

    public function login($captcha, $model): void {
        if (isset($_POST["login"]) || !empty($_POST["login"])){
            $user = secureString($_POST["user"] ?? "");
            $pass = $_POST["password"] ?? "";
            
            $this->verify_captcha($captcha, ["user" => $user], "login");

            if (empty($user) || empty($pass)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = ["user" => $user];
                redirect("./login");
            }

            $confirm = $model->login($user, $pass);

            message($confirm["result"] ? "success" : "error", language($confirm["message"]));
            redirect("./" . (!$confirm["result"] ? "login" : ""));
        }
    }

    public function register($captcha, $model): void {
        if (isset($_POST["register"]) || !empty($_POST["register"])){
            $user = secureString($_POST["user"] ?? "");
            $name = secureString($_POST["name"] ?? "");
            $email = secureString($_POST["email"] ?? "");
            $pass = $_POST["password"] ?? "";
            $pass_confirm = $_POST["confirm_password"] ?? "";
            
            $this->verify_captcha($captcha, ["user" => $user, "name" => $name, "email" => $email], "register");

            if (empty($user) || empty($name) || empty($email) || empty($pass) || empty($pass_confirm)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = ["user" => $user, "name" => $name, "email" => $email];
                redirect("./register");
            }

            if ($pass != $pass_confirm){
                message("error", language("password_is_diferent"));
                $_SESSION["tmp_form"] = ["user" => $user, "name" => $name, "email" => $email];
                redirect("./register");
            }

            if (
                strlen($user) < 4 || strlen($user) > 25 ||
                strlen($name) < 4 || strlen($name) > 25 ||
                strlen($email) < 4 || strlen($email) > 150 ||
                strlen($pass) < 8 || strlen($pass) > 150 ||
                !filter_var($email, FILTER_VALIDATE_EMAIL)
                ){
                message("error", language("fill_the_fields_with_the_requested_data"));
                $_SESSION["tmp_form"] = ["user" => $user, "name" => $name, "email" => $email];
                redirect("./register");
            }

            $confirm = $model->newUser($user, $name, $email, $pass);

            if($confirm["result"]){
                $model->login($user, $pass);
            }

            message($confirm["result"] ? "success" : "error", language($confirm["message"]));
            redirect("./" . (!$confirm["result"] ? "register" : ""));
        }
    }

    public function forgotPassword($captcha, $model): void {
        if (isset($_POST["recover_account"]) || !empty($_POST["recover_account"])){
            $email = secureString($_POST["email"] ?? "");
            $pin = secureString($_POST["pin"] ?? "");
            $this->verify_captcha($captcha, ["email" => $email, "pin" => $pin], "forgot-password");

            if (empty($email) || empty($pin)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = ["email" => $email, "pin" => $pin];
                redirect("./forgot-password");
            }

            $confirm = $model->forgotPassword($email, $pin);

            message($confirm["result"] ? "success" : "error", language($confirm["message"]));
            redirect("./" . (!$confirm["result"] ? "forgot-password" : "settings#change-password"));
        }
    }

    public function updateProfile($model): void {
        if (isset($_POST["update_profile"]) || !empty($_POST["update_profile"])){
            $user_origin = $_SESSION["user"] ?? "";
            $user = $user_origin;
            $name = secureString($_POST["name"] ?? "");
            $email = secureString($_POST["email"] ?? "");
            $pass = $_POST["password"] ?? "";

            if (empty($user) || empty($name) || empty($email) || empty($pass)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = ["user" => $user, "name" => $name, "email" => $email];
                redirect("./settings");
            }

            if (
                strlen($user) < 4 || strlen($user) > 25 ||
                strlen($name) < 4 || strlen($name) > 25 ||
                strlen($email) < 4 || strlen($email) > 150 ||
                strlen($pass) < 8 || strlen($pass) > 150 ||
                !filter_var($email, FILTER_VALIDATE_EMAIL)
                ){
                message("error", language("fill_the_fields_with_the_requested_data"));
                $_SESSION["tmp_form"] = ["user" => $user, "name" => $name, "email" => $email];
                redirect("./settings");
            }

            $confirm = $model->updateUser($user_origin, $user, $name, $email, $pass);

            message($confirm["result"] ? "success" : "error", language($confirm["message"]));
            redirect("./settings");
        }
    }

    public function changePass($model): void {
        if (isset($_POST["change_pass"]) || !empty($_POST["change_pass"])){
            $user_origin = $_SESSION["user"] ?? "";
            $current_password = $_POST["current_password"] ?? "";
            $new_password = $_POST["new_password"] ?? "";
            $confirm_new_password = $_POST["confirm_new_password"] ?? "";
            $empty_current_password_if = !isset($_SESSION["recover_account_by_pin"]) && empty($current_password);
            $empty_current_password_if_strlen = !isset($_SESSION["recover_account_by_pin"]) && (strlen($current_password) < 8 || strlen($current_password) > 150);

            if ($empty_current_password_if || empty($new_password) || empty($confirm_new_password)){
                message("error", language("fill_required"));
                redirect("./settings");
            }

            if (
                $empty_current_password_if_strlen ||
                strlen($new_password) < 8 || strlen($new_password) > 150 ||
                strlen($confirm_new_password) < 8 || strlen($confirm_new_password) > 150 ||
                $new_password !== $confirm_new_password
                ){
                message("error", language("fill_the_fields_with_the_requested_data"));
                redirect("./settings");
            }

            $confirm = $model->changePass($user_origin, $current_password, $new_password);

            message($confirm["result"] ? "success" : "error", language($confirm["message"]));
            redirect("./settings#");
        }
    }

    public function newCode($model): void {
        if (isset($_POST["new_code"]) || !empty($_POST["new_code"])){
            $user_origin = $_SESSION["user"] ?? "";
            $password = $_POST["password"] ?? "";

            if (empty($password)){
                message("error", language("fill_required"));
                redirect("./settings");
            }

            if (strlen($password) < 8 || strlen($password) > 150){
                message("error", language("fill_the_fields_with_the_requested_data"));
                redirect("./settings");
            }

            $confirm = $model->newCode($user_origin, $password);

            message($confirm["result"] ? "success" : "error", language($confirm["message"]));
            redirect("./settings");
        }
    }

    public function deleteAccount($model): void {
        if (isset($_POST["delete_account"]) || !empty($_POST["delete_account"])){
            $user_origin = $_SESSION["user"] ?? "";
            $password = $_POST["password"] ?? "";

            if (empty($password)){
                message("error", language("fill_required"));
                redirect("./settings");
            }

            if (strlen($password) < 8 || strlen($password) > 150){
                message("error", language("fill_the_fields_with_the_requested_data"));
                redirect("./settings");
            }

            $confirm = $model->deleteAccount($user_origin, $password);

            message($confirm["result"] ? "success" : "error", language($confirm["message"]));
            redirect("./" . (!$confirm["result"] ? "settings" : "login"));
        }
    }

    public function createBlogPost($blog, $model): void {
        if (isset($_POST["create_post"]) || !empty($_POST["create_post"])){
            $title = secureString($_POST["title"] ?? "");
            $category = secureString($_POST["category"] ?? "");
            $excerpt = secureString($_POST["excerpt"] ?? "");
            $content = $_POST["content"] ?? "";
            $image = htmlspecialchars($_POST["image"] ?? "", ENT_QUOTES, 'UTF-8');

            if (empty($title) || empty($category) || empty($excerpt) || empty($content)){
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = array_post(title: $title, category: $category, excerpt: $excerpt, image: $image);
                redirect(route("new-post"));
            }

            if (strlen($title) < 5 || strlen($title) > 200 || 
                strlen($excerpt) < 10 || strlen($excerpt) > 250 || 
                strlen($content) < 20){
                message("error", language("fill_the_fields_with_the_requested_data"));
                $_SESSION["tmp_form"] = array_post(title: $title, category: $category, excerpt: $excerpt, image: $image);
                redirect(route("new-post"));
            }

            if (!empty($image) && filter_var($image, FILTER_VALIDATE_URL) === false) {
                message("error", language("invalid_image_url"));
                $_SESSION["tmp_form"] = array_post(title: $title, category: $category, excerpt: $excerpt, image: $image);
                redirect(route("new-post"));
            }

            $id = "blog_" . date("YmdHis") . "_" . random_int(1000, 9999);
            $time = date_year_month_day_minute_second();
            
            // Generate slug from title
            $slug = strtolower(trim(preg_replace('/[^\w\s-]/', '', $title)));
            $slug = preg_replace('/\s+/', '-', $slug);
            $slug = preg_replace('/-+/', '-', $slug);
            $slug = trim($slug, '-');

            $blog[$id] = [
                "id" => $id,
                "author" => $_SESSION["user"] ?? "anonymous",
                "title" => $title,
                "category" => $category,
                "excerpt" => $excerpt,
                "content" => $content,
                "image" => $image,
                "slug" => $slug,
                "date_published" => $time,
                "date_created" => $time,
                "status" => "published",
                "views" => 0,
                "likes" => 0
            ];

            $confirm = write(pathFiles("blog"), $blog);

            message($confirm ? "success" : "error", $confirm ? language("post_created") : language("post_failed"));
            redirect($confirm ? route("home") : route("new-post"));
        }
    }

    public function updateBlogPost($blog, $post_slug, $model): void {
        if (isset($_POST["update_post"])) {
            // Sanitizar entradas
            $title = secureString($_POST["title"] ?? "");
            $category = secureString($_POST["category"] ?? "");
            $excerpt = secureString($_POST["excerpt"] ?? "");
            $content = $_POST["content"] ?? "";
            $image = htmlspecialchars($_POST["image"] ?? "", ENT_QUOTES, 'UTF-8');

            // Validaciones
            if (empty($title) || empty($category) || empty($excerpt) || empty($content)) {
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = array_post(title: $title, category: $category, excerpt: $excerpt, image: $image);
                redirect(route("edit-post/" . $post_slug));
            }

            if (strlen($title) < 5 || strlen($title) > 200 || 
                strlen($excerpt) < 10 || strlen($excerpt) > 250 || 
                strlen($content) < 20) {
                message("error", language("fill_the_fields_with_the_requested_data"));
                $_SESSION["tmp_form"] = array_post(title: $title, category: $category, excerpt: $excerpt, image: $image);
                redirect(route("edit-post/" . $post_slug));
            }

            if (!empty($image) && filter_var($image, FILTER_VALIDATE_URL) === false) {
                message("error", language("invalid_image_url"));
                $_SESSION["tmp_form"] = array_post(title: $title, category: $category, excerpt: $excerpt, image: $image);
                redirect(route("edit-post/" . $post_slug));
            }

            // Buscar el post por slug
            $found_key = null;
            foreach ($blog as $key => $post) {
                if (($post["slug"] ?? "") === $post_slug) {
                    $found_key = $key;
                    break;
                }
            }

            if ($found_key === null) {
                message("error", language("post_not_found"));
                redirect(route("home"));
            }

            // Actualizar datos
            $blog[$found_key]["title"] = $title;
            $blog[$found_key]["category"] = $category;
            $blog[$found_key]["excerpt"] = $excerpt;
            $blog[$found_key]["content"] = $content;
            $blog[$found_key]["image"] = $image;
            // Opcional: actualizar slug si cambia el título (puede romper enlaces)
            // $blog[$found_key]["slug"] = generarSlug($title);
            $blog[$found_key]["updated_at"] = date_year_month_day_minute_second();

            // Guardar cambios
            $confirm = write(pathFiles("blog"), $blog);
            message($confirm ? "success" : "error", $confirm ? language("post_updated") : language("post_update_failed"));
            redirect($confirm ? route("blog/" . $post_slug) : route("edit-post/" . $post_slug));
        }
    }

    private function verify_captcha($captcha, array $tmp_list, string $route): void {
        $h_captcha_response = $_POST["h-captcha-response"];

        if (!$captcha->checkCaptcha($h_captcha_response)) {
            message("error", language("invalid_captcha"));
            $_SESSION["tmp_form"] = $tmp_list;
            redirect("./" . $route);
        }
    }

    public function likeBlogPost($blog, $model): void {
        if (isset($_POST["like_post"]) || !empty($_POST["like_post"])){
            $post_slug = secureString($_POST["post_slug"] ?? "");
            $user = $_SESSION["user"] ?? "";

            if (empty($post_slug) || empty($user)){
                message("error", language("error"));
                redirect(route("home"));
            }

            // Find post by slug
            $post_key = null;
            foreach($blog as $key => $blog_post) {
                if(($blog_post["slug"] ?? "") === $post_slug) {
                    $post_key = $key;
                    break;
                }
            }

            if (!$post_key) {
                message("error", language("post_not_found"));
                redirect(route("home"));
            }

            // Initialize likes array if not exists
            if (!isset($blog[$post_key]["liked_by"])) {
                $blog[$post_key]["liked_by"] = [];
            }

            // Check if user already liked
            $user_already_liked = in_array($user, $blog[$post_key]["liked_by"]);

            if ($user_already_liked) {
                // Remove like
                $blog[$post_key]["liked_by"] = array_filter($blog[$post_key]["liked_by"], function($u) use ($user) {
                    return $u !== $user;
                });
                $blog[$post_key]["likes"] = ($blog[$post_key]["likes"] ?? 1) - 1;
                $message = "like_removed";
            } else {
                // Add like
                $blog[$post_key]["liked_by"][] = $user;
                $blog[$post_key]["likes"] = ($blog[$post_key]["likes"] ?? 0) + 1;
                $message = "post_liked";
            }

            $confirm = write(pathFiles("blog"), $blog);

            message($confirm ? "success" : "error", $confirm ? language($message) : language("fail"));
            redirect(route("blog") . "/" . urlencode($post_slug));
        }
    }

    public function updateSettings(array $data_config): void {
        if (isset($_POST["update_settings"])) {
            // Sanitizar datos
            $name = secureString($_POST["name"] ?? "");
            $url = htmlspecialchars($_POST["url"] ?? "", ENT_QUOTES, 'UTF-8');
            $description = secureString($_POST["description"] ?? "");
            $timezone = secureString($_POST["timezone"] ?? "");
            $year = secureString($_POST["year"] ?? "");
            $language = secureString($_POST["language"] ?? "");
            $theme = secureString($_POST["theme"] ?? "");
            $captcha_public_key = secureString($_POST["captcha_public_key"] ?? "");
            $captcha_private_key = secureString($_POST["captcha_private_key"] ?? "");

            $data_fill = [
                "name" => $name,
                "url" => $url,
                "description" => $description,
                "timezone" => $timezone,
                "year" => $year,
                "language" => $language,
                "theme" => $theme,
                "captcha_public_key" => $captcha_public_key,
                "captcha_private_key" => $captcha_private_key
            ];

            // Validaciones
            if (empty($name) || empty($url) || empty($timezone) || empty($year) || empty($language) || empty($theme)) {
                message("error", language("fill_required"));
                $_SESSION["tmp_form"] = $data_fill;
                redirect(route("dashboard/settings"));
            }

            if (strlen($name) < 2 || strlen($name) > 200 || 
                strlen($url) < 10 || strlen($url) > 250 || 
                strlen($timezone) < 2 || strlen($timezone) > 250 || 
                strlen($year) != 4 || 
                strlen($language) < 2 || strlen($language) > 100 ||
                strlen($theme) < 2 || strlen($theme) > 100
                ) {
                message("error", language("fill_the_fields_with_the_requested_data"));
                $_SESSION["tmp_form"] = $data_fill;
                redirect(route("dashboard/settings"));
            }

            if (filter_var($url, FILTER_VALIDATE_URL) === false) {
                message("error", language("invalid_url"));
                $_SESSION["tmp_form"] = $data_fill;
                redirect(route("dashboard/settings"));
            }

            $captcha = ["public" => $captcha_public_key, "private" => $captcha_private_key];
            $data_fill = array_merge($data_fill, ["captcha" => $captcha]);
            unset($data_fill["captcha_public_key"]);
            unset($data_fill["captcha_private_key"]);

            $data = array_merge($data_config, $data_fill);

            if($url != $data_config["url"] || $timezone != $data_config["timezone"]){
                $read = file_exists(RAIZ . ".htaccess") ? file_get_contents(RAIZ . ".htaccess") ?? "" : "";
                $modify = $read;
                if($url != $data_config["url"]){
                    $url_mod = rtrim($url, '/') . '/';
                    $modify = str_replace(
                        "RewriteRule ^(.*)$ {$data_config['url']}$1 [R=301,L]",
                        "RewriteRule ^(.*)$ {$url_mod}$1 [R=301,L]",
                        $read
                    );
                }
                if($timezone != $data_config["timezone"]){
                    $modify = str_replace(
                        "php_value date.timezone \"{$data_config['timezone']}\"",
                        "php_value date.timezone \"{$timezone}\"",
                        $read
                    );
                }
                file_put_contents(RAIZ . ".htaccess", $modify);
            }
            
            // Guardar cambios
            $confirm = write(pathFiles("config"), $data);
            message($confirm ? "success" : "error", $confirm ? language("updated") : language("fail"));
            redirect(route("dashboard/settings"));
        }
    }

    public function updateSettingsHtaccess(array $data_config): void {
        if (isset($_POST["update_settings_htaccess"])) {
            // Sanitizar datos
            $enable_timezone = !empty($_POST["enable_timezone"]);
            $enable_ssl_https = !empty($_POST["enable_ssl_https"]);
            $show_errors = !empty($_POST["show_errors"]);
            $field_link_error = fn($id) => htmlspecialchars($_POST["error_link_{$id}"] ?? "", ENT_QUOTES, 'UTF-8');

            $data_fill = [
                "enable_timezone" => $enable_timezone,
                "enable_ssl_https" => $enable_ssl_https,
                "show_errors" => $show_errors,
            ];

            $url_fill = [];
            $urls_error_links = [];
            $number_errors = [400, 401, 403, 404, 500, 503];

            foreach ($number_errors as $value) {
                $url_fill["error_link_{$value}"] = $field_link_error($value);
                $urls_error_links[$value] = $field_link_error($value);
            }

            foreach ($url_fill as $value) {
                if (empty($value)){
                    message("error", language("fill_required"));
                    $_SESSION["tmp_form"] = array_merge($data_fill, $url_fill);
                    redirect(route("dashboard/settings"));
                    break;
                }
    
                if (filter_var($value, FILTER_VALIDATE_URL) === false) {
                    message("error", language("invalid_url"));
                    $_SESSION["tmp_form"] = array_merge($data_fill, $url_fill);;
                    redirect(route("dashboard/settings"));
                    break;
                }
            }

            $data_fill["error_link"] = $urls_error_links;
            $data = array_merge($data_config, $data_fill);
            $file_htaccess = RAIZ . "database/htaccess.txt";
            $url_mod = rtrim($data_config["url"], '/') . '/';

            $read_htaccess = file_exists($file_htaccess) ? file_get_contents($file_htaccess) ?? "" : "";
            $modify = $read_htaccess;

            $text_replace = [
                "show_error" => "# REPLACE_SHOW_ERROR",
                "timezone" => "# REPLACE_TIMEZONE",
                "redirect_https" => "# REPLACE_REDIRECT_HTTPS",
                "error_link" => "# REPLACE_ERROR_LINK"
            ];

            $code_show_error = "php_flag display_errors On\nphp_flag display_startup_errors On\nphp_value error_reporting -1";
            $code_timezone = "php_value date.timezone \"{$data_config['timezone']}\"";
            $code_redirect_https = "RewriteCond %{HTTPS} !=on\nRewriteRule ^(.*)$ {$url_mod}$1 [R=301,L]";
            $code_change_error_link =
                "ErrorDocument 400 {$urls_error_links[400]}\n".
                "ErrorDocument 401 {$urls_error_links[401]}\n".
                "ErrorDocument 403 {$urls_error_links[403]}\n".
                "ErrorDocument 404 {$urls_error_links[404]}\n".
                "ErrorDocument 500 {$urls_error_links[500]}\n".
                "ErrorDocument 503 {$urls_error_links[503]}";

            $code_error_link_origin =
                "ErrorDocument 400 {$data_config['error_link'][400]}\n".
                "ErrorDocument 401 {$data_config['error_link'][401]}\n".
                "ErrorDocument 403 {$data_config['error_link'][403]}\n".
                "ErrorDocument 404 {$data_config['error_link'][404]}\n".
                "ErrorDocument 500 {$data_config['error_link'][500]}\n".
                "ErrorDocument 503 {$data_config['error_link'][503]}";
            
            $modify = str_replace(
                $show_errors ? $text_replace["show_error"] : $code_show_error,
                !$show_errors ? $text_replace["show_error"] : $code_show_error,
                $modify);

            $modify = str_replace(
                $enable_timezone ? $text_replace["timezone"] : $code_timezone,
                !$enable_timezone ? $text_replace["timezone"] : $code_timezone,
                $modify);

            $modify = str_replace(
                $enable_ssl_https ? $text_replace["redirect_https"] : $code_redirect_https,
                !$enable_ssl_https ? $text_replace["redirect_https"] : $code_redirect_https,
                $modify);

            $modify = str_replace($text_replace["error_link"], $code_change_error_link, $modify);
            $modify = str_replace($code_error_link_origin, $code_change_error_link, $modify);

            $save_htaccess = file_put_contents(RAIZ . ".htaccess", $modify);

            // Guardar cambios
            $confirm = write(pathFiles("config"), $data) && $save_htaccess;
            message($confirm ? "success" : "error", $confirm ? language("updated") : language("fail"));
            redirect(route("dashboard/settings"));
        }
    }
}