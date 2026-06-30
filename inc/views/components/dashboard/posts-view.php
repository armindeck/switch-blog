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
<ul>
<?php foreach ($blog_data as $key => $value): ?>
    <li>
        <a href="posts/edit/<?= $value['slug'] ?>"><?= $value['slug'] ?></a>
    </li>
<?php endforeach; ?>
</ul>
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