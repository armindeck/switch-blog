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

view("components/header", ["auth" => $auth]);
?>
    <main class="main">
        <?php view("components/message"); ?>

        <?php if($post): ?>
            <div class="content">
                <!-- Header -->
                <a href="<?= route("home") ?>" style="color: var(--text-link-co); text-decoration: none; display: inline-flex; align-items: center; margin-bottom: 20px; font-size: 14px;">
                    ← <?= language("back") ?>
                </a>

                <!-- Post Container -->
                <article style="background: var(--back-secondary); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.15); padding: 0;">
                    <!-- Featured Image -->
                    <?php if(!empty($post["image"])): ?>
                        <div style="width: 100%; height: 400px; background: linear-gradient(135deg, var(--button-bg) 0%, var(--button-hover-bg) 100%); overflow: hidden; position: relative;">
                            <img src="<?= $post["image"] ?>" alt="<?= htmlspecialchars($post["title"]) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    <?php else: ?>
                        <div style="width: 100%; height: 400px; background: linear-gradient(135deg, var(--button-bg) 0%, var(--button-hover-bg) 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 80px;">📖</div>
                    <?php endif; ?>

                    <!-- Post Content -->
                    <div style="padding: 40px 30px;">
                        <!-- Category & Meta -->
                        <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                            <span style="display: inline-block; background: var(--button-bg); color: white; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                <?= language($post["category"] ?? "uncategorized") ?>
                            </span>
                            <span style="font-size: 12px; color: var(--text-co-secondary); opacity: 0.7;">
                                <?= date("d M Y", strtotime($post["date_published"])) ?>
                            </span>
                        </div>

                        <!-- Title -->
                        <h1 style="margin: 0 0 15px 0; font-size: 36px; font-weight: bold; color: var(--text-co); line-height: 1.3;">
                            <?= htmlspecialchars($post["title"]) ?>
                        </h1>

                        <!-- Author Info -->
                        <div style="margin-bottom: 30px; padding: 15px; background: var(--back-primary); border-radius: 8px; border-left: 4px solid var(--button-bg);">
                            <p style="margin: 0; font-size: 14px; color: var(--text-co-secondary);">
                                <strong><?= language("by") ?></strong> 
                                <a href="<?= route("p") ?>/<?= urlencode($post["author"]) ?>" style="color: var(--text-link-co); text-decoration: none;">
                                    <?= htmlspecialchars($post["author"]) ?>
                                </a>
                            </p>
                        </div>

                        <!-- Content -->
                        <div style="margin-bottom: 30px; font-size: 16px; line-height: 2.6; color: var(--text-co);">
                            <?php 
                                echo MarkdownExtra::defaultTransform($post["content"] ?? "");
                            ?>
                        </div>

                        <!-- Post Stats -->
                        <div style="border-top: 1px solid rgba(100, 181, 246, 0.2); padding-top: 20px; margin-top: 30px; display: flex; gap: 30px; align-items: center; font-size: 14px; color: var(--text-co-secondary); flex-wrap: wrap;">
                            <div>
                                <strong>👁️ <?= language("views") ?>:</strong> <?= $post["views"] ?? 0 ?>
                            </div>
                            <div>
                                <strong>❤️ <?= language("likes") ?>:</strong> <?= $post["likes"] ?? 0 ?>
                            </div>
                            
                            <?php if ($auth): ?>
                                <?php 
                                    $user_liked = in_array($user_auth, $post["liked_by"] ?? []);
                                ?>
                                <form method="POST" style="margin: 0; display: inline;">
                                    <input type="hidden" name="like_post" value="1">
                                    <input type="hidden" name="post_slug" value="<?= htmlspecialchars($post_slug) ?>">
                                    <button type="submit" style="background: <?= $user_liked ? 'var(--error-bg)' : 'var(--button-bg)' ?>; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: all 0.3s ease; font-size: 14px;">
                                        <?= $user_liked ? '❤️ ' . language("unlike") : '🤍 ' . language("like") ?>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php view("components/cta-social-follow"); ?>
                <!-- Navigation -->
                <div style="margin-top: 40px; padding: 20px; text-align: center;">
                    <a href="<?= route("home") ?>" style="background: var(--button-bg); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease;">
                        ← <?= language("back_to_posts") ?>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="content">
                <div style="background: var(--back-primary); padding: 60px 40px; border-radius: 12px; text-align: center;">
                    <h2 style="margin: 0 0 15px 0; font-size: 28px; font-weight: bold; color: var(--text-co);">
                        📭 <?= language("post_not_found") ?>
                    </h2>
                    <p style="margin: 0 0 25px 0; font-size: 16px; color: var(--text-co-secondary); opacity: 0.7;">
                        <?= language("post_not_found_text") ?>
                    </p>
                    <a href="<?= route("home") ?>" style="background: var(--button-bg); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease;">
                        ← <?= language("back_to_posts") ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </main>
<?php view("components/footer"); ?>
