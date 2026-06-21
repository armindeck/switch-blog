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
?>

<div class="content">
    <h2 style="margin-bottom: 30px; font-size: 28px; font-weight: bold; color: var(--text-co);">📱 <?= language("follow_us") ?></h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 30px;">
        <!-- YouTube CTA -->
        <div style="background: var(--back-secondary); padding: 30px; border-radius: 12px; border: 2px solid var(--error-bg); text-align: center;">
            <div style="font-size: 48px; margin-bottom: 15px;">▶️</div>
            <h3 style="margin: 0 0 10px 0; font-size: 22px; color: var(--error-bg); font-weight: bold;">YouTube</h3>
            <p style="margin: 0 0 20px 0; font-size: 14px; color: var(--text-co-secondary); line-height: 1.6; opacity: 0.8;">
                <?= language("subscribe_youtube") ?>
            </p>
            <a href="<?= config("social")["youtube"] ?>" target="_blank" style="background: var(--error-bg); color: var(--error-co); padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                🔔 <?= language("subscribe") ?>
            </a>
        </div>

        <!-- Facebook CTA -->
        <div style="background: var(--back-secondary); padding: 30px; border-radius: 12px; border: 2px solid var(--button-bg); text-align: center;">
            <div style="font-size: 48px; margin-bottom: 15px;">👍</div>
            <h3 style="margin: 0 0 10px 0; font-size: 22px; color: var(--button-bg); font-weight: bold;">Facebook</h3>
            <p style="margin: 0 0 20px 0; font-size: 14px; color: var(--text-co-secondary); line-height: 1.6; opacity: 0.8;">
                <?= language("follow_facebook") ?>
            </p>
            <a href="<?= config("social")["facebook"] ?>" target="_blank" style="background: var(--button-bg); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                👍 <?= language("follow")?>
            </a>
        </div>
    </div>
</div>