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

// Get user data if authenticated
$auth = $model->auth();
$user = $_SESSION["user"] ?? null;
$all_users = $model->allUser();
$user_data = $auth && $user ? $all_users[$user] ?? [] : [];

// Get statistics if authenticated
if ($auth && $user) {
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
}

$total_users = count($all_users);
?>
    <main class="main">
        <?php view("components/message"); ?>

        <!-- Hero Section -->
        <div class="content">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 50px 40px; border-radius: 12px; color: white; text-align: center; margin-bottom: 40px; box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);">
                <h1 style="margin: 0 0 15px 0; font-size: 42px; font-weight: bold; line-height: 1.2;">
                    <?php if($auth): ?>
                        <?= language("welcome") ?>, <?= $user_data["name"] ?? $user ?>!
                    <?php else: ?>
                        <?= language("welcome_to") ?> <?= config("app_name") ?> 
                    <?php endif; ?>
                </h1>
                <p style="margin: 0; font-size: 16px; opacity: 0.95; max-width: 600px; margin-left: auto; margin-right: auto;">
                    <?php if($auth): ?>
                        <?= language("organize_manage") ?>
                    <?php else: ?>
                        <?= language("join_community") ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- User Statistics (if authenticated) -->
        <?php if($auth && $user): ?>
        <div class="content">
            <h2 style="margin-bottom: 25px; font-size: 24px;"><?= language("your_statistics") ?? "Tus Estadísticas" ?></h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 15px; margin-bottom: 30px;">
                <a href="<?= route("anipelis") ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%); padding: 25px; border-radius: 10px; text-align: center; border: 1px solid rgba(102, 126, 234, 0.2); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 32px; margin-bottom: 8px;">📺</div>
                        <h3 style="margin: 0; font-size: 28px; font-weight: bold; color: #667eea;"><?= $count_animelis ?></h3>
                        <p style="margin: 8px 0 0 0; font-size: 12px; opacity: 0.8;"><?= language("anipelis") ?></p>
                    </div>
                </a>
                <a href="<?= route("birthday") ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: linear-gradient(135deg, rgba(244, 67, 54, 0.15) 0%, rgba(229, 57, 53, 0.15) 100%); padding: 25px; border-radius: 10px; text-align: center; border: 1px solid rgba(244, 67, 54, 0.2); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 32px; margin-bottom: 8px;">🎂</div>
                        <h3 style="margin: 0; font-size: 28px; font-weight: bold; color: #f44336;"><?= $count_birthday ?></h3>
                        <p style="margin: 8px 0 0 0; font-size: 12px; opacity: 0.8;"><?= language("birthday") ?></p>
                    </div>
                </a>
                <a href="<?= route("goals") ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: linear-gradient(135deg, rgba(76, 175, 80, 0.15) 0%, rgba(56, 142, 60, 0.15) 100%); padding: 25px; border-radius: 10px; text-align: center; border: 1px solid rgba(76, 175, 80, 0.2); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 32px; margin-bottom: 8px;">🎯</div>
                        <h3 style="margin: 0; font-size: 28px; font-weight: bold; color: #4caf50;"><?= $count_goals ?></h3>
                        <p style="margin: 8px 0 0 0; font-size: 12px; opacity: 0.8;"><?= language("goals") ?></p>
                    </div>
                </a>
                <a href="<?= route("notes") ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.15) 0%, rgba(251, 192, 2, 0.15) 100%); padding: 25px; border-radius: 10px; text-align: center; border: 1px solid rgba(255, 193, 7, 0.2); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 32px; margin-bottom: 8px;">📝</div>
                        <h3 style="margin: 0; font-size: 28px; font-weight: bold; color: #ffc107;"><?= $count_notes ?></h3>
                        <p style="margin: 8px 0 0 0; font-size: 12px; opacity: 0.8;"><?= language("notes") ?></p>
                    </div>
                </a>
                <a href="<?= route("diary") ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: linear-gradient(135deg, rgba(33, 150, 243, 0.15) 0%, rgba(21, 101, 192, 0.15) 100%); padding: 25px; border-radius: 10px; text-align: center; border: 1px solid rgba(33, 150, 243, 0.2); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 32px; margin-bottom: 8px;">📖</div>
                        <h3 style="margin: 0; font-size: 28px; font-weight: bold; color: #2196f3;"><?= $count_diary ?></h3>
                        <p style="margin: 8px 0 0 0; font-size: 12px; opacity: 0.8;"><?= language("diary") ?></p>
                    </div>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Quick Actions / Features -->
        <div class="content">
            <h2 style="margin-bottom: 25px; font-size: 24px;"><?= language("features") ?? "Características" ?></h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <div style="background: rgba(0,0,0,0.05); padding: 25px; border-radius: 12px; border-left: 4px solid #667eea;">
                    <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #667eea;">📺 <?= language("anipelis") ?></h3>
                    <p style="margin: 0; font-size: 14px; line-height: 1.6; opacity: 0.85;"><?= language("anipelis_description") ?></p>
                </div>
                <div style="background: rgba(0,0,0,0.05); padding: 25px; border-radius: 12px; border-left: 4px solid #f44336;">
                    <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #f44336;">🎂 <?= language("birthday") ?></h3>
                    <p style="margin: 0; font-size: 14px; line-height: 1.6; opacity: 0.85;"><?= language("birthday_description") ?></p>
                </div>
                <div style="background: rgba(0,0,0,0.05); padding: 25px; border-radius: 12px; border-left: 4px solid #4caf50;">
                    <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #4caf50;">🎯 <?= language("goals") ?></h3>
                    <p style="margin: 0; font-size: 14px; line-height: 1.6; opacity: 0.85;"><?= language("goals_description") ?></p>
                </div>
                <div style="background: rgba(0,0,0,0.05); padding: 25px; border-radius: 12px; border-left: 4px solid #ffc107;">
                    <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #ffc107;">📝 <?= language("notes") ?></h3>
                    <p style="margin: 0; font-size: 14px; line-height: 1.6; opacity: 0.85;"><?= language("notes_description") ?></p>
                </div>
                <div style="background: rgba(0,0,0,0.05); padding: 25px; border-radius: 12px; border-left: 4px solid #2196f3;">
                    <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #2196f3;">📖 <?= language("diary") ?></h3>
                    <p style="margin: 0; font-size: 14px; line-height: 1.6; opacity: 0.85;"><?= language("diary_description") ?></p>
                </div>
                <div style="background: rgba(0,0,0,0.05); padding: 25px; border-radius: 12px; border-left: 4px solid #9c27b0;">
                    <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #9c27b0;">👥 <?= language("community") ?? "Comunidad" ?></h3>
                    <p style="margin: 0; font-size: 14px; line-height: 1.6; opacity: 0.85;"><?= language("community_description") ?></p>
                </div>
            </div>
        </div>

        <!-- Community Stats -->
        <div class="content">
            <h2 style="margin-bottom: 25px; font-size: 24px;"><?= language("community_stats") ?? "Estadísticas de la Comunidad" ?></h2>
            <div style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); padding: 35px; border-radius: 12px; border: 1px solid rgba(102, 126, 234, 0.2); text-align: center;">
                <h3 style="margin: 0 0 10px 0; font-size: 36px; font-weight: bold; color: #667eea;"><?= $total_users ?></h3>
                <p style="margin: 0; font-size: 16px; opacity: 0.8;"><?= language("registered_users_in_the_community") ?></p>
            </div>
        </div>

        <!-- CTA if not authenticated -->
        <?php if(!$auth): ?>
        <div class="content">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; border-radius: 12px; color: white; text-align: center; margin-bottom: 30px;">
                <h2 style="margin: 0 0 15px 0; font-size: 28px;"><?= language("ready") ?? "¿Listo para comenzar?" ?></h2>
                <p style="margin: 0 0 25px 0; font-size: 16px; opacity: 0.95;"><?= language("join_community_message") ?></p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?= route("login") ?>" style="background: white; color: #667eea; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease;">
                        <?= language("login") ?? "Iniciar Sesión" ?>
                    </a>
                    <a href="<?= route("register") ?>" style="background: rgba(255,255,255,0.2); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; border: 2px solid white; transition: all 0.3s ease;">
                        <?= language("register") ?? "Registrarse" ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>
<?php view("components/footer"); ?>