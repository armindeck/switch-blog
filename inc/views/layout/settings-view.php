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

view("components/header", ["auth" => $auth, "view" => $view]);

$user_data = $model->allUser()[$user] ?? [];
?>
    <main class="main">
        <?php view("components/message"); ?>
        
        <!-- Account Info -->
        <div class="content">
            <h3><?= language("account_information") ?></h3>
            <table style="width: 100%; margin-bottom: 30px;">
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                    <td style="padding: 12px; font-weight: bold;"><?= language("user") ?></td>
                    <td style="padding: 12px;"><?= $user_data["user"] ?? "" ?></td>
                </tr>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.1); background: rgba(0,0,0,0.05);">
                    <td style="padding: 12px; font-weight: bold;"><?= language("name") ?></td>
                    <td style="padding: 12px;"><?= $user_data["name"] ?? "" ?></td>
                </tr>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                    <td style="padding: 12px; font-weight: bold;"><?= language("email") ?></td>
                    <td style="padding: 12px;"><?= $user_data["email"] ?? "" ?></td>
                </tr>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.1); background: rgba(0,0,0,0.05);">
                    <td style="padding: 12px; font-weight: bold;"><?= language("state") ?></td>
                    <td style="padding: 12px;">
                        <span style="background: <?= ($user_data["state"] ?? "") == "public" ? "#4CAF50" : "#2196F3" ?>; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <?= $user_data["state"] ?? "" ?>
                        </span>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                    <td style="padding: 12px; font-weight: bold;"><?= language("role") ?></td>
                    <td style="padding: 12px;"><?= $user_data["rol"] ?? "user" ?></td>
                </tr>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.1); background: rgba(0,0,0,0.05);">
                    <td style="padding: 12px; font-weight: bold;"><?= language("registered_date") ?></td>
                    <td style="padding: 12px;"><?= $user_data["date_registered"] ?? "" ?></td>
                </tr>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                    <td style="padding: 12px; font-weight: bold;"><?= language("last_login") ?></td>
                    <td style="padding: 12px;"><?= $user_data["date_login"] ?? "—" ?></td>
                </tr>
                <?php if(!empty($user_data["date_updated"])): ?>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.1); background: rgba(0,0,0,0.05);">
                    <td style="padding: 12px; font-weight: bold;"><?= language("updated_date") ?></td>
                    <td style="padding: 12px;"><?= $user_data["date_updated"] ?? "" ?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>

        <!-- Edit Profile -->
        <div class="content" id="edit-account">
            <h3><?= language("edit_profile") ?></h3>
            <form method="post" class="form">
                <input type="hidden" name="action" value="edit_profile">
                <input type="text" name="user" id="user" placeholder="<?= language("user") ?>" minlength="4" maxlength="25" value="<?= getValueTmp("user") ?: $user_data["user"] ?? "" ?>" required>
                <input type="text" name="name" id="name" placeholder="<?= language("name") ?>" minlength="4" maxlength="50" value="<?= getValueTmp("name") ?: $user_data["name"] ?? "" ?>" required>
                <input type="email" name="email" id="email" placeholder="<?= language("email") ?>" minlength="4" maxlength="150" value="<?= getValueTmp("email") ?: $user_data["email"] ?? "" ?>" required>
                <input type="password" name="password" placeholder="<?= language("password") ?>" minlength="8" maxlength="150" required>
                <button type="submit" name="update_profile" id="update_profile"><?= language("update") ?></button>
            </form>
        </div>

        <!-- Security Settings -->
        <div class="content" id="change-password">
            <h3><?= language("security_settings") ?></h3>
            
            <!-- Change Password -->
            <div style="margin-bottom: 25px;">
                <h4><?= language("change_password") ?></h4>
                <form method="post" class="form">
                    <input type="hidden" name="action" value="change_password">
                    <?php if($recover_account_by_pin): ?>
                        <p style="background: rgba(255, 193, 7, 0.1); padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                            <?= language("change_password_by_recovery_code") ?>
                        </p>
                    <?php endif; ?>
                    <?php if(!$recover_account_by_pin): ?>
                        <input type="password" name="current_password" id="current_password" placeholder="<?= language("current_password") ?>" minlength="8" maxlength="150" required>
                    <?php endif; ?>
                    <input type="password" name="new_password" id="new_password" placeholder="<?= language("new_password") ?>" minlength="8" maxlength="150" required>
                    <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="<?= language("confirm_password") ?>" minlength="8" maxlength="150" required>
                    <button type="submit" name="change_pass"><?= language("change_password") ?></button>
                </form>
            </div>

            <hr>

            <!-- Recovery Code -->
            <div style="margin-top: 25px;" id="recovery-code">
                <h4><?= language("recovery_code") ?></h4>
                <p style="font-size: 12px; opacity: 0.8; margin-bottom: 15px;"><?= language("recovery_code_description") ?></p>
                <p style="background: rgba(0,0,0,0.1); padding: 15px; border-radius: 8px; font-family: monospace; word-break: break-all; margin-bottom: 15px;">
                    <strong><?= $user_data["recovery_code"] ?? "" ?></strong>
                </p>
                <form method="post" class="form" style="display: flex; gap: 10px;">
                    <input type="hidden" name="action" value="new_recovery_code">
                    <input type="password" name="password" placeholder="<?= language("password") ?>" minlength="8" maxlength="150" required>
                    <button type="submit" name="new_code" style="flex: 1;"><?= language("generate_new_code") ?></button>
                </form>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="content" id="account-settings">
            <h3><?= language("account_settings") ?></h3>
            
            <!-- Danger Zone -->
            <div style="margin-top: 25px; padding: 20px; background: rgba(244, 67, 54, 0.1); border-left: 4px solid #f44336; border-radius: 8px;">
                <h4 style="color: #f44336; margin-top: 0;"><?= language("danger_zone") ?></h4>
                <p style="font-size: 12px; margin-bottom: 15px;"><?= language("delete_account_warning") ?></p>
                <form method="post" class="form">
                    <input type="hidden" name="action" value="delete_account">
                    <input type="password" name="password" placeholder="<?= language("password") ?>" minlength="8" maxlength="150" required>
                    <button type="submit" name="delete_account" style="background: #f44336;" onclick="return confirm('<?= language("confirm_delete_account") ?? "¿Realmente deseas eliminar tu cuenta? Esta acción no se puede deshacer." ?>');"><?= language("delete_account") ?? "Eliminar Cuenta" ?></button>
                </form>
            </div>
        </div>

        <!-- Account History -->
        <?php if(!empty($user_data["history"])): ?>
        <div class="content">
            <h3><?= language("account_history") ?></h3>
            <div class="p-8 scroll-auto">
                <table style="width: 100%; font-size: 12px;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(0,0,0,0.1);">
                            <td style="padding: 12px; font-weight: bold;"><?= language("date") ?></td>
                            <td style="padding: 12px; font-weight: bold;"><?= language("action") ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach (array_reverse($user_data["history"], true) as $date => $action): ?>
                        <tr <?= $i % 2 == 0 ? "style='background:rgba(0,0,0,.05);'" : "" ?> style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                            <td style="padding: 12px;"><?= htmlspecialchars($date) ?></td>
                            <td style="padding: 12px;">
                                <?php if(is_array($action)): ?>
                                    <strong><?= language("changes") ?>:</strong>
                                    <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                                        <?php foreach($action as $key => $value): ?>
                                        <li><?= htmlspecialchars($key) ?>: <?= htmlspecialchars($value) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <?= htmlspecialchars($action) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $i++; endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </main>
<?php view("components/footer"); ?>