<?php
declare(strict_types=1);

/** @var array $post */
/** @var array $revision */
?>

<section class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header met acties -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Revisie Details</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Vergelijking voor post: <span class="font-semibold"><?= htmlspecialchars((string)$post['title']) ?></span>
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?= ADMIN_BASE_PATH ?>/posts/<?= urlencode((string)$post['slug']) ?>/revisions" 
                   class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50 transition">
                    &larr; Terug naar overzicht
                </a>
                
                <form method="post" 
                      action="<?= ADMIN_BASE_PATH ?>/posts/<?= urlencode((string)$post['slug']) ?>/revisions/<?= (int)$revision['id'] ?>/restore"
                      onsubmit="return confirm('Weet je zeker dat je deze versie wilt herstellen?\nDe huidige versie wordt opgeslagen als een nieuwe revisie voordat deze oude versie actief wordt.');">
                    <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded shadow hover:bg-blue-700 transition flex items-center gap-2">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                         </svg>
                        Zet deze versie terug (Rollback)
                    </button>
                </form>
            </div>
        </div>

        <?php require __DIR__ . '/partials/flash.php'; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Metadata Revisie -->
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-yellow-400">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-800">
                    <span class="w-2 h-2 rounded-full bg-yellow-400"></span> 
                    De Oude Versie (Revisie)
                </h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Aangepast door</span>
                        <p class="font-medium text-gray-900"><?= htmlspecialchars((string)($revision['user_name'] ?? 'Onbekend')) ?></p>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Datum aanpassing</span>
                        <p class="font-medium text-gray-900"><?= htmlspecialchars((string)$revision['created_at']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Metadata Huidig -->
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-green-500">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-800">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    De Huidige Versie
                </h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Huidige status</span>
                        <p class="font-medium text-gray-900">Actief</p>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Laatst gewijzigd</span>
                        <p class="font-medium text-gray-900"><?= htmlspecialchars((string)($post['updated_at'] ?? $post['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vergelijking Inhoud -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-700">Inhoud Vergelijking</h3>
                <p class="text-sm text-gray-500">Links de oude versie, rechts de huidige versie. Verschillen worden gemarkeerd.</p>
            </div>

            <div class="p-6 space-y-8">
                <?php
                $renderField = function(string $label, string $old, string $new) {
                    $isDifferent = trim($old) !== trim($new);
                    // Rood voor oud (verwijderd/anders), Groen voor nieuw
                    $bgOld = $isDifferent ? 'bg-red-50 border-red-100' : 'bg-gray-50 border-gray-200';
                    $bgNew = $isDifferent ? 'bg-green-50 border-green-100' : 'bg-white border-gray-200';
                    $borderClass = $isDifferent ? 'border-l-4 border-blue-400 pl-4 py-2' : '';
                    ?>
                    <div class="<?= $borderClass ?>">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm uppercase tracking-wide"><?= htmlspecialchars($label) ?></h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Oud -->
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-400 mb-1">Oude versie</span>
                                <div class="flex-grow p-3 rounded text-sm font-mono whitespace-pre-wrap break-all border <?= $bgOld ?>">
                                    <?= htmlspecialchars($old) ?>
                                </div>
                            </div>
                            <!-- Nieuw -->
                            <div>
                                <span class="text-xs text-gray-400 mb-1">Huidige versie</span>
                                <div class="p-3 rounded text-sm font-mono whitespace-pre-wrap break-all border <?= $bgNew ?>">
                                    <?= htmlspecialchars($new) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                };

                $renderField('Titel', (string)$revision['title'], (string)$post['title']);
                $renderField('Slug (URL)', (string)$revision['slug'], (string)$post['slug']);
                
                // Content is vaak groot, dus misschien even inkorten of scrollen als het te groot is? 
                // Voor nu gewoon voluit.
                $renderField('Content', (string)$revision['content'], (string)$post['content']);
                ?>
            </div>
        </div>
    </div>
</section>
