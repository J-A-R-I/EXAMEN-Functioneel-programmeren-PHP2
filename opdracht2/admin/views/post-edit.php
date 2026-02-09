<?php
declare(strict_types=1);

// Variabelen veiligstellen
$canEdit = $canEdit ?? true;
$lockedByName = $lockedByName ?? 'iemand anders';
?>

<section class="p-6">
    <div class="max-w-4xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Post Bewerken</h1>
            <?php if ($canEdit): ?>
                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full border border-green-200">
                    Lock actief (jij bewerkt)
                </span>
            <?php else: ?>
                <span class="px-3 py-1 bg-red-100 text-red-800 text-xs rounded-full border border-red-200">
                    Read-only (Locked by <?= htmlspecialchars((string)$lockedByName, ENT_QUOTES) ?>)
                </span>
            <?php endif; ?>
        </div>

        <?php require __DIR__ . '/partials/flash.php'; ?>

        <form action="<?= ADMIN_BASE_PATH ?>/posts/<?= urlencode($postSlug) ?>/update"
              method="POST"
              class="bg-white shadow rounded-lg p-6 space-y-6 mb-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Titel</label>
                        <input type="text"
                               name="title"
                               value="<?= htmlspecialchars((string)($old['title'] ?? ''), ENT_QUOTES) ?>"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               <?= $canEdit ? '' : 'disabled' ?>>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Inhoud</label>
                        <textarea name="content"
                                  rows="10"
                                  class="w-full border-gray-300 rounded-md shadow-sm"
                                  <?= $canEdit ? '' : 'disabled' ?>><?= htmlspecialchars((string)($old['content'] ?? ''), ENT_QUOTES) ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Slug (laat leeg voor auto-generatie)
                        </label>
                        <input type="text"
                               name="slug"
                               value="<?= htmlspecialchars((string)($old['slug'] ?? ''), ENT_QUOTES) ?>"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               <?= $canEdit ? '' : 'disabled' ?>>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <?php $status = (string)($old['status'] ?? 'draft'); ?>
                        <select name="status"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                <?= $canEdit ? '' : 'disabled' ?>>
                            <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Concept</option>
                            <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Gepubliceerd</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Publicatiedatum</label>
                        <input type="datetime-local"
                               name="published_at"
                               value="<?= htmlspecialchars((string)($old['published_at'] ?? ''), ENT_QUOTES) ?>"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               <?= $canEdit ? '' : 'disabled' ?>>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                        <?php $featured = (string)($old['featured_media_id'] ?? ''); ?>
                        <select name="featured_media_id"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                <?= $canEdit ? '' : 'disabled' ?>>
                            <option value="">Geen afbeelding</option>
                            <?php foreach (($media ?? []) as $item): ?>
                                <option value="<?= (int)$item['id'] ?>" <?= ((string)$item['id'] === $featured) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars((string)$item['original_name'], ENT_QUOTES) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Instellingen</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                        <input type="text"
                               name="meta_title"
                               value="<?= htmlspecialchars((string)($old['meta_title'] ?? ''), ENT_QUOTES) ?>"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               <?= $canEdit ? '' : 'disabled' ?>>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea name="meta_description"
                                  rows="3"
                                  class="w-full border-gray-300 rounded-md shadow-sm"
                                  <?= $canEdit ? '' : 'disabled' ?>><?= htmlspecialchars((string)($old['meta_description'] ?? ''), ENT_QUOTES) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="<?= ADMIN_BASE_PATH ?>/posts"
                   class="bg-gray-100 text-gray-700 px-4 py-2 rounded border border-gray-300">Annuleren</a>
                <?php if ($canEdit): ?>
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Opslaan
                    </button>
                <?php else: ?>
                    <button type="button"
                            disabled
                            class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed">
                        Geblokkeerd
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</section>
