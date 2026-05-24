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

view("components/header", ["auth" => $model->auth()]);
?>
    <main class="main">
        <?php view("components/message"); ?>
        <?php view("components/sections", ["section" => "notes"]); ?>
        <form class="form" method="post">
            <h2><?= language("notes") ?> (<?= language("private") ?>)</h2>
            <input type="text" name="title" id="title" placeholder="<?= language("title") ?>" title="<?= language("title") ?>" value="<?= getListValueGetTmp($list_only, "id", "title") ?>">
            <textarea rows="10" name="content" id="content" placeholder="<?= language("content") ?>" title="<?= language("content") ?>" required><?= getListValueGetTmp($list_only, "id", "content") ?></textarea>
            <button type="submit" name="add" id="add"><?= language(getListValueGetTmp($list_only, "id", "content") ? "edit" : "add") ?></button>
        </form>
        <hr>
        <div class="p-8 scroll-auto">
            <table>
                <thead>
                    <tr>
                        <td><?= language("notes") ?></td>
                        <td><?= language("action") ?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($list_only as $key => $value): ?>
                    <tr <?= $i % 2 == 0 ? "style='background:rgb(0,0,0,.1);'" : ""  ?>>
                        <td>
                            <strong><?= $value["title"] ?? "" ?></strong><br><br>
                            <p><?= MarkdownExtra::defaultTransform($value["content"] ?? "") ?></p>
                            <br><br>
                            <small style="opacity: 0.8; font-size: 12px;"><?= $value["date"] ?? "" ?></small>
                        </td>
                        <td>
                            <a href="?action=edit&id=<?= $key ?>">📝</a>
                            <a href="?action=delete&id=<?= $key ?>&confirm=1" onclick="return confirm('Quieres eliminar los datos de <?= $value["title"] ?? "" ?>');">❌</a>
                        </td>
                    </tr>
                    <?php $i++; endforeach ?>
                </tbody>
            </table>
        </div>
    </main>
<?php view("components/footer"); ?>