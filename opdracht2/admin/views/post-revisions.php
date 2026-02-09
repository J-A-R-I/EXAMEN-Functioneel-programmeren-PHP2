<?php
declare(strict_types=1);

// $post, $revisions worden door de controller aangeleverd
?>

<section class="p-6">
    <div class="max-w-4xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Revisies voor: <?= htmlspecialchars((string)$post['title'], ENT_QUOTES) ?></h1>
                <p class="text-sm text-gray-500 mt-1">
                    Slug: <span class="font-mono"><?= htmlspecialchars((string)$post['slug'], ENT_QUOTES) ?></span>
                </p>
            </div>

            <a href="<?= ADMIN_BASE_PATH ?>/posts/<?= urlencode((string)$post['slug']) ?>/edit"
               class="text-sm text-blue-600 underline">
                Terug naar bewerken
            </a>
        </div>

        <?php require __DIR__ . '/partials/flash.php'; ?>

        <?php if (empty($revisions)): ?>
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-gray-600">Er zijn nog geen revisies voor deze post.</p>
            </div>
        <?php else: ?>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-bold mb-4">Revisies (max. 3 bewaard)</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-2">Datum</th>
                            <th class="px-4 py-2">Gebruiker</th>
                            <th class="px-4 py-2">Titel (snapshot)</th>
                            <th class="px-4 py-2 text-right">Actie</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        <?php foreach ($revisions as $rev): ?>
                            <tr>
                                <td class="px-4 py-2"><?= htmlspecialchars((string)$rev['created_at'], ENT_QUOTES) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars((string)($rev['user_name'] ?? 'Onbekend'), ENT_QUOTES) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars((string)$rev['title'], ENT_QUOTES) ?></td>
                                <td class="px-4 py-2 text-right whitespace-nowrap">
                                    <a href="<?= ADMIN_BASE_PATH ?>/posts/<?= urlencode((string)$post['slug']) ?>/revisions/<?= (int)$rev['id'] ?>"
                                       class="text-indigo-600 hover:text-indigo-900 mr-3 font-medium">
                                        Bekijk
                                    </a>
                                    <form method="post" class="inline-block"
                                          action="<?= ADMIN_BASE_PATH ?>/posts/<?= urlencode((string)$post['slug']) ?>/revisions/<?= (int)$rev['id'] ?>/restore"
                                          onsubmit="return confirm('Weet je zeker dat je deze versie wilt herstellen? De huidige versie wordt opgeslagen als nieuwe revisie.');">
                                        <button type="submit" class="text-blue-600 hover:underline">
                                            Herstel
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>


