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

view("components/header", ["auth" => $user_auth]);

$sections = $dashboard_data["sections"] ?? [];
$section_data = $sections[$get_section] ?? [];

$isset_section = isset($sections[$get_section]);
$show_sections = empty($get_section) || !$isset_section;
$show_hero = $show_sections && !$isset_section;
$show_hero_two = !$show_hero && $isset_section;
$show_hero_not_found = $show_sections && !empty($get_section) && !$isset_section;

$show_view = !empty($get_section) && $isset_section;

$dir = get_slug() == "dashboard/" ? "../" : path_directory();
?>
    <main class="main">
        <?php view("components/message"); ?>

        <!-- Hero Dashboard -->
        <?php if($show_hero): ?>
        <div class="content">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 50px 40px; border-radius: 12px; color: white; text-align: center; box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);">
                <h1 style="margin: 0 0 15px 0; font-size: 42px; font-weight: bold; line-height: 1.2;">
                    <?= language("dashboard") ?>
                </h1>
                <p style="margin: 0; font-size: 16px; opacity: 0.95; max-width: 600px; margin-left: auto; margin-right: auto;">
                    <?= language("dashboard_description") ?>
                </p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Hero Section Dashboard -->
        <?php if($show_hero_two): ?>
        <div class="content">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 15px 40px; border-radius: 12px; color: white; text-align: center; box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);">
                <h1 style="font-size: 42px; font-weight: bold; line-height: 1.2;">
                    <?= language($section_data["name"] ?? "null") ?>
                </h1>
            </div>
        </div>
        <?php endif; ?>

        <!-- sección no encontrada -->
        <?php if($show_hero_not_found): ?>
        <div class="content">
            <div style="background: #f8d7da; padding: 25px; border-radius: 10px; text-align: center;">
                <h2 style="margin: 0 0 10px 0; font-size: 24px; color: #721c24;">404 - <?= language("section_not_found") ?></h2>
                <p style="margin: 0; font-size: 14px; color: #721c24;"><?= language("section_not_found_text") ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Sections cards -->
        <?php if($show_sections): ?>
        <div class="content">
            <h2 style="margin-bottom: 25px; font-size: 24px;"><?= language("sections") ?></h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 15px; margin-bottom: 30px;">
                <?php foreach ($sections as $key => $value): ?>
                <a href="<?= "{$dir}dashboard/{$value['id']}" ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: linear-gradient(135deg, <?= $value["bg"] ?>); padding: 25px; border-radius: 10px; text-align: center; border: 1px solid rgba(102, 126, 234, 0.2); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 32px; margin-bottom: 8px;"><?= $value["icon"] ?></div>
                        <p style="margin: 8px 0 0 0; font-size: 12px; opacity: 0.8;"><?= language($value["name"]) ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Section view -->
        <?php if($show_view) {
            view("components/dashboard/{$get_section}", array_merge($data_origin, ["data_origin" => $data_origin]));
        } ?>
    </main>
<?php view("components/footer"); ?>