<?php
declare(strict_types=1);
?>

<section class="p-6">
    <div class="bg-white p-6 rounded shadow">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Revisies overzicht</h1>
        </div>

        <?php require __DIR__ . '/partials/flash.php'; ?>

        <?php if (empty($items)): ?>
            <p class="text-gray-600">Er zijn nog geen revisies opgeslagen.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Datum</th>
                        <th>Post</th>
                        <th>Slug</th>
                        <th>Gebruiker</th>
                        <th>Titel (snapshot)</th>
                        <th class="py-2 text-right">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $rev): ?>
                        <tr class="border-b">
                            <td class="py-2"><?= htmlspecialchars((string)$rev['created_at'], ENT_QUOTES) ?></td>
                            <td>
                                <a class="underline"
                                   href="<?= ADMIN_BASE_PATH ?>/posts/<?= urlencode((string)$rev['post_slug']) ?>/edit">
                                    <?= htmlspecialchars((string)($rev['post_title'] ?? ''), ENT_QUOTES) ?>
                                </a>
                            </td>
                            <td class="font-mono text-xs">
                                <?= htmlspecialchars((string)($rev['post_slug'] ?? ''), ENT_QUOTES) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars((string)($rev['user_name'] ?? 'Onbekend'), ENT_QUOTES) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars((string)$rev['title'], ENT_QUOTES) ?>
                            </td>
                            <td class="text-right py-2 whitespace-nowrap">
                                <a href="<?= ADMIN_BASE_PATH ?>/posts/<?= urlencode((string)$rev['post_slug']) ?>/revisions/<?= (int)$rev['id'] ?>"
                                   class="text-blue-600 hover:underline text-sm px-3">
                                    Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>


