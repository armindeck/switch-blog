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
    <!-- Javascript Scripts -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin: 0px 0px 6px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("javascript_scripts") ?></strong>
        </div>
        <!-- Items -->
        <form method="post" class="form" id="formProcess">
            <!-- Google -->
            <div style="margin-bottom: 20px;">
                <label for="scr_google" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    Google
                </label>
                <textarea name="scr_google" id="scr_google" placeholder="<?= language("enter_scripts_with_google") ?>" minlength="20" rows="8" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary); resize: vertical; font-family: 'Courier New', monospace;"><?= htmlspecialchars(config("scripts")["google"]["script"] ?? "") ?></textarea>
            </div>

            <!-- Important -->
            <div style="margin-bottom: 20px;">
                <label for="scr_important" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("important") ?>
                </label>
                <textarea name="scr_important" id="scr_important" placeholder="<?= language("enter_scripts_with_important") ?>" minlength="20" rows="8" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary); resize: vertical; font-family: 'Courier New', monospace;"><?= htmlspecialchars(config("scripts")["important"]["script"] ?? "") ?></textarea>
            </div>

            <!-- Other -->
            <div style="margin-bottom: 20px;">
                <label for="scr_other" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("other") ?>
                </label>
                <textarea name="scr_other" id="scr_other" placeholder="<?= language("enter_scripts_with_other") ?>" minlength="20" rows="8" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary); resize: vertical; font-family: 'Courier New', monospace;"><?= htmlspecialchars(config("scripts")["other"]["script"] ?? "") ?></textarea>
            </div>

            <!-- Enable Google Scripts -->
            <div style="margin-bottom: 20px;">
                <label for="enable_google_scripts" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("enable_google_scripts") ?>
                </label>
                <select name="enable_google_scripts" id="enable_google_scripts" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <?php
                    foreach (["" => "no", "1" => "yes"] as $key => $tz):
                        $selected = (config("scripts")["google"]["enable"] ?? false == $key) ? 'selected' : '';
                    ?>
                        <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Enable Important Scripts -->
            <div style="margin-bottom: 20px;">
                <label for="enable_important_scripts" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("enable_important_scripts") ?>
                </label>
                <select name="enable_important_scripts" id="enable_important_scripts" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <?php
                    foreach (["" => "no", "1" => "yes"] as $key => $tz):
                        $selected = (config("scripts")["important"]["enable"] ?? false == $key) ? 'selected' : '';
                    ?>
                        <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Enable Other Scripts -->
            <div style="margin-bottom: 20px;">
                <label for="enable_other_scripts" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                    <?= language("enable_other_scripts") ?>
                </label>
                <select name="enable_other_scripts" id="enable_other_scripts" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                    <?php
                    foreach (["" => "no", "1" => "yes"] as $key => $tz):
                        $selected = (config("scripts")["other"]["enable"] ?? false == $key) ? 'selected' : '';
                    ?>
                        <option value="<?= $key ?>" <?= $selected ?>><?= language($tz) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botones -->
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button type="submit" name="update_scripts" id="update_scripts" style="background: var(--success-bg); color: var(--success-co); padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
                    💾 <?= language("update") ?>
                </button>
                <a href="../dashboard" style="background: var(--back-primary); color: var(--text-co); padding: 12px 30px; border: 1px solid var(--input-border-co); border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; transition: all 0.3s ease;">
                    ← <?= language("cancel") ?>
                </a>
            </div>
        </form>
    </div>
</div>