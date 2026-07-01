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

?>
<div class="content">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 4px">
        <a href="../dashboard" style="background: var(--back-primary); color: var(--text-co); padding: 6px 12px; border: 1px solid var(--input-border-co); border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
            ← <?= language("back") ?>
        </a>
    </div>

    <!-- About me -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid rgba(0,0,0,.1); border-radius: 4px; margin: 4px 0px 6px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.2);">
            <strong><?= language("about_me") ?></strong>
        </div>
        <!-- Items -->
        <div style="padding: 4px 8px;">
            <small>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Possimus reiciendis ea nulla voluptatibus sequi, eos rerum quia, repellendus dolore ex sed blanditiis similique officiis cumque exercitationem aliquid perspiciatis consequatur necessitatibus.</small>
        </div>
    </div>
    
    <!-- Core -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid rgba(0,0,0,.1); border-radius: 4px; margin: 4px 0px 6px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.2);">
            <strong><?= language("core") ?></strong>
        </div>
        <!-- Items -->
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.1);">
            <small><?= language("creator") ?>:</small>
            <small><a href="<?= core("creator_url") ?>" target="_blank"><?= core("creator_name") ?></a></small>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.1);">
            <small><?= language("name") ?>:</small>
            <small><a href="<?= core("url") ?>" target="_blank"><?= core("name") ?></a></small>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.1);">
            <small><?= language("version") ?>:</small>
            <small><?= core("version") . "-" . core("state") ?></small>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px;">
            <small><?= language("date") ?>:</small>
            <small><?= core("created") . " ~ " . core("updated") ?></small>
        </div>
    </div>
    
    <!-- Social -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid rgba(0,0,0,.1); border-radius: 4px; margin: 4px 0px 6px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.2);">
            <strong><?= language("social_networks") ?></strong>
        </div>
        <!-- Items -->
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.1);">
            <small><?= language("personal") ?>:</small>
            <small><a href="https://dbproject.rf.gd" target="_blank">dbproject</a></small>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.1);">
            <small>GitHub:</small>
            <small><a href="<?= core("creator_url") ?>" target="_blank"><?= core("creator_name") ?></a></small>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.1);">
            <small>Facebook:</small>
            <small><a href="https://facebook.com/tobix64" target="_blank">Tobix64</a></small>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px;">
            <small>YouTube:</small>
            <small><a href="https://youtube.com/@tobix64" target="_blank">Tobix64</a></small>
        </div>
    </div>
    
    <!-- License -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid rgba(0,0,0,.1); border-radius: 4px; margin: 4px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid rgba(0,0,0,.2);">
            <strong><?= language("license") ?></strong>
        </div>
        <!-- Items -->
        <div style="font-size: small; color: var(--text-co); padding: 4px 8px;">
            <?php 
                echo MarkdownExtra::defaultTransform(file_exists(RAIZ . "LICENSE") ? htmlspecialchars(file_get_contents(RAIZ . "LICENSE") ?? "") : "");
            ?>
        </div>
    </div>
    <div style="margin-top: 16px; text-align: center;">
        <small>&copy; 2026 <?= core("creator_name") ?></small>
    </div>
</div>