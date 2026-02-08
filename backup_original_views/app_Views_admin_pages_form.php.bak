<?php
/**
 * Admin Page Create/Edit Form
 */
$isEdit = isset($page) && is_object($page);
$pageTitle = $isEdit ? ($t('edit') . ' ' . ($page->{'title_' . $lang} ?? '')) : $t('add_new');
ob_start();
?>

<div style="max-width:900px;">
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><?= $pageTitle ?></h3>
            <a href="<?= url('admin/pages') ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> <?= $t('back') ?? 'Back' ?></a>
        </div>
        <div class="admin-card__body">
            <form method="POST" action="<?= $isEdit ? url('admin/pages/update/' . $page->id) : url('admin/pages/store') ?>">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label class="form-label"><?= $t('slug') ?> *</label>
                    <input type="text" name="slug" class="form-control" 
                           value="<?= htmlspecialchars($page->slug ?? '') ?>" 
                           required pattern="[a-z0-9\-]+" placeholder="about-us">
                    <small class="text-muted">URL-friendly identifier (lowercase letters, numbers, hyphens only)</small>
                </div>

                <!-- Multilingual Titles -->
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                    <div class="form-group">
                        <label class="form-label"><?= $t('title') ?> (کوردی) *</label>
                        <input type="text" name="title_ku" class="form-control" dir="rtl"
                               value="<?= htmlspecialchars($page->title_ku ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('title') ?> (English)</label>
                        <input type="text" name="title_en" class="form-control" dir="ltr"
                               value="<?= htmlspecialchars($page->title_en ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('title') ?> (العربية)</label>
                        <input type="text" name="title_ar" class="form-control" dir="rtl"
                               value="<?= htmlspecialchars($page->title_ar ?? '') ?>">
                    </div>
                </div>

                <!-- Multilingual Content -->
                <div class="form-group">
                    <label class="form-label"><?= $t('content') ?> (کوردی)</label>
                    <textarea name="content_ku" class="form-control" rows="10" dir="rtl"><?= htmlspecialchars($page->content_ku ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('content') ?> (English)</label>
                    <textarea name="content_en" class="form-control" rows="10" dir="ltr"><?= htmlspecialchars($page->content_en ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('content') ?> (العربية)</label>
                    <textarea name="content_ar" class="form-control" rows="10" dir="rtl"><?= htmlspecialchars($page->content_ar ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= $t('status') ?></label>
                    <select name="status" class="form-control">
                        <option value="draft" <?= ($page->status ?? 'draft') === 'draft' ? 'selected' : '' ?>><?= $t('draft') ?></option>
                        <option value="published" <?= ($page->status ?? '') === 'published' ? 'selected' : '' ?>><?= $t('published') ?></option>
                    </select>
                </div>
                
                <div style="display:flex;gap:0.5rem;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> <?= $t('save') ?></button>
                    <a href="<?= url('admin/pages') ?>" class="btn btn-outline"><?= $t('cancel') ?? 'Cancel' ?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
