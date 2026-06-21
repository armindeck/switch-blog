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

$actions = new Actions\Actions;

// Profiles
if (count($view_explode) == 2 && $view_explode[0] == "p"){
    $view = "profile";
    $user = $view_explode[1] ?? "";
} 
// Blog Posts
elseif (count($view_explode) == 2 && $view_explode[0] == "blog"){
    $view = "blog";
    $post_id = $view_explode[1] ?? "";
}
// Edit Post (NUEVO)
elseif (count($view_explode) == 2 && $view_explode[0] == "edit-post"){
    $view = "edit-post";
    $post_slug = $view_explode[1] ?? "";
}
else {
    $user = $_SESSION["user"] ?? "";
}

switch ($view) {
    case "home":
        $data = [
            "auth" => $model->auth(),
            "all_users" => $model->allUser(),
            "user_auth" => $_SESSION["user"] ?? null,
            "blog_data" => read(pathFiles("blog")) ?? [],
        ];
        break;

    case "blog":
        $blog_data = read(pathFiles("blog")) ?? [];
        
        // Handle like/unlike action
        if (isset($_POST["like_post"]) && $model->auth()) {
            $actions->likeBlogPost($blog_data, $model);
        }
        
        $post_slug = $post_id ?? "";
        $post = null;
        $post_key = null;
        
        // Search post by slug
        foreach($blog_data as $key => $blog_post) {
            if(($blog_post["slug"] ?? "") === $post_slug) {
                $post = $blog_post;
                $post_key = $key;
                break;
            }
        }
        
        if($post && $post_key) {
            // Increment views
            $blog_data[$post_key]["views"] = ($blog_data[$post_key]["views"] ?? 0) + 1;
            write(pathFiles("blog"), $blog_data);
        }
        
        $data = [
            "auth" => $model->auth(),
            "post" => $post,
            "post_slug" => $post_slug,
            "user_auth" => $_SESSION["user"] ?? null
        ];
        break;
    case "edit-post":
        $blog_data = read(pathFiles("blog")) ?? [];
        $actions->updateBlogPost($blog_data, $post_slug, $model);
        
        $post = null;
        $post_key = null;
        
        // Search post by slug
        foreach($blog_data as $key => $blog_post) {
            if(($blog_post["slug"] ?? "") === $post_slug) {
                $post = $blog_post;
                $post_key = $key;
                break;
            }
        }
        
        $data = [
            "auth" => $model->auth(),
            "post" => $post,
            "post_slug" => $post_slug,
            "user_auth" => $_SESSION["user"] ?? null
        ];
        break;
    case "profile":
        $list = read(pathFiles("list"));
        $data = [
            "model" => $model,
            "list" => $list,
            "list_only" => $list[$user ?? ""] ?? [],
            "user" => $user ?? "",
            "is_user_user" => isset($user) && $model->auth() && $_SESSION["user"] == $user,
            "view" => $view,
            "auth" => $model->auth()
        ];

        $list_state = ["watch" => [], "waiting" => [], "finalized" => []];
        foreach ($data["list_only"] as $key => $value) {
            $list_state[$value["state"]][$key] = $value;
        }
        $data["list_order_by_state"] = array_merge(array_reverse($list_state["watch"]), array_reverse($list_state["waiting"]), array_reverse($list_state["finalized"]));
        
        if($view == "profile" && !isset($model->allUser()[$user])){
            $view = "error";
            $data = ["auth" => $model->auth(), "title" => "profile_not_found", "text" => "profile_not_found_searched"];
        }
        break;
        
    case "anipelis":
        if(!$model->auth()){ redirect(route("login")); }

        $list = read(pathFiles("list"));
        $actions->addListAniPelis($list, $model);
        $actions->deleteListAniPelis($list, $model);
        $data = [
            "model" => $model,
            "list" => $list,
            "list_only" => $list[$user ?? ""] ?? [],
            "user" => $user ?? "",
            "is_user_user" => isset($user) && $model->auth() && $_SESSION["user"] == $user,
            "view" => $view
        ];

        $list_state = ["watch" => [], "waiting" => [], "finalized" => []];
        foreach ($data["list_only"] as $key => $value) {
            $list_state[$value["state"]][$key] = $value;
        }
        $data["list_order_by_state"] = array_merge(array_reverse($list_state["watch"]), array_reverse($list_state["waiting"]), array_reverse($list_state["finalized"]));
        
        if($view == "profile" && !isset($model->allUser()[$user])){
            $view = "error";
            $data = ["auth" => $model->auth(), "title" => "profile_not_found", "text" => "profile_not_found_searched"];
        }
        break;
        
    case "birthday":
        if(!$model->auth()){ redirect(route("login")); }
        
        $list = read(pathFiles("birthday"));
        $actions->addBirthday($list);
        $actions->deleteBirthday($list);
        $data = [
            "model" => $model,
            "list" => $list,
            "list_only" => array_reverse($list[$_SESSION["user"]] ?? []),
            "user" => $_SESSION["user"],
            "view" => $view
        ];
        break;

    case "goals":
        if(!$model->auth()){ redirect(route("login")); }
        
        $list = read(pathFiles("goals"));
        $actions->addGoals($list);
        $actions->deleteGoals($list);
        $data = [
            "model" => $model,
            "list" => $list,
            "list_only" => $list[$_SESSION["user"]] ?? [],
            "user" => $_SESSION["user"],
            "view" => $view
        ];

        $list_state = ["in_progress" => [], "on_pause" => [], "completed" => []];
        foreach ($data["list_only"] as $key => $value) {
            $list_state[$value["state"]][$key] = $value;
        }
        $data["list_order_by_state"] = array_merge(array_reverse($list_state["in_progress"]), array_reverse($list_state["on_pause"]), array_reverse($list_state["completed"]));
        break;

    case "notes":
        if(!$model->auth()){ redirect(route("login")); }
        
        $list = read(pathFiles("notes"));
        $actions->addNotes($list);
        $actions->deleteNotes($list);
        $data = [
            "model" => $model,
            "list" => $list,
            "list_only" => array_reverse($list[$_SESSION["user"]] ?? []),
            "user" => $_SESSION["user"],
            "view" => $view
        ];
        break;

    case "diary":
        if(!$model->auth()){ redirect(route("login")); }
        
        $list = read(pathFiles("diary"));
        $actions->addDiary($list);
        $actions->deleteDiary($list);
        $data = [
            "model" => $model,
            "list" => $list,
            "list_only" => array_reverse($list[$_SESSION["user"]] ?? []),
            "user" => $_SESSION["user"],
            "view" => $view
        ];
        break;

    case "new-post":
        //if(!$model->auth()){ redirect(route("login")); }
        
        $blog = read(pathFiles("blog")) ?? [];
        $actions->createBlogPost($blog, $model);
        $data = [
            "auth" => $model->auth(),
            "model" => $model,
            "user" => $_SESSION["user"] ?? ""
        ];
        break;

    case "login":
        if($model->auth()){ redirect(route()); }
        $data = ["model" => $model];
        $actions->login(new inc\Captcha, $model);
        break;

    case "register":
        if($model->auth()){ redirect(route()); }
        $data = ["model" => $model];
        $actions->register(new inc\Captcha, $model);
        break;
        
    case "forgot-password":
        if($model->auth()){ redirect(route()); }
        $data = ["model" => $model];
        $actions->forgotPassword(new inc\Captcha, $model);
        break;
        
    case "settings":
        if(!$model->auth()){ redirect(route("login")); }
        $data = ["model" => $model, "user" => $user ?? "", "auth" => $model->auth(), "view" => $view, "recover_account_by_pin" => $_SESSION["recover_account_by_pin"] ?? false];
        $actions->updateProfile($model);
        $actions->changePass($model);
        $actions->newCode($model);
        $actions->deleteAccount($model);
        break;

    case "logout":
        if($model->auth()){
            $model->logout();
        }
        redirect("./login");
        break;

    case "community":
        $data = ["auth" => $model->auth(), "users" => $model->allUser()];
        break;

    default:
        $data = ["auth" => $model->auth()];
        $view = "error";
        break;
}

counter($view);
view("layout/$view", $data ?? []);
unset($_SESSION["tmp_form"]);