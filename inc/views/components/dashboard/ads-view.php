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
<!-- Ads -->
<form method="post" id="formProcess" class="content" style="margin: 0; display: flex; flex-direction: column; gap: 16px;">
    <!-- Moving Message -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("moving_message") ?></strong>
        </div>
        <!-- Moving message -->
        <div style="display: flex; flex-direction: column; gap: 8px; padding: 4px 6px;">
            <!-- Content moving message -->
            <!--
            <label for="content_moving_message" style="display: block; font-weight: bold; color: var(--text-co);">
                <?= language("content") ?>
            </label>
            -->
            <textarea name="content_moving_message" id="content_moving_message" placeholder="<?= language("enter_moving_message") ?>" minlength="20" rows="8" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary); resize: vertical; font-family: 'Courier New', monospace;"><?= htmlspecialchars(config("ads")["moving"]["content"] ?? "") ?></textarea>
            
            <!-- Moving message URL -->
            <label for="url_moving_message" style="display: block; font-weight: bold; color: var(--text-co);">
                <?= language("url_moving_message") ?>
            </label>
            <input type="url_moving_message" name="url_moving_message" id="url_moving_message" placeholder="<?= language("enter_url_moving_message") ?>" minlength="10" maxlength="250" value="<?= htmlspecialchars(config("ads")["moving"]["url"] ?? "") ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            
            <!-- Open in new tab -->
            <label for="new_tab_moving_message" style="display: block; font-weight: bold; color: var(--text-co);">
                <?= language("open_in_new_tab") ?>
            </label>
            <select name="new_tab_moving_message" id="new_tab_moving_message" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                <?php
                foreach (["" => "no", "1" => "yes"] as $key => $tz):
                    $selected = (config("ads")["moving"]["new_tab"] ?? false == $key) ? 'selected' : '';
                ?>
                    <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Enable moving message -->
            <label for="enable_moving_message" style="display: block; font-weight: bold; color: var(--text-co);">
                <?= language("show_moving_message") ?>
            </label>
            <select name="enable_moving_message" id="enable_moving_message" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                <?php
                foreach (["" => "no", "1" => "yes"] as $key => $tz):
                    $selected = (config("ads")["moving"]["enable"] ?? false == $key) ? 'selected' : '';
                ?>
                    <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Banner -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("banner") ?></strong>
        </div>
        <!-- Banner -->
        <div style="display: flex; flex-direction: column; gap: 8px; padding: 4px 6px;">
        <!-- Banner image -->
            <label for="url_banner_image" style="display: block; font-weight: bold; color: var(--text-co);">
                <?= language("url_banner_image") ?>
            </label>
            <input type="url_banner_image" name="url_banner_image" id="url_banner_image" placeholder="<?= language("enter_url_banner_image") ?>" minlength="10" maxlength="250" value="<?= htmlspecialchars(config("ads")["banner"]["image"] ?? "") ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            
            <!-- Banner URL -->
            <label for="url_banner_link" style="display: block; font-weight: bold; color: var(--text-co);">
                <?= language("url_banner") ?>
            </label>
            <input type="url_banner_link" name="url_banner_link" id="url_banner_link" placeholder="<?= language("enter_url_banner") ?>" minlength="10" maxlength="250" value="<?= htmlspecialchars(config("ads")["banner"]["url"] ?? "") ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
            
            <!-- Open in new tab -->
            <label for="new_tab_banner" style="display: block; font-weight: bold; color: var(--text-co);">
                <?= language("open_in_new_tab") ?>
            </label>
            <select name="new_tab_banner" id="new_tab_banner" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                <?php
                foreach (["" => "no", "1" => "yes"] as $key => $tz):
                    $selected = (config("ads")["banner"]["new_tab"] ?? false == $key) ? 'selected' : '';
                ?>
                    <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Enable banner -->
            <label for="enable_banner" style="display: block; font-weight: bold; color: var(--text-co);">
                <?= language("show_banner") ?>
            </label>
            <select name="enable_banner" id="enable_banner" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                <?php
                foreach (["" => "no", "1" => "yes"] as $key => $tz):
                    $selected = (config("ads")["banner"]["enable"] ?? false == $key) ? 'selected' : '';
                ?>
                    <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Botones -->
    <div style="display: flex; gap: 15px; margin-top: 30px;">
        <button type="submit" name="update_ads" id="update_ads" style="background: var(--success-bg); color: var(--success-co); padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
            💾 <?= language("update") ?>
        </button>
        <a href="../dashboard" style="background: var(--back-primary); color: var(--text-co); padding: 12px 30px; border: 1px solid var(--input-border-co); border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; transition: all 0.3s ease;">
            ← <?= language("cancel") ?>
        </a>
    </div>
</form>