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

use Michelf\Markdown;
use Michelf\MarkdownExtra;

$add_or_edit = getListValueGetTmp($list_only, "id", "content") ? "edit" : "add";
$note_today = !empty($list_only[date_year_month_day()]);
$alert_note_exists_confirm = getValueTmpConfirm("alert_note_exists_confirm");
$list_quantity = count($list_only);
$sorted_list = $list_only;
uasort($sorted_list, function($a, $b) {
    return strtotime($b["date"] ?? "1970-01-01") - strtotime($a["date"] ?? "1970-01-01");
});

view("components/header", ["auth" => $model->auth()]);
?>
    <main class="main">
        <?php view("components/message"); ?>
        <?php view("components/sections", ["section" => "diary"]); ?>
        <form class="form" method="post">
            <h2><?= language("diary") ?> (<?= language("private") ?>)</h2>
            <?php if($alert_note_exists_confirm): ?>
                <label style="display: flex; justify-content: space-between; align-items: center; gap: 8px; background-color: red; color: white; padding: 8px; border-radius: 4px;">
                    <span><?= language("replace_note") ?>:</span>
                    <select name="replace_note" id="replace_note" required>
                        <option value=""><?= language("no") ?></option>
                        <option value="yes"><?= language("yes") ?></option>
                    </select>
                </label>
            <?php endif; ?>
            <input type="text" name="title" id="title" placeholder="<?= language("title") ?>" title="<?= language("title") ?>" value="<?= getListValueGetTmp($list_only, "id", "title") ?>" required>
            <textarea rows="10" name="content" id="content" placeholder="<?= language("content") ?>" title="<?= language("content") ?>" required><?= getListValueGetTmp($list_only, "id", "content") ?></textarea>
            <?php if($add_or_edit == "add" && $note_today): ?>
            <p style="color: black; font-size: 12px; background-color: yellow; padding: 8px; border-radius: 4px;">
                <?= language("diary_today_note") ?>
            </p>
            <?php endif ?>
            <hgroup style="display: flex; justify-content: space-between; align-items: center; gap: 8px;">
                <input type="date" name="date" id="date" placeholder="<?= language("date") ?>" title="<?= language("date") ?>" value="<?= getListValueGetTmp($list_only, "id", "date") ?>">
                <label for="auto_date">
                    <input class="inputCheckbox" type="checkbox" name="auto_date" id="auto_date" <?= $note_today || getListValueGetTmp($list_only, "id", "date") ? "" : "checked" ?>>
                    <?= language("auto_date") ?>
                </label>
            </hgroup>
            <?php if($add_or_edit == "edit"): ?>
                <input type="hidden" name="id" id="id" value="<?= getListValueGetTmp($list_only, "id", "id") ?>" readonly hidden>
            <?php endif; ?>
            <button type="submit" name="add" id="add" value="<?= $add_or_edit ?>"><?= language($add_or_edit) ?></button>
        </form>
        <?php if(!empty($sorted_list)): ?>
        <hr>
        <?php $i = 1; foreach ($sorted_list as $key => $value): ?>
        <div class="p-8">
            <h2>
                <?= $value["title"] ?? "" ?>
                <div style="float: right; font-size: 18px;">
                    <a href="?action=edit&id=<?= $key ?>">📝</a>
                    <a href="?action=delete&id=<?= $key ?>&confirm=1" onclick="return confirm('Quieres eliminar los datos de <?= $value["title"] ?? "" ?>');">❌</a>
                </div>
            </h2>
            <div style="opacity: 0.8; font-size: small; margin: 12px 0px;">
                <time datetime="<?= $value["date"] ?? "" ?>"><?= $value["date"] ?? "" ?></time>
            </div>
            <?= MarkdownExtra::defaultTransform($value["content"] ?? "") ?>
        </div>
        <?php if($i < $list_quantity){ echo "<hr>"; } $i++; endforeach ?>
        <?php endif; ?>
    </main>
<?php view("components/footer"); ?>