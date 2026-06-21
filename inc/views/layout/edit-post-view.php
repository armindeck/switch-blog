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

view("components/header", ["auth" => $auth]);
?>
    <main class="main">
        <?php view("components/message"); ?>

        <div class="content">
            <h1 style="margin-bottom: 30px; font-size: 32px; font-weight: bold; color: var(--text-co);">✏️ <?= language("edit_post") ?></h1>
            
            <form method="post" class="form" id="formProcess" style="max-width: 800px; margin: 0 auto;">
                <!-- Campo oculto con el ID del post y método -->
                <input type="hidden" name="post_id" value="<?= htmlspecialchars($post['id'] ?? '') ?>">

                <!-- Título -->
                <div style="margin-bottom: 20px;">
                    <label for="title" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                        <?= language("title") ?> *
                    </label>
                    <input type="text" name="title" id="title" placeholder="<?= language("enter_title") ?>" minlength="5" maxlength="200" required value="<?= htmlspecialchars($post['title'] ?? '') ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                </div>

                <!-- Categoría -->
                <div style="margin-bottom: 20px;">
                    <label for="category" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                        <?= language("category") ?> *
                    </label>
                    <select name="category" id="category" required style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                        <option value="">-- <?= language("select_category") ?> --</option>
                        <?php
                        $categories = ['General', 'Consejos', 'Comunidad', 'Tutorial', 'Noticias'];
                        foreach ($categories as $cat):
                            $selected = (isset($post['category']) && $post['category'] === $cat) ? 'selected' : '';
                        ?>
                            <option value="<?= $cat ?>" <?= $selected ?>><?= language(strtolower($cat)) ?? $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Extracto -->
                <div style="margin-bottom: 20px;">
                    <label for="excerpt" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                        <?= language("excerpt") ?> *
                    </label>
                    <textarea name="excerpt" id="excerpt" placeholder="<?= language("enter_excerpt") ?>" minlength="10" maxlength="250" rows="3" required style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary); resize: vertical;"><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
                </div>

                <!-- URL de Imagen -->
                <div style="margin-bottom: 20px;">
                    <label for="image" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                        <?= language("image_url") ?> (<?= language("optional") ?>)
                    </label>
                    <input type="url" name="image" id="image" placeholder="https://example.com/imagen.jpg" value="<?= htmlspecialchars($post['image'] ?? '') ?>" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                </div>

                <!-- Contenido -->
                <div style="margin-bottom: 20px;">
                    <label for="content" style="display: block; margin-bottom: 8px; font-weight: bold; color: var(--text-co);">
                        <?= language("content") ?> *
                    </label>
                    <textarea name="content" id="content" placeholder="<?= language("enter_content_and_markdown_is_supported") ?>" minlength="20" rows="12" required style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary); resize: vertical; font-family: 'Courier New', monospace;"><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
                    <small style="display: block; margin-top: 5px; color: var(--text-co-secondary); opacity: 0.7;">💡 <?= language("markdown_supported") ?></small>
                </div>

                <!-- Botones -->
                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button type="submit" name="update_post" id="update_post" style="background: var(--success-bg); color: var(--success-co); padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
                        💾 <?= language("update") ?>
                    </button>
                    <a href="<?= route("home") ?>" style="background: var(--back-primary); color: var(--text-co); padding: 12px 30px; border: 1px solid var(--input-border-co); border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; transition: all 0.3s ease;">
                        ← <?= language("cancel") ?>
                    </a>
                </div>
            </form>
        </div>
    </main>
<?php view("components/footer"); ?>