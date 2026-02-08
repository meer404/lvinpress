<?php
/**
 * Admin Page Form - Tailwind CSS Redesign
 */
$isEdit = isset($page) && is_object($page);
$pageTitle = $isEdit ? ($t('edit') . ' ' . ($page->{'title_' . $lang} ?? '')) : $t('add_new');
ob_start();
?>

<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
            <h3 class="font-semibold text-stone-800"><?= $pageTitle ?></h3>
            <a href="<?= url('admin/pages') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-stone-200 text-stone-600 text-xs font-medium rounded-lg hover:border-brand-gold hover:text-brand-gold transition">
                <i class="fas fa-arrow-left text-[0.6rem]"></i> <?= $t('back') ?? 'Back' ?>
            </a>
        </div>
        <div class="p-5">
            <form method="POST" action="<?= $isEdit ? url('admin/pages/update/' . $page->id) : url('admin/pages/store') ?>" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('slug') ?> *</label>
                    <input type="text" name="slug" value="<?= htmlspecialchars($page->slug ?? '') ?>"
                           required pattern="[a-z0-9\-]+" placeholder="about-us" dir="ltr"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    <p class="text-xs text-stone-400 mt-1">URL-friendly identifier (lowercase letters, numbers, hyphens only)</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('title') ?> (کوردی) *</label>
                        <input type="text" name="title_ku" dir="rtl" value="<?= htmlspecialchars($page->title_ku ?? '') ?>" required
                               class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('title') ?> (English)</label>
                        <input type="text" name="title_en" dir="ltr" value="<?= htmlspecialchars($page->title_en ?? '') ?>"
                               class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('title') ?> (العربية)</label>
                        <input type="text" name="title_ar" dir="rtl" value="<?= htmlspecialchars($page->title_ar ?? '') ?>"
                               class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('content') ?> (کوردی)</label>
                    <textarea name="content_ku" rows="10" dir="rtl" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold resize-y"><?= htmlspecialchars($page->content_ku ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('content') ?> (English)</label>
                    <textarea name="content_en" rows="10" dir="ltr" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold resize-y"><?= htmlspecialchars($page->content_en ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('content') ?> (العربية)</label>
                    <textarea name="content_ar" rows="10" dir="rtl" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold resize-y"><?= htmlspecialchars($page->content_ar ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('status') ?></label>
                    <select name="status" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                        <option value="draft" <?= ($page->status ?? 'draft') === 'draft' ? 'selected' : '' ?>><?= $t('draft') ?></option>
                        <option value="published" <?= ($page->status ?? '') === 'published' ? 'selected' : '' ?>><?= $t('published') ?></option>
                    </select>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-brand-gold text-white font-semibold rounded-xl hover:bg-brand-gold-dark transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-save text-sm"></i> <?= $t('save') ?>
                    </button>
                    <a href="<?= url('admin/pages') ?>" class="px-6 py-2.5 border border-stone-200 text-stone-600 font-medium rounded-xl hover:bg-stone-50 transition"><?= $t('cancel') ?? 'Cancel' ?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
