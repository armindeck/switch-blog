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

$actions = ["new", "edit", "delete"];
echo $view_hero_two(
    language($get_section),
    !empty($get_action) && in_array($get_action, $actions) ? route("dashboard/posts") : route("dashboard")
);
?>
<?php if(empty($get_action) || !in_array($get_action, $actions)): ?>
    <div class="content" style="margin: 0;">
        <div style="display: flex; flex-direction: column; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin-top: 6px; overflow: hidden;">
            <hgroup style="display: flex; align-items: center; justify-content: space-between; gap: 4px; border-bottom: 1px solid var(--content-border-strong-co); padding: 4px 6px;">
                <strong><?= language("posts") ?></strong>
                <a href="posts/new" style="background: var(--success-bg); color: var(--success-co); padding: 4px 6px; border-radius: 4px; font-size: 16px; font-weight: bold;">
                    📝 <?= language("new_post") ?>
                </a>
            </hgroup>
            <?php $i = 1; foreach ($blog_data ?? [] as $key => $value): ?>
                <hgroup style="display: flex; align-items: center; justify-content: space-between; gap: 4px; <?= $i < count($blog_data) ? "border-bottom: 1px solid var(--content-border-co);" : "" ?> padding: 4px 6px;">
                    <a href="posts/edit/<?= $value['slug'] ?>">✍️ <?= $value['slug'] ?></a>
                    <small>
                        <a href="<?= route("blog/{$value['slug']}") ?>" target="_blank" style="border: 1px solid var(--content-border-strong-co); padding: 2px 4px; border-radius: 4px;"><?= $value["views"] ?? "0" ?> 👀</a>
                        <a style="border: 1px solid var(--content-border-strong-co); padding: 2px 4px; border-radius: 4px;"><?= $value["likes"] ?? "0" ?> 👍</a>
                    </small>
                </hgroup>
            <?php $i++; endforeach; ?>
            <?= empty($blog_data) ? "<small style='padding: 4px 6px;'>" . language("there_is_no_article") . "</small>" : "" ?>
        </div>
        <div style="display: flex; flex-direction: column; border: 1px solid var(--content-border-strong-co); border-radius: 4px; margin-top: 6px; overflow: hidden;">
            <hgroup style="display: flex; align-items: center; justify-content: space-between; gap: 4px; border-bottom: 1px solid var(--content-border-strong-co); padding: 4px 6px;">
                <strong><?= language("drafts") ?></strong>
            </hgroup>
            <?php $i = 1; foreach ($blog_data_drafts ?? [] as $key => $value): ?>
                <hgroup style="display: flex; align-items: center; justify-content: space-between; gap: 4px; <?= $i < count($blog_data) ? "border-bottom: 1px solid var(--content-border-co);" : "" ?> padding: 4px 6px;">
                    <a href="posts/edit/<?= $value['slug'] ?>">✍️ <?= $value['slug'] ?></a>
                    <small>
                        <a href="<?= route("blog/{$value['slug']}") ?>" target="_blank" style="border: 1px solid var(--content-border-strong-co); padding: 2px 4px; border-radius: 4px;"><?= $value["views"] ?? "0" ?> 👀</a>
                        <a style="border: 1px solid var(--content-border-strong-co); padding: 2px 4px; border-radius: 4px;"><?= $value["likes"] ?? "0" ?> 👍</a>
                    </small>
                </hgroup>
            <?php $i++; endforeach; ?>
            <?= empty($blog_data_drafts) ? "<small style='padding: 4px 6px;'>" . language("there_is_no_draft") . "</small>" : "" ?>
        </div>
    </div>
<?php endif;

if(in_array($get_action, $actions)){

    if($get_action == "edit"){
        $post_data = null;
        $post_key = null;
        
        // Search post by slug
        foreach($blog_data as $key => $blog_post) {
            if(($blog_post["slug"] ?? "") === $get_id) {
                $post_data = $blog_post;
                $post_key = $key;
                break;
            }
        }

        $data_origin = ["post_slug" => $get_id, "post" => $post_data];
    }

    view("components/dashboard/form/{$get_action}-post", $data_origin);
}
?>