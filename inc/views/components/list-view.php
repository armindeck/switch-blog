<?php if (!empty($list_order_by_state)): ?>
    <div class="p-8 scroll-auto">
    <table>
        <thead>
            <tr>
                <td title="<?= language("stars") ?>">📊</td>
                <td><?= language("title") ?></td>
                <td><?= language("episode") ?></td>
                <td><?= language("state") ?></td>
                <td><?= language("type") ?></td>
                <?php if(!$user || $user && $is_user_user): ?>
                <td><?= language("action") ?></td>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($list_order_by_state as $key => $value): ?>
            <tr <?= $i % 2 == 0 ? "style='background:rgb(0,0,0,.1);'" : ""  ?>>
                <td><?= !empty($value["stars"]) ? starsEmoji($value["stars"]) : "" ?></td>
                <td><?= !empty($value["url"]) ? "<a title=\"" . language("external_disclaimer") . "\" target=\"_blank\" href=\"{$value['url']}\" rel=\"noopener noreferrer\">" : "" ?><?= $value["title"] ?? "" ?><?= !empty($value["url"]) ? "</a>" : "" ?></td>
                <td title="<?= language("season") . ' - ' . language("episode") . ' / ' . language("episodes") ?>"><?= (!empty($value["season"]) ? "T" . $value["season"] . " - " : "") . (!empty($value["episode"]) ? $value["episode"] : "") . (!empty($value["episode"]) && !empty($value["episodes"]) ? "/" . $value["episodes"] : "") ?></td>
                <td title="<?= language($value["state"] ?? "") ?>"><?= stateEmoji($value["state"] ?? "") ?></td>
                <td><?= language($value["type"] ?? "") ?></td>
                <?php if(!$user || $user && $is_user_user): ?>
                    <td class="flex flex-between gap-4">
                        <a href="?id=<?= $key ?? "" ?>&action=edit<?= $user ? "&to_user=true" : "" ?>">📝</a>
                        <a href="?id=<?= $key ?? "" ?>&action=delete<?= $user ? "&to_user=true" : "" ?>" onclick="return confirm('<?= language("confirm_delete"); ?>');">❌</a>
                    </td>
                <?php endif; ?>
            </tr>
            <?php $i += 1; endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>