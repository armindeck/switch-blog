<?php

class model {
    public function newUser(string $user, string $name, string $email, string $pass): array {
        $read = read(pathFiles("users"));
        $time = date_year_month_day_minute_second();
        $user = strtolower($user);
        $email = strtolower($email);

        if(isset($read[$user])){
            return ["result" => false, "message" => "the_user_already_exists"];
        }

        $read[$user] = [
            "user" => $user,
            "name" => $name,
            "email" => $email,
            "pass" => hashPassword($pass),
            "state" => "public",
            "rol" => "user",
            "recovery_code" => generatePin(),
            "date_registered" => $time
        ];

        $result = write(pathFiles("users"), $read);

        $message = $result ? "the_user_was_created_successfully" : "the_user_was_not_created_successfully";
        return ["result" => $result, "message" => $message];
    }

    public function updateUser(string $user_origin, string $user, string $name, string $email, string $pass): array {
        $read = read(pathFiles("users"));
        $update = $read;
        $time = date_year_month_day_minute_second();
        $user_origin = strtolower($user_origin);
        $user = strtolower($user);
        $email = strtolower($email);

        if(empty($read)){
            return ["result" => false, "message" => "no_users_exist"];
        }

        if(!isset($read[$user_origin])){
            return ["result" => false, "message" => "the_user_to_modify_does_not_exist"];
        }
        
        if(!verifyPassword($pass, $read[$user_origin]["pass"])){
            return ["result" => false, "message" => "the_password_is_incorrect"];
        }

        if(isset($read[$user]) && $user_origin != $user){
            return ["result" => false, "message" => "the_user_already_exists"];
        }

        $changes = [
            "user" => $read[$user_origin]["user"] == $user,
            "name" => $read[$user_origin]["name"] == $name,
            "email" => $read[$user_origin]["email"] == $email,
        ];

        $updates = [];
        foreach ($changes as $key => $value) {
            if(!$value){
                $updates[$key] = match ($key) {
                    "user" => $user,
                    "name" => $name,
                    "email" => $email
                };
            }
        }

        $changes_history = [];
        foreach ($changes as $key => $value) {
            if(!$value){
                $changes_history[$key] = $read[$user_origin][$key];
            }
        };

        if(empty($updates)){
            return ["result" => false, "message" => "no_data_was_updated"];
        }

        $update[$user] = array_merge($read[$user_origin], $updates);
        $update[$user] = array_merge($update[$user], ["date_updated" => $time]);
        $update[$user]["history"] = array_merge($update[$user]["history"] ?? [], [$time => $changes_history]);

        if ($user_origin != $user){
            unset($update[$user_origin]);
        }

        $result = write(pathFiles("users"), $update);

        if($result && $user_origin != $user){
            $_SESSION["user"] = $user;
            $_SESSION["token"] = generateToken();
        }

        $message = $result ? "the_user_was_updated_successfully" : "the_user_was_not_updated_successfully";
        return ["result" => $result, "message" => $message];
    }

    public function newUserRecoveryCode(string $user): array {
        $read = read(pathFiles("users"));
        $update = $read;
        $time = date_year_month_day_minute_second();
        $user = strtolower($user);

        if(empty($read)){
            return ["result" => false, "message" => "no_users_exist"];
        }

        if(!isset($read[$user])){
            return ["result" => false, "message" => "the_user_to_modify_does_not_exist"];
        }

        $update[$user]["recovery_code"] = generatePin();
        $update[$user]["date_updated"] = $time;
        $update[$user]["history"][$time] = ["recovery_code" => $read[$user]["recovery_code"]];

        $result = write(pathFiles("users"), $update);

        $message = $result ? "the_pin_was_changed_successfully" : "the_pin_was_not_changed";
        return ["result" => $result, "message" => $message];
    }

    public function forgotPassword(string $email, string $pin): array {
        $read = read(pathFiles("users"));
        $update = $read;
        $time = date_year_month_day_minute_second();
        $search_user_by_email = $this->getUserByEmail($read, $email);
        $user = $search_user_by_email["result"] ? $search_user_by_email["user"]["user"] : null;

        if(empty($read)){
            return ["result" => false, "message" => "no_users_exist"];
        }

        if($user === null || !isset($read[$user])){
            return ["result" => false, "message" => "the_user_does_not_exist"];
        }
        
        if($pin != $read[$user]["recovery_code"]){
            return ["result" => false, "message" => "invalid_recovery_pin"];
        }

        $update[$user]["date_login"] = $time;
        $update[$user]["history"][$time] = "login and new recovery pin";
        $update[$user]["recovery_code"] = generatePin();

        $result = write(pathFiles("users"), $update);
        
        if($result) {
            $_SESSION["user"] = $user;
            $_SESSION["token"] = generateToken();
            $_SESSION["recover_account_by_pin"] = true;
        }

        $message = $result ? "logged_in_successfully" : "failed_to_log_in";
        return ["result" => $result, "message" => $message];
    }

    public function login(string $user, string $pass): array {
        $read = read(pathFiles("users"));
        $update = $read;
        $time = date_year_month_day_minute_second();
        $user = strtolower($user);

        if(empty($read)){
            return ["result" => false, "message" => "no_users_exist"];
        }

        if(!isset($read[$user])){
            return ["result" => false, "message" => "the_user_does_not_exist"];
        }
        
        if(!verifyPassword($pass, $read[$user]["pass"])){
            return ["result" => false, "message" => "the_username_or_password_is_incorrect"];
        }

        $update[$user]["date_login"] = $time;
        $update[$user]["history"][$time] = "login";
        
        $result = write(pathFiles("users"), $update);
        
        if($result) {
            $_SESSION["user"] = $user;
            $_SESSION["token"] = generateToken();
        }

        $message = $result ? "the_user_logged_in_successfully" : "the_user_failed_to_log_in";
        return ["result" => $result, "message" => $message];
    }

    public function changePass(string $user, string $current_password, string $new_password): array {
        $read = read(pathFiles("users"));
        $update = $read;
        $time = date_year_month_day_minute_second();
        $user = strtolower($user);

        if(empty($read)){
            return ["result" => false, "message" => "no_users_exist"];
        }

        if(!isset($read[$user])){
            return ["result" => false, "message" => "the_user_does_not_exist"];
        }
        
        if(!isset($_SESSION["recover_account_by_pin"]) && !verifyPassword($current_password, $read[$user]["pass"])){
            return ["result" => false, "message" => "the_password_is_incorrect"];
        }

        $update[$user]["pass"] = hashPassword($new_password);
        $update[$user]["date_updated"] = $time;
        $update[$user]["history"][$time] = "change password";
        
        $result = write(pathFiles("users"), $update);

        if($result) {
            unset($_SESSION["recover_account_by_pin"]);
        }
        
        $message = $result ? "the_password_was_changed_successfully" : "the_password_failed_to_change";
        return ["result" => $result, "message" => $message];
    }

    public function newCode(string $user, string $password): array {
        $read = read(pathFiles("users"));
        $update = $read;
        $time = date_year_month_day_minute_second();
        $user = strtolower($user);

        if(empty($read)){
            return ["result" => false, "message" => "no_users_exist"];
        }

        if(!isset($read[$user])){
            return ["result" => false, "message" => "the_user_does_not_exist"];
        }
        
        if(!verifyPassword($password, $read[$user]["pass"])){
            return ["result" => false, "message" => "the_password_is_incorrect"];
        }

        $update[$user]["recovery_code"] = generatePin();
        $update[$user]["date_updated"] = $time;
        $update[$user]["history"][$time] = ["recovery_code" => $read[$user]["recovery_code"]];

        $result = write(pathFiles("users"), $update);

        $message = $result ? "the_pin_was_changed_successfully" : "the_pin_was_not_changed";
        return ["result" => $result, "message" => $message];
    }

    public function deleteAccount(string $user, string $password): array {
        $read = read(pathFiles("users"));
        $update = $read;
        $user = strtolower($user);

        if(empty($read)){
            return ["result" => false, "message" => "no_users_exist"];
        }

        if(!isset($read[$user])){
            return ["result" => false, "message" => "the_user_does_not_exist"];
        }
        
        if(!verifyPassword($password, $read[$user]["pass"])){
            return ["result" => false, "message" => "the_password_is_incorrect"];
        }

        unset($update[$user]);
        
        $result = write(pathFiles("users"), $update);
        
        if($result) {
            unset($_SESSION["user"]);
            unset($_SESSION["token"]);
        }

        $message = $result ? "the_account_was_deleted_successfully" : "the_account_failed_to_delete";
        return ["result" => $result, "message" => $message];
    }

    public function auth(): bool {
        return !empty($_SESSION["user"]) && !empty($_SESSION["token"]);
    }

    public function logout(): void {
        unset($_SESSION["user"]);
        unset($_SESSION["token"]);
    }

    public function allUser(): array {
        return read(pathFiles("users"));
    }

    private function getUserByEmail(array $users, string $email): array {
        $email = strtolower($email);

        foreach ($users as $user) {
            if ($user["email"] === $email) {
                return ["result" => true, "user" => $user];
            }
        }

        return ["result" => false, "message" => "the_user_does_not_exist"];
    }
}