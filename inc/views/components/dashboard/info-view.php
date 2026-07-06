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

echo $view_hero_two(
    language($get_section),
    route("dashboard")
);

?>
<div class="content" style="margin: 0;">
    <!-- About me -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin: 0px 0px 6px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("about_me") ?></strong>
        </div>
        <!-- Items -->
        <div style="padding: 4px 8px;">
            <small><?= language("switch_blog_info") ?></small>
        </div>
    </div>
    
    <!-- Core -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin: 4px 0px 6px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("core") ?></strong>
        </div>
        <!-- Items -->
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid var(--content-border-co);">
            <small><?= language("creator") ?>:</small>
            <small><a href="<?= core("creator_url") ?>" target="_blank"><?= core("creator_name") ?></a></small>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid var(--content-border-co);">
            <small><?= language("name") ?>:</small>
            <small><a href="<?= core("url") ?>" target="_blank"><?= core("name") ?></a></small>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid var(--content-border-co);">
            <small><?= language("version") ?>:</small>
            <small><?= core("version") . "-" . core("state") ?></small>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px;">
            <small><?= language("date") ?>:</small>
            <small><?= core("created") . " ~ " . core("updated") ?></small>
        </div>
    </div>
    
    <!-- Social -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin: 4px 0px 6px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("social_networks") ?></strong>
        </div>
        <!-- Items -->
         <?php foreach(core("social") ?? [] as $social) { ?>
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 4px 8px; border-bottom: 1px solid var(--content-border-co);">
                <small><?= $social["social_name"] ?>:</small>
                <small><a href="<?= $social["url"] ?>" target="_blank"><?= $social["name"] ?></a></small>
            </div>
        <?php } ?>
    </div>
    
    <!-- License -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin: 4px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("license") ?></strong>
        </div>
        <!-- Items -->
        <div style="font-size: small; color: var(--text-co); padding: 4px 8px;">
            <?php 
                echo MarkdownExtra::defaultTransform(file_exists(RAIZ . "LICENSE") ? htmlspecialchars(file_get_contents(RAIZ . "LICENSE") ?? "") : "");
            ?>
        </div>
    </div>
    
    <!-- Changelog -->
    <div style="display: flex; flex-direction: column; gap: 4px; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin: 4px 0px;">
        <!-- Title -->
        <div style="padding: 4px 8px; border-bottom: 1px solid var(--content-border-strong-co);">
            <strong><?= language("changelog") ?></strong>
        </div>
        <!-- Items -->
        <div style="font-size: small; color: var(--text-co); padding: 4px 8px;">
            <?php 
                echo MarkdownExtra::defaultTransform(file_exists(RAIZ . "CHANGELOG.md") ? htmlspecialchars(file_get_contents(RAIZ . "CHANGELOG.md") ?? "") : "");
            ?>
        </div>
    </div>

    <div style="margin: 25px 0px; text-align: center;">
        <small>&copy; 2026 <?= core("creator_name") ?></small>
    </div>
</div>