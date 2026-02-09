<?php
declare(strict_types=1);

use Admin\Core\Auth;

?>

<section class="p-6">
    <div class="bg-white p-6 rounded shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Posts overzicht</h2>

            <a class="underline" href="/admin/posts/create">
                + Nieuwe post
            </a>
        </div>

        <table class="w-full text-sm">
            <thead>
            <tr class="text-left border-b">
                <th class="py-2">Titel</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Publicatiedatum</th>
                <th>Lock</th>
                <th class="text-right">Acties</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($posts as $post): ?>
                <?php
                $rawSlug = (string)($post['slug'] ?? '');
                $slugLink = $rawSlug !== '' ? rawurlencode($rawSlug) : (int)$post['id'];
                $isDeleted = !empty($post['deleted_at']);
                $rowClass = $isDeleted ? 'border-b opacity-60' : 'border-b';
                
                if (!empty($post['published_at']) && $post['published_at'] !== '0000-00-00 00:00:00') {
                    $dt = new DateTime($post['published_at']);
                    $publishedAtDisplay = $dt->format('d-m-Y H:i');
                } else {
                    // fallback: toon created_at als publicatiedatum indien published_at leeg is
                    $dt = new DateTime($post['created_at']);
                    $publishedAtDisplay = $dt->format('d-m-Y H:i');
                }
                ?>
                <tr class="<?= $rowClass ?>">
                    <td class="py-2">
                        <a class="underline" href="/admin/posts/<?= $slugLink; ?>">
                            <?php echo htmlspecialchars((string)$post['title'], ENT_QUOTES); ?>
                        </a>
                        <?php if ($isDeleted): ?>
                            <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded ml-2">Verwijderd</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-gray-500 italic">
                        <?= htmlspecialchars($rawSlug, ENT_QUOTES); ?>
                    </td>
                    <td><?php echo htmlspecialchars((string)$post['status'], ENT_QUOTES); ?></td>
                    <td class="text-sm text-gray-600"><?= $publishedAtDisplay ?></td>
                    <td class="text-sm">
                        <?php if (isset($post['lock_status']) && $post['lock_status'] !== null): ?>
                            <?php if ($post['lock_status'] === 'self'): ?>
                                <span class="text-xs text-green-600 font-bold">Mijn lock</span>
                            <?php else: ?>
                                <span class="text-xs text-red-600 font-bold">
                                    Gelockt door <?= htmlspecialchars((string)$post['lock_status'], ENT_QUOTES) ?>
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-xs text-gray-400">Vrij</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right space-x-3">
                        <?php if ($isDeleted): ?>
                            <form method="post" action="/admin/posts/<?= $slugLink; ?>/restore" style="display: inline;">
                                <button type="submit" class="underline text-green-600">Herstellen</button>
                            </form>
                            <?php else: ?>
                            <?php
                            $isLockedByOther = (isset($post['lock_status'])
                                && $post['lock_status'] !== null
                                && $post['lock_status'] !== 'self');
                            ?>
                            <?php if ($isLockedByOther): ?>
                                <span class="text-gray-400 mr-2">Bewerken</span>
                            <?php else: ?>
                                <a class="underline" href="/admin/posts/<?= $slugLink; ?>/edit">
                                    Bewerken
                                </a>
                            <?php endif; ?>

                            <?php if (Auth::isAdmin()): ?>
                                <a class="underline text-red-600" href="/admin/posts/<?= $slugLink; ?>/delete">
                                    Verwijderen
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>