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

echo $view_hero_two(
    language($get_section),
    route("dashboard")
);

?>
<div class="content" style="margin: 0;">
    <!-- Settings -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin: 0px 0px 6px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("settings") ?></strong>
        </div>
        <!-- Items -->
        <form method="post" class="form" id="formProcess">
            <!-- Page name -->
            <div style="margin-bottom: 20px;">
                <label for="name" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("page_name") ?> *
                </label>
                <input type="text" name="name" id="name" placeholder="<?= language("enter_page_name") ?>" minlength="2" maxlength="200" required value="<?= htmlspecialchars(config("name")) ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- Page link -->
            <div style="margin-bottom: 20px;">
                <label for="url" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("page_url") ?> *
                </label>
                <input type="url" name="url" id="url" placeholder="<?= language("enter_page_url") ?>" minlength="10" maxlength="250" required value="<?= htmlspecialchars(config("url")) ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- Page description -->
            <div style="margin-bottom: 20px;">
                <label for="description" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("page_description") ?>
                </label>
                <input type="text" name="description" id="description" placeholder="<?= language("enter_page_description") ?>" minlength="5" maxlength="200" value="<?= htmlspecialchars(config("description")) ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- Time zone -->
            <div style="margin-bottom: 20px;">
                <label for="timezone" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("timezone") ?> *
                </label>
                <select name="timezone" id="timezone" required style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <option value="">-- <?= language("select_timezone") ?> --</option>
                    <?php
                    foreach ($timezone ?? [] as $tz):
                        $selected = (config("timezone") === $tz) ? 'selected' : '';
                    ?>
                        <option value="<?= $tz ?>" <?= $selected ?>><?= $tz ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Year of page publication -->
            <div style="margin-bottom: 20px;">
                <label for="year_of_page_publication" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("year_of_page_publication") ?> *
                </label>
                <input type="number" name="year" id="year_of_page_publication" placeholder="<?= language("enter_year_of_page_publication") ?>" minlength="4" maxlength="200" required value="<?= htmlspecialchars(config("year")) ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- Language -->
            <div style="margin-bottom: 20px;">
                <label for="language" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("language") ?> *
                </label>
                <select name="language" id="language" required style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <option value="">-- <?= language("select_language") ?> --</option>
                    <?php
                    foreach (core("languages") as $tz):
                        $selected = (config("language") === $tz) ? 'selected' : '';
                    ?>
                        <option value="<?= $tz ?>" <?= $selected ?>><?= $tz ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Themes -->
            <div style="margin-bottom: 20px;">
                <label for="theme" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("theme") ?> *
                </label>
                <select name="theme" id="theme" required style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <option value="">-- <?= language("select_theme") ?> --</option>
                    <?php
                    foreach (core("themes") as $tz):
                        $selected = (config("theme") === $tz) ? 'selected' : '';
                    ?>
                        <option value="<?= $tz ?>" <?= $selected ?>><?= $tz ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Captcha public key -->
            <div style="margin-bottom: 20px;">
                <label for="captcha_public_key" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("captcha_public_key") ?>
                </label>
                <input type="text" name="captcha_public_key" id="captcha_public_key" placeholder="<?= language("enter_captcha_public_key") ?>" minlength="5" maxlength="200" value="<?= htmlspecialchars(config("captcha")["public"]) ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- Captcha private key -->
            <div style="margin-bottom: 20px;">
                <label for="captcha_private_key" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("captcha_private_key") ?>
                </label>
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="password" name="captcha_private_key" id="captcha_private_key" placeholder="<?= language("enter_captcha_private_key") ?>" minlength="5" maxlength="200" value="<?= htmlspecialchars(config("captcha")["private"]) ?>" style="width: 100%; padding: 12px 48px 12px 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <button type="button" onclick="togglePasswordVisibility('captcha_private_key')" style="position: absolute; right: 10px; background: transparent; border: none; color: var(--text-co); cursor: pointer; font-size: 16px;">
                        👁️
                    </button>
                </div>
            </div>

            <script>
                function togglePasswordVisibility(inputId) {
                    const input = document.getElementById(inputId);
                    if (!input) return;

                    input.type = input.type === 'password' ? 'text' : 'password';
                }
            </script>

            <!-- Botones -->
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button type="submit" name="update_settings" id="update_settings" style="background: var(--success-bg); color: var(--success-co); padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
                    💾 <?= language("update") ?>
                </button>
                <a href="../dashboard" style="background: var(--back-primary); color: var(--text-co); padding: 12px 30px; border: 1px solid var(--input-border-co); border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; transition: all 0.3s ease;">
                    ← <?= language("cancel") ?>
                </a>
            </div>
        </form>
    </div>

    <!-- Htaccess -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin: 0px 0px 6px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong>HTACCESS</strong>
        </div>
        <!-- Items -->
        <form method="post" class="form" id="formProcess">
            <!-- 400 - Bad Request -->
            <div style="margin-bottom: 20px;">
                <label for="error_link_400" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    400 - <?= language("bad_request") ?> *
                </label>
                <input type="url" name="error_link_400" id="error_link_400" placeholder="<?= language("enter_link") ?>" minlength="5" maxlength="200" required value="<?= htmlspecialchars(config("error_link")["400"] ?? "") ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- 401 - Unauthorized -->
            <div style="margin-bottom: 20px;">
                <label for="error_link_401" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    401 - <?= language("unauthorized") ?> *
                </label>
                <input type="url" name="error_link_401" id="error_link_401" placeholder="<?= language("enter_link") ?>" minlength="5" maxlength="200" required value="<?= htmlspecialchars(config("error_link")["401"] ?? "") ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- 403 - Forbidden -->
            <div style="margin-bottom: 20px;">
                <label for="error_link_403" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    403 - <?= language("forbidden") ?> *
                </label>
                <input type="url" name="error_link_403" id="error_link_403" placeholder="<?= language("enter_link") ?>" minlength="5" maxlength="200" required value="<?= htmlspecialchars(config("error_link")["403"] ?? "") ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- 404 - Not Found -->
            <div style="margin-bottom: 20px;">
                <label for="error_link_404" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    404 - <?= language("not_found") ?> *
                </label>
                <input type="url" name="error_link_404" id="error_link_404" placeholder="<?= language("enter_link") ?>" minlength="5" maxlength="200" required value="<?= htmlspecialchars(config("error_link")["404"] ?? "") ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- 500 - Internal Server Error -->
            <div style="margin-bottom: 20px;">
                <label for="error_link_500" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    500 - <?= language("internal_server_error") ?> *
                </label>
                <input type="url" name="error_link_500" id="error_link_500" placeholder="<?= language("enter_link") ?>" minlength="5" maxlength="200" required value="<?= htmlspecialchars(config("error_link")["500"] ?? "") ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- 503 - Service Unavailable -->
            <div style="margin-bottom: 20px;">
                <label for="error_link_503" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    503 - <?= language("service_unavailable") ?> *
                </label>
                <input type="url" name="error_link_503" id="error_link_503" placeholder="<?= language("enter_link") ?>" minlength="5" maxlength="200" required value="<?= htmlspecialchars(config("error_link")["503"] ?? "") ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            </div>

            <!-- Enable time zone -->
            <div style="margin-bottom: 20px;">
                <label for="enable_timezone" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("enable_timezone") ?>
                </label>
                <select name="enable_timezone" id="enable_timezone" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <?php
                    foreach (["" => "no", "1" => "yes"] as $key => $tz):
                        $selected = (config("enable_timezone") == $key) ? 'selected' : '';
                    ?>
                        <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Enable SSL HTTPS -->
            <div style="margin-bottom: 20px; background-color: rgba(255, 0, 0, .1); border-radius: 4px; padding: 4px 6px;">
                <label for="enable_ssl_https" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("enable_ssl_https") ?>
                </label>
                <small><?= language("enable_ssl_https_description") ?></small>
                <select name="enable_ssl_https" id="enable_ssl_https" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <?php
                    foreach (["" => "no", "1" => "yes"] as $key => $tz):
                        $selected = (config("enable_ssl_https") == $key) ? 'selected' : '';
                    ?>
                        <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Show errors -->
            <div style="margin-bottom: 20px; background-color: rgba(255, 0, 0, .1); border-radius: 4px; padding: 4px 6px;">
                <label for="show_errors" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("show_errors") ?>
                </label>
                <small><?= language("enable_show_error_description") ?></small>
                <select name="show_errors" id="show_errors" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <?php
                    foreach (["" => "no", "1" => "yes"] as $key => $tz):
                        $selected = (config("show_errors") == $key) ? 'selected' : '';
                    ?>
                        <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botones -->
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button type="submit" name="update_settings_htaccess" id="update_settings_htaccess" style="background: var(--success-bg); color: var(--success-co); padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
                    💾 <?= language("update") ?>
                </button>
                <a href="../dashboard" style="background: var(--back-primary); color: var(--text-co); padding: 12px 30px; border: 1px solid var(--input-border-co); border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; transition: all 0.3s ease;">
                    ← <?= language("cancel") ?>
                </a>
            </div>
        </form>
    </div>
</div>