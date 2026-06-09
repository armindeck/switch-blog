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

view("components/header", ["auth" => $model->auth()]);
?>
    <main class="main">
        <?php view("components/message"); ?>
        <?php view("components/sections", ["section" => "birthday"]); ?>
        <form class="form" method="post">
            <h2><?= language("dates-of-birth") ?> (<?= language("private") ?>)</h2>
            <input type="text" name="name" id="name" value="<?= getListValueGetTmp($list_only, "id", "name") ?>" placeholder="<?= language("name") ?>" title="<?= language("name") ?>" required>
            <input type="date" name="date" id="date" value="<?= getListValueGetTmp($list_only, "id", "date") ?>" title="<?= language("date") ?>" required>
            <button type="submit" name="add" id="add"><?= language(getListValueGetTmp($list_only, "id", "name") ? "edit" : "add") ?></button>
        </form>
        <?php if(!empty($list_only)): ?>
        <hr>
        <div class="p-8 scroll-auto">
            <table>
                <thead>
                    <tr>
                        <td><?= language("name") ?></td>
                        <td><?= language("date") ?></td>
                        <td><?= language("action") ?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($list_only as $key => $value): ?>
                    <tr <?= $i % 2 == 0 ? "style='background:rgb(0,0,0,.1);'" : ""  ?>>
                        <td><?= $value["name"] ?></td>
                        <td title="<?= $value["date"] ?>"><?= strDate($value["date"]) ?></td>
                        <td class="flex flex-evenly gap-4">
                            <a href="?action=edit&id=<?= $key ?>">📝</a>
                            <a href="?action=delete&id=<?= $key ?>&confirm=1" onclick="return confirm('Quieres eliminar los datos de <?= $value["name"] ?>');">❌</a>
                        </td>
                    </tr>
                    <?php $i++; endforeach ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </main>
<?php view("components/footer"); ?>