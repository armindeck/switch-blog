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

?>
<?php if(empty($get_action) || !in_array($get_action, $actions)): ?>
    <div class="content">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 4px">
        <a href="../dashboard" style="background: var(--back-primary); color: var(--text-co); padding: 8px 15px; border: 1px solid var(--input-border-co); border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
            ← <?= language("back") ?>
        </a>
        <a href="posts/new" style="background: var(--success-bg); color: var(--success-co); padding: 8px 15px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; font-size: 16px;">
            ✍️ <?= language("new_post") ?>
        </a>
    </div>
    <ul style="display: flex; flex-direction: column; gap: 4px;">
    <?php foreach ($blog_data as $key => $value): ?>
        <li style="display: flex; align-items: center; justify-content: space-between; gap: 4px; border: 1px solid rgba(0,0,0,.1); border-radius: 4px; padding: 4px 6px;">
            <a href="posts/edit/<?= $value['slug'] ?>">✍️ <?= $value['slug'] ?></a>
            <small>
                <a href="<?= route("blog/{$value['slug']}") ?>" target="_blank" style="border: 1px solid rgba(0,0,0,.1); padding: 2px 4px; border-radius: 4px;"><?= $value["views"] ?? "0" ?> 👀</a>
                <a style="border: 1px solid rgba(0,0,0,.1); padding: 2px 4px; border-radius: 4px;"><?= $value["likes"] ?? "0" ?> 👍</a>
            </small>
        </li>
    <?php endforeach; ?>
    </ul>
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