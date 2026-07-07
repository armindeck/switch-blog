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

$social_list = config("social") ?? [];
?>

<!-- Social Networks -->
<form method="post" id="formProcess" class="content" style="margin: 0; display: flex; flex-direction: column; gap: 16px;">
    
    <!-- Mostrar/ocultar sección -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px;">
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("social_networks") ?></strong>
        </div>
        <div style="padding: 12px; display: flex; flex-direction: column; gap: 8px;">
            <label for="show_social_cta" style="display: block; font-weight: bold; color: var(--text-co);">
                <?= language("show_social_cta") ?>
            </label>
            <select name="show_social_cta" id="show_social_cta" style="width: 100%; padding: 12px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 8px; font-family: var(--font-primary);">
                <?php foreach(["0" => "no", "1" => "yes"] as $key => $value): ?>
                    <option value="<?= $key ?>" <?= ((config("show_social_cta") ?? true) == $key) ? "selected" : "" ?>><?= language($value) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Tabla de Redes Sociales -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("social_networks") ?></strong>
        </div>

        <!-- Tabla de redes sociales -->
        <div style="overflow-x: auto; padding: 12px;">
            <table style="width: 100%; border-collapse: collapse; min-width: 1200px;">
                <thead>
                    <tr style="background: var(--back-secondary); border-bottom: 2px solid var(--content-border-strong-co);">
                        <th style="padding: 10px; text-align: left; color: var(--text-co); font-weight: bold; border: 1px solid var(--content-border-co);"><?= language("id") ?></th>
                        <th style="padding: 10px; text-align: left; color: var(--text-co); font-weight: bold; border: 1px solid var(--content-border-co);"><?= language("emoji") ?></th>
                        <th style="padding: 10px; text-align: left; color: var(--text-co); font-weight: bold; border: 1px solid var(--content-border-co);"><?= language("name") ?></th>
                        <th style="padding: 10px; text-align: left; color: var(--text-co); font-weight: bold; border: 1px solid var(--content-border-co);"><?= language("color") ?></th>
                        <th style="padding: 10px; text-align: left; color: var(--text-co); font-weight: bold; border: 1px solid var(--content-border-co);"><?= language("text_color") ?></th>
                        <th style="padding: 10px; text-align: left; color: var(--text-co); font-weight: bold; border: 1px solid var(--content-border-co);"><?= language("label") ?></th>
                        <th style="padding: 10px; text-align: left; color: var(--text-co); font-weight: bold; border: 1px solid var(--content-border-co);"><?= language("button_emoji") ?></th>
                        <th style="padding: 10px; text-align: left; color: var(--text-co); font-weight: bold; border: 1px solid var(--content-border-co);"><?= language("button_text") ?></th>
                        <th style="padding: 10px; text-align: left; color: var(--text-co); font-weight: bold; border: 1px solid var(--content-border-co);"><?= language("url") ?></th>
                        <th style="padding: 10px; text-align: center; color：var(--text-co); font-weight：bold; border：1px solid var(--content-border-co);"><?= language("actions") ?></th>
                    </tr>
                </thead>
                <tbody id="social_tbody">
                    <?php foreach($social_list as $id => $social): ?>
                        <tr style="border-bottom: 1px solid var(--content-border-co);" class="social-row">
                            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_id[]" value="<?= htmlspecialchars($id) ?>" placeholder="youtube" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
                            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_emoji[]" value="<?= htmlspecialchars($social["emoji"] ?? "") ?>" placeholder="▶️" maxlength="2" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
                            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_name[]" value="<?= htmlspecialchars($social["name"] ?? "") ?>" placeholder="YouTube" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
                            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_color[]" value="<?= htmlspecialchars($social["color"] ?? "") ?>" placeholder="#ff0000" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
                            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_text_color[]" value="<?= htmlspecialchars($social["text_color"] ?? "") ?>" placeholder="white" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
                            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_label[]" value="<?= htmlspecialchars($social["label"] ?? "") ?>" placeholder="follow_youtube" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
                            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_button_emoji[]" value="<?= htmlspecialchars($social["button_emoji"] ?? "") ?>" placeholder="🔔" maxlength="2" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
                            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_button_text[]" value="<?= htmlspecialchars($social["button_text"] ?? "") ?>" placeholder="subscribe" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
                            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="url" name="social_url[]" value="<?= htmlspecialchars($social["url"] ?? "") ?>" placeholder="https://youtube.com/@channel" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
                            <td style="padding: 10px; border: 1px solid var(--content-border-co); text-align: center;"><button type="button" class="delete-row" style="background: var(--error-bg); color: var(--error-co); padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">X</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Agregar nueva red social -->
        <div style="padding: 12px; background: var(--back-secondary); border-top: 1px solid var(--content-border-co); display: flex; gap: 10px;">
            <button type="button" id="add_social" style="background: #4caf50; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; transition: all 0.3s ease;">
                ➕ <?= language("add_social_network") ?>
            </button>
        </div>
    </div>
    
    <!-- Botones -->
    <div style="display: flex; gap: 15px; margin-top: 30px;">
        <button type="submit" name="update_social" id="update_social" style="background: var(--success-bg); color: var(--success-co); padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
            💾 <?= language("update") ?>
        </button>
        <a href="<?= route("dashboard") ?>" style="background: var(--back-primary); color: var(--text-co); padding: 12px 30px; border: 1px solid var(--input-border-co); border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; transition: all 0.3s ease;">
            ← <?= language("cancel") ?>
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('social_tbody');
    const addBtn = document.getElementById('add_social');

    // Agregar nueva fila
    addBtn.addEventListener('click', function() {
        const row = document.createElement('tr');
        row.className = 'social-row';
        row.style.borderBottom = '1px solid var(--content-border-co)';
        row.innerHTML = `
            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_id[]" placeholder="instagram" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_emoji[]" placeholder="📷" maxlength="2" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_name[]" placeholder="Instagram" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_color[]" placeholder="#E4405F" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_text_color[]" placeholder="white" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_label[]" placeholder="follow_instagram" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_button_emoji[]" placeholder="📸" maxlength="2" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="text" name="social_button_text[]" placeholder="follow" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
            <td style="padding: 10px; border: 1px solid var(--content-border-co);"><input type="url" name="social_url[]" placeholder="https://instagram.com/yourprofile" style="width: 100%; padding: 8px; border: 1px solid var(--input-border-co); background: var(--input-bg); color: var(--input-co); border-radius: 4px;"></td>
            <td style="padding: 10px; border: 1px solid var(--content-border-co); text-align: center;"><button type="button" class="delete-row" style="background: var(--error-bg); color: var(--error-co); padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">❌</button></td>
        `;
        tbody.appendChild(row);
        attachDeleteListener(row.querySelector('.delete-row'));
    });

    // Eliminar fila
    function attachDeleteListener(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            row.remove();
        });
    }

    // Agregar listeners a botones existentes
    document.querySelectorAll('.delete-row').forEach(btn => {
        attachDeleteListener(btn);
    });
});
</script>
