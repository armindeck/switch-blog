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

// Obtener las redes sociales desde config
$social_networks = config("social") ?? [];
$show_social_cta = config("show_social_cta") ?? true;
?>

<?php if($show_social_cta): ?>
<!-- Vista pública -->
<div class="content">
    <h2 style="margin-bottom: 30px; font-size: 28px; font-weight: bold; color: var(--text-co);">📱 <?= language("follow_us") ?></h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 30px;">
        <?php foreach($social_networks as $id => $social): ?>
            <?php if(!empty($social["url"])): ?>
                <div style="background: var(--back-secondary); padding: 18px 16px; border-radius: 12px; border: 2px solid <?= htmlspecialchars($social["color"]) ?>; text-align: center; min-height: 220px; display: flex; flex-direction: column; justify-content: center;">
                    <div style="font-size: 36px; margin-bottom: 10px;"><?= htmlspecialchars($social["emoji"]) ?></div>
                    <h3 style="margin: 0 0 8px 0; font-size: 18px; color: <?= htmlspecialchars($social["color"]) ?>; font-weight: bold;"><?= htmlspecialchars($social["name"]) ?></h3>
                    <p style="margin: 0 0 12px 0; font-size: 13px; color: var(--text-co-secondary); line-height: 1.5; opacity: 0.8;">
                        <?= language($social["label"] ?? "follow") ?>
                    </p>
                    <a href="<?= htmlspecialchars($social["url"]) ?>" target="_blank" style="background: <?= htmlspecialchars($social["color"]) ?>; color: <?= htmlspecialchars($social["text_color"]) ?>; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 13px;">
                        <?= htmlspecialchars($social["button_emoji"]) ?> <?= language($social["button_text"] ?? "follow") ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>