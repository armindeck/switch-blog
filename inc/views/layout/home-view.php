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

// Get authentication and user data
$user = $_SESSION["user"] ?? null;
$user_data = $auth && $user ? $all_users[$user] ?? [] : [];

// Get all published blog posts
$published_posts = array_filter($blog_data, function($post) {
    return ($post["status"] ?? "") === "published";
});

// Sort by date (newest first)
usort($published_posts, function($a, $b) {
    return strtotime($b["date_published"]) - strtotime($a["date_published"]);
});

$total_users = count($all_users);
$total_posts = count($published_posts);
?>
    <main class="main">
        <?php view("components/message"); ?>

        <!-- Published Blog Posts -->
        <div class="content">
            <h2 style="margin-bottom: 30px; font-size: 28px; font-weight: bold; color: var(--text-co);">✨ <?= language("latest_posts") ?></h2>
            
            <?php if(count($published_posts) > 0): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; margin-bottom: 40px;">
                    <?php foreach($published_posts as $post): 
                        $date = date("d M Y", strtotime($post["date_published"]));
                        $author = $post["author"] ?? language("author");
                        $category = language($post["category"] ?? "uncategorized");
                        $post_slug = $post["slug"] ?? "";
                    ?>
                        <a href="<?= route("blog") ?>/<?= urlencode($post_slug) ?>" style="text-decoration: none; color: inherit; display: flex; flex-direction: column;">
                            <div style="background: var(--back-secondary); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease; cursor: pointer; display: flex; flex-direction: column; height: 100%; border: 1px solid rgba(100, 181, 246, 0.2); hover: transform 0.3s ease;">
                                <!-- Image -->
                                <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--button-bg) 0%, var(--button-hover-bg) 100%); overflow: hidden; position: relative;">
                                    <?php if(!empty($post["image"])): ?>
                                        <img src="<?= $post["image"] ?>" alt="<?= htmlspecialchars($post["title"]) ?>" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                                    <?php else: ?>
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">📖</div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Content -->
                                <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                                    <!-- Category Badge -->
                                    <div style="margin-bottom: 10px;">
                                        <span style="display: inline-block; background: var(--button-bg); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                            <?= htmlspecialchars($category) ?>
                                        </span>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h3 style="margin: 0 0 10px 0; font-size: 18px; font-weight: bold; color: var(--text-co); line-height: 1.4;">
                                        <?= htmlspecialchars($post["title"]) ?>
                                    </h3>
                                    
                                    <!-- Excerpt -->
                                    <p style="margin: 0 0 15px 0; font-size: 14px; color: var(--text-co-secondary); line-height: 1.6; flex: 1; opacity: 0.8;">
                                        <?= htmlspecialchars($post["excerpt"]) ?>
                                    </p>
                                    
                                    <!-- Meta Information -->
                                    <div style="border-top: 1px solid rgba(100, 181, 246, 0.2); padding-top: 12px; font-size: 12px; color: var(--text-co-secondary); opacity: 0.7;">
                                        <p style="margin: 0 0 5px 0;">
                                            <strong><?= language("author") ?>:</strong> <?= htmlspecialchars($author) ?>
                                        </p>
                                        <p style="margin: 0;">
                                            <strong><?= language("date") ?>:</strong> <?= $date ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="background: var(--back-primary); padding: 40px; border-radius: 12px; text-align: center; margin-bottom: 30px; border: 1px solid rgba(100, 181, 246, 0.1);">
                    <p style="margin: 0; font-size: 16px; color: var(--text-co-secondary); opacity: 0.7;">
                        📭 <?= language("no_posts_yet") ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- CTA if authenticated -->
        <?php if($auth): ?>
        <div class="content">
            <div style="background: var(--back-primary); padding: 30px; border-radius: 12px; border: 2px solid var(--success-bg); text-align: center; margin-bottom: 30px;">
                <h3 style="margin: 0 0 10px 0; font-size: 20px; color: var(--success-bg); font-weight: bold;">✍️ <?= language("want_to_write") ?></h3>
                <p style="margin: 0 0 15px 0; font-size: 14px; color: var(--text-co);">
                    <?= language("create_blog_post") ?>
                </p>
                <a href="<?= route("new-post") ?>" style="background: var(--success-bg); color: var(--success-co); padding: 10px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease;">
                    <?= language("create_post") ?>
                </a>
            </div>
        </div>
        <?php endif; ?>
        <?php view("components/cta-social-follow", ["auth" => $auth]); ?>
    </main>
<?php view("components/footer"); ?>