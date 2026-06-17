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

view("components/header", ["auth" => $auth, "view" => $view]);

$user_data = $model->allUser()[$user] ?? [];
$list = read(pathFiles("list")) ?? [];
$birthday = read(pathFiles("birthday")) ?? [];
$goals = read(pathFiles("goals")) ?? [];
$notes = read(pathFiles("notes")) ?? [];
$diary = read(pathFiles("diary")) ?? [];

$count_animelis = count($list[$user] ?? []);
$count_birthday = count($birthday[$user] ?? []);
$count_goals = count($goals[$user] ?? []);
$count_notes = count($notes[$user] ?? []);
$count_diary = count($diary[$user] ?? []);
?>
    <main class="main">
        <?php view("components/message"); ?>
        
        <!-- Profile Header -->
        <div class="content">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; border-radius: 10px; color: white; text-align: center; margin-bottom: 30px;">
                <h1 style="margin: 0 0 10px 0; font-size: 36px;"><?= $user_data["name"] ?? "" ?></h1>
                <p style="margin: 0 0 5px 0; font-size: 14px; opacity: 0.9;">@<?= $user_data["user"] ?? "" ?></p>
                <?php if($is_user_user): ?>
                    <div class="edit-profile">
                        <a href="<?= route("settings") ?>" style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 5px; color: white; text-decoration: none; font-size: 14px; transition: background 0.3s;"><?= language("settings") ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- User Stats -->
        <div class="content">
            <h3><?= language("statistics") ?? "Estadísticas" ?></h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 30px;">
                <div style="background: rgba(0,0,0,0.1); padding: 20px; border-radius: 8px; text-align: center;">
                    <h4 style="margin: 0; font-size: 24px;"><?= $count_animelis ?></h4>
                    <p style="margin: 5px 0 0 0; font-size: 12px;"><?= language("anipelis") ?></p>
                </div>
                <div style="background: rgba(0,0,0,0.1); padding: 20px; border-radius: 8px; text-align: center;">
                    <h4 style="margin: 0; font-size: 24px;"><?= $count_birthday ?></h4>
                    <p style="margin: 5px 0 0 0; font-size: 12px;"><?= language("birthday") ?></p>
                </div>
                <div style="background: rgba(0,0,0,0.1); padding: 20px; border-radius: 8px; text-align: center;">
                    <h4 style="margin: 0; font-size: 24px;"><?= $count_goals ?></h4>
                    <p style="margin: 5px 0 0 0; font-size: 12px;"><?= language("goals") ?></p>
                </div>
                <div style="background: rgba(0,0,0,0.1); padding: 20px; border-radius: 8px; text-align: center;">
                    <h4 style="margin: 0; font-size: 24px;"><?= $count_notes ?></h4>
                    <p style="margin: 5px 0 0 0; font-size: 12px;"><?= language("notes") ?></p>
                </div>
                <div style="background: rgba(0,0,0,0.1); padding: 20px; border-radius: 8px; text-align: center;">
                    <h4 style="margin: 0; font-size: 24px;"><?= $count_diary ?></h4>
                    <p style="margin: 5px 0 0 0; font-size: 12px;"><?= language("diary") ?></p>
                </div>
            </div>
        </div>
        <?php if($count_animelis): ?>
            <div class="content">
                <h3><?= language("anipelis") ?></h3>
            </div>
            <?php view("components/list", ["list_order_by_state" => $list_order_by_state, "user" => $user ?? false, "is_user_user" => false]); ?>
        <?php endif; ?>
    </main>
<?php view("components/footer"); ?>