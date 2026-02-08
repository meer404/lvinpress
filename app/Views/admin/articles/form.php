<?php
/**
 * Admin Article Create/Edit Form - Tailwind CSS Redesign
 */
$isEdit = !empty($article);
$pageTitle = $isEdit ? $t('edit_article') : $t('create_article');
ob_start();

$titleKu = $isEdit ? ($article->title_ku ?? '') : '';
$titleEn = $isEdit ? ($article->title_en ?? '') : '';
$titleAr = $isEdit ? ($article->title_ar ?? '') : '';
$contentKu = $isEdit ? ($article->content_ku ?? '') : '';
$contentEn = $isEdit ? ($article->content_en ?? '') : '';
$contentAr = $isEdit ? ($article->content_ar ?? '') : '';
$excerptKu = $isEdit ? ($article->excerpt_ku ?? '') : '';
$excerptEn = $isEdit ? ($article->excerpt_en ?? '') : '';
$excerptAr = $isEdit ? ($article->excerpt_ar ?? '') : '';
?>

<form method="POST" action="<?= $isEdit ? url('admin/articles/update/' . $article->id) : url('admin/articles/store') ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-6">
        <!-- Main Content -->
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
            <!-- Language Tabs -->
            <div class="flex border-b border-stone-100">
                <button type="button" onclick="switchLangTab('ku')" class="lang-tab-btn flex-1 px-4 py-3 text-sm font-medium text-center border-b-2 border-brand-gold text-brand-gold transition" data-lang="ku">کوردی</button>
                <button type="button" onclick="switchLangTab('en')" class="lang-tab-btn flex-1 px-4 py-3 text-sm font-medium text-center border-b-2 border-transparent text-stone-400 hover:text-stone-600 transition" data-lang="en">English</button>
                <button type="button" onclick="switchLangTab('ar')" class="lang-tab-btn flex-1 px-4 py-3 text-sm font-medium text-center border-b-2 border-transparent text-stone-400 hover:text-stone-600 transition" data-lang="ar">العربية</button>
            </div>

            <!-- Kurdish Panel -->
            <div class="lang-panel p-5 space-y-4" id="langPanel-ku" dir="rtl">
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5"><?= $t('title') ?> (کوردی) <span class="text-red-500">*</span></label>
                    <input type="text" name="title_ku" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-lg focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition" value="<?= htmlspecialchars($titleKu) ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5"><?= $t('excerpt') ?> (کوردی)</label>
                    <textarea name="excerpt_ku" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition resize-y"><?= htmlspecialchars($excerptKu) ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5"><?= $t('content') ?> (کوردی) <span class="text-red-500">*</span></label>
                    <textarea name="content_ku" rows="15" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition resize-y rich-editor" required><?= htmlspecialchars($contentKu) ?></textarea>
                </div>
            </div>

            <!-- English Panel -->
            <div class="lang-panel p-5 space-y-4 hidden" id="langPanel-en" dir="ltr">
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5"><?= $t('title') ?> (English)</label>
                    <input type="text" name="title_en" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-lg focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition" value="<?= htmlspecialchars($titleEn) ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5"><?= $t('excerpt') ?> (English)</label>
                    <textarea name="excerpt_en" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition resize-y"><?= htmlspecialchars($excerptEn) ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5"><?= $t('content') ?> (English)</label>
                    <textarea name="content_en" rows="15" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition resize-y rich-editor"><?= htmlspecialchars($contentEn) ?></textarea>
                </div>
            </div>

            <!-- Arabic Panel -->
            <div class="lang-panel p-5 space-y-4 hidden" id="langPanel-ar" dir="rtl">
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5"><?= $t('title') ?> (العربية)</label>
                    <input type="text" name="title_ar" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-lg focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition" value="<?= htmlspecialchars($titleAr) ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5"><?= $t('excerpt') ?> (العربية)</label>
                    <textarea name="excerpt_ar" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition resize-y"><?= htmlspecialchars($excerptAr) ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5"><?= $t('content') ?> (العربية)</label>
                    <textarea name="content_ar" rows="15" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition resize-y rich-editor"><?= htmlspecialchars($contentAr) ?></textarea>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-5">
            <!-- Publish Box -->
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 border-b border-stone-100"><h3 class="font-semibold text-sm text-stone-800"><?= $t('publish') ?></h3></div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('status') ?></label>
                        <select name="status" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                            <option value="draft" <?= ($isEdit && $article->status === 'draft') ? 'selected' : '' ?>><?= $t('draft') ?></option>
                            <option value="published" <?= ($isEdit && $article->status === 'published') ? 'selected' : '' ?>><?= $t('published') ?></option>
                            <option value="pending" <?= ($isEdit && $article->status === 'pending') ? 'selected' : '' ?>><?= $t('pending') ?></option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('published_at') ?></label>
                        <input type="datetime-local" name="published_at" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold"
                               value="<?= $isEdit && $article->published_at ? date('Y-m-d\TH:i', strtotime($article->published_at)) : date('Y-m-d\TH:i') ?>">
                    </div>
                    <button type="submit" class="w-full px-4 py-2.5 bg-brand-gold text-white font-semibold rounded-xl hover:bg-brand-gold-dark transition shadow-sm flex items-center justify-center gap-2">
                        <i class="fas fa-save text-sm"></i> <?= $isEdit ? $t('update') : $t('publish') ?>
                    </button>
                </div>
            </div>

            <!-- Category -->
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 border-b border-stone-100"><h3 class="font-semibold text-sm text-stone-800"><?= $t('category') ?></h3></div>
                <div class="p-5">
                    <select name="category_id" required class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                        <option value=""><?= $t('select_category') ?></option>
                        <?php foreach ($categories ?? [] as $cat): ?>
                        <option value="<?= $cat->id ?>" <?= ($isEdit && $article->category_id == $cat->id) ? 'selected' : '' ?>><?= $cat->{'name_' . $lang} ?? $cat->name_ku ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 border-b border-stone-100"><h3 class="font-semibold text-sm text-stone-800"><?= $t('featured_image') ?></h3></div>
                <div class="p-5">
                    <?php if ($isEdit && $article->featured_image): ?>
                    <img src="<?= upload_url($article->featured_image) ?>" alt="" class="w-full rounded-xl mb-3 object-cover max-h-48">
                    <?php endif; ?>
                    <input type="file" name="featured_image" accept="image/*" class="w-full text-sm text-stone-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-gold/10 file:text-brand-gold hover:file:bg-brand-gold/20 cursor-pointer">
                </div>
            </div>

            <!-- Options -->
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 border-b border-stone-100"><h3 class="font-semibold text-sm text-stone-800"><?= $t('options') ?></h3></div>
                <div class="p-5 space-y-3">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" <?= ($isEdit && $article->is_featured) ? 'checked' : '' ?> class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30">
                        <span class="text-sm text-stone-700"><?= $t('featured') ?></span>
                    </label>
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_breaking" value="1" <?= ($isEdit && $article->is_breaking) ? 'checked' : '' ?> class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30">
                        <span class="text-sm text-stone-700"><?= $t('breaking') ?></span>
                    </label>
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="allow_comments" value="1" <?= (!$isEdit || $article->allow_comments) ? 'checked' : '' ?> class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30">
                        <span class="text-sm text-stone-700"><?= $t('allow_comments') ?></span>
                    </label>
                </div>
            </div>

            <!-- Tags -->
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 border-b border-stone-100"><h3 class="font-semibold text-sm text-stone-800"><?= $t('tags') ?></h3></div>
                <div class="p-5">
                    <input type="text" name="tags" placeholder="<?= $t('tags_placeholder') ?? 'tag1, tag2, tag3' ?>"
                           value="<?= $isEdit ? implode(', ', array_map(fn($t) => $t->name_en ?? $t->name_ku, $articleTags ?? [])) : '' ?>"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    <p class="text-xs text-stone-400 mt-1.5"><?= $t('tags_help') ?? 'Separate with commas' ?></p>
                </div>
            </div>

            <!-- Video URL -->
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 border-b border-stone-100"><h3 class="font-semibold text-sm text-stone-800"><?= $t('video') ?></h3></div>
                <div class="p-5">
                    <input type="url" name="video_url" placeholder="YouTube URL" dir="ltr"
                           value="<?= $isEdit ? ($article->video_url ?? '') : '' ?>"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function switchLangTab(lang) {
    document.querySelectorAll('.lang-tab-btn').forEach(btn => {
        btn.classList.remove('border-brand-gold', 'text-brand-gold');
        btn.classList.add('border-transparent', 'text-stone-400');
    });
    document.querySelectorAll('.lang-panel').forEach(p => p.classList.add('hidden'));
    document.querySelector(`.lang-tab-btn[data-lang="${lang}"]`).classList.add('border-brand-gold', 'text-brand-gold');
    document.querySelector(`.lang-tab-btn[data-lang="${lang}"]`).classList.remove('border-transparent', 'text-stone-400');
    document.getElementById('langPanel-' + lang).classList.remove('hidden');
}
</script>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
