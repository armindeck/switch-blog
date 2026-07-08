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
    language("upload_images"),
    route("dashboard")
);

$uploaded_files = $uploaded_files ?? [];
?>
<div class="content" style="margin: 0; display: flex; flex-direction: column; gap: 16px;">
    <form method="post" enctype="multipart/form-data" style="margin: 0; display: flex; flex-direction: column; gap: 16px;">
        <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px;">
            <div style="display: flex; flex-direction: column; gap: 8px; padding: 8px;">
                <label for="file" style="display: block; font-weight: bold; color: var(--text-co);">
                    <?= language("upload_images") ?>
                </label>
                <input type="file" name="files[]" id="file" multiple required accept="image/*" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                <small style="color: var(--text-co);"><?= language("allowed_image_types") ?></small>
                <button type="submit" name="upload_image" id="upload_image" style="background: var(--success-bg); color: var(--success-co); padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
                    ⬆️ <?= language("upload") ?>
                </button>
            </div>
        </div>
    </form>

    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px;">
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("uploaded_files") ?></strong>
        </div>
        <div style="padding: 8px; display: flex; flex-direction: column; gap: 8px;">
            <?php if (empty($uploaded_files)): ?>
                <small><?= language("no_uploaded_files") ?></small>
            <?php else: ?>
                <?php foreach ($uploaded_files as $file): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px; padding: 8px; border: 1px solid var(--content-border-co); border-radius: 6px;">
                        <div style="display: flex; flex-direction: column; gap: 2px; overflow: hidden;">
                            <strong style="word-break: break-all;"><?= htmlspecialchars($file["name"] ?? "") ?></strong>
                            <small><?= $file["size"] ?? "" ?> · <?= $file["date"] ?? "" ?></small>
                        </div>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="<?= $file["url"] ?? "" ?>" target="_blank" style="background: var(--back-secondary); color: var(--text-co); padding: 8px 12px; border-radius: 6px; text-decoration: none; font-weight: bold;">
                                👁️ <?= language("view") ?>
                            </a>
                            <form method="post" style="display: inline; margin: 0;" onsubmit="return confirm('<?= language("confirm_delete_file") ?>')">
                                <input type="hidden" name="file" value="<?= htmlspecialchars($file["name"] ?? "") ?>">
                                <button type="submit" name="delete_image" style="background: var(--danger-bg); color: var(--danger-co); padding: 8px 12px; border: none; border-radius: 6px; text-decoration: none; font-weight: bold; cursor: pointer; transition: all 0.3s ease;">
                                    🗑️ <?= language("delete") ?>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
