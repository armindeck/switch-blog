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
            $user = secureString($_POST["user"] ?? "");
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

    private function verify_captcha($captcha, array $tmp_list, string $route): void {
        $h_captcha_response = $_POST["h-captcha-response"];

        if (!$captcha->checkCaptcha($h_captcha_response)) {
            message("error", language("invalid_captcha"));
            $_SESSION["tmp_form"] = $tmp_list;
            redirect("./" . $route);
        }
    }
}