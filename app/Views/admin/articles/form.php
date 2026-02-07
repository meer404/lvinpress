<?php
/**
 * Admin Article Create/Edit Form with Language Tabs
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
    
    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;">
        <!-- Main Content -->
        <div>
            <!-- Language Tabs -->
            <div class="admin-card">
                <div class="lang-tabs">
                    <button type="button" class="lang-tab active" onclick="switchLangTab('ku')">کوردی</button>
                    <button type="button" class="lang-tab" onclick="switchLangTab('en')">English</button>
                    <button type="button" class="lang-tab" onclick="switchLangTab('ar')">العربية</button>
                </div>
                
                <!-- Kurdish -->
                <div class="lang-panel active" id="langPanel-ku" dir="rtl">
                    <div class="form-group">
                        <label class="form-label"><?= $t('title') ?> (کوردی) <span style="color:#e74c3c;">*</span></label>
                        <input type="text" name="title_ku" class="form-control" value="<?= htmlspecialchars($titleKu) ?>" required style="font-size:1.25rem;">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('excerpt') ?> (کوردی)</label>
                        <textarea name="excerpt_ku" class="form-control" rows="3"><?= htmlspecialchars($excerptKu) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('content') ?> (کوردی) <span style="color:#e74c3c;">*</span></label>
                        <textarea name="content_ku" class="form-control rich-editor" rows="15" required><?= htmlspecialchars($contentKu) ?></textarea>
                    </div>
                </div>
                
                <!-- English -->
                <div class="lang-panel" id="langPanel-en" dir="ltr" style="display:none;">
                    <div class="form-group">
                        <label class="form-label"><?= $t('title') ?> (English)</label>
                        <input type="text" name="title_en" class="form-control" value="<?= htmlspecialchars($titleEn) ?>" style="font-size:1.25rem;">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('excerpt') ?> (English)</label>
                        <textarea name="excerpt_en" class="form-control" rows="3"><?= htmlspecialchars($excerptEn) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('content') ?> (English)</label>
                        <textarea name="content_en" class="form-control rich-editor" rows="15"><?= htmlspecialchars($contentEn) ?></textarea>
                    </div>
                </div>
                
                <!-- Arabic -->
                <div class="lang-panel" id="langPanel-ar" dir="rtl" style="display:none;">
                    <div class="form-group">
                        <label class="form-label"><?= $t('title') ?> (العربية)</label>
                        <input type="text" name="title_ar" class="form-control" value="<?= htmlspecialchars($titleAr) ?>" style="font-size:1.25rem;">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('excerpt') ?> (العربية)</label>
                        <textarea name="excerpt_ar" class="form-control" rows="3"><?= htmlspecialchars($excerptAr) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('content') ?> (العربية)</label>
                        <textarea name="content_ar" class="form-control rich-editor" rows="15"><?= htmlspecialchars($contentAr) ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div>
            <!-- Publish Box -->
            <div class="admin-card" style="margin-bottom:1.5rem;">
                <div class="admin-card__header"><h3><?= $t('publish') ?></h3></div>
                <div class="admin-card__body">
                    <div class="form-group">
                        <label class="form-label"><?= $t('status') ?></label>
                        <select name="status" class="form-control">
                            <option value="draft" <?= ($isEdit && $article->status === 'draft') ? 'selected' : '' ?>><?= $t('draft') ?></option>
                            <option value="published" <?= ($isEdit && $article->status === 'published') ? 'selected' : '' ?>><?= $t('published') ?></option>
                            <option value="pending" <?= ($isEdit && $article->status === 'pending') ? 'selected' : '' ?>><?= $t('pending') ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('published_at') ?></label>
                        <input type="datetime-local" name="published_at" class="form-control" 
                               value="<?= $isEdit && $article->published_at ? date('Y-m-d\TH:i', strtotime($article->published_at)) : date('Y-m-d\TH:i') ?>">
                    </div>
                    <div style="display:flex;gap:0.5rem;margin-top:1rem;">
                        <button type="submit" class="btn btn-gold" style="flex:1;">
                            <i class="fas fa-save"></i> <?= $isEdit ? $t('update') : $t('publish') ?>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Category -->
            <div class="admin-card" style="margin-bottom:1.5rem;">
                <div class="admin-card__header"><h3><?= $t('category') ?></h3></div>
                <div class="admin-card__body">
                    <select name="category_id" class="form-control" required>
                        <option value=""><?= $t('select_category') ?></option>
                        <?php foreach ($categories ?? [] as $cat): ?>
                        <option value="<?= $cat->id ?>" <?= ($isEdit && $article->category_id == $cat->id) ? 'selected' : '' ?>>
                            <?= $cat->{'name_' . $lang} ?? $cat->name_ku ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Featured Image -->
            <div class="admin-card" style="margin-bottom:1.5rem;">
                <div class="admin-card__header"><h3><?= $t('featured_image') ?></h3></div>
                <div class="admin-card__body">
                    <?php if ($isEdit && $article->featured_image): ?>
                    <img src="<?= upload_url($article->featured_image) ?>" alt="" style="width:100%;border-radius:var(--radius-md);margin-bottom:0.5rem;">
                    <?php endif; ?>
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                </div>
            </div>
            
            <!-- Options -->
            <div class="admin-card" style="margin-bottom:1.5rem;">
                <div class="admin-card__header"><h3><?= $t('options') ?></h3></div>
                <div class="admin-card__body">
                    <label style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.75rem;cursor:pointer;">
                        <input type="checkbox" name="is_featured" value="1" <?= ($isEdit && $article->is_featured) ? 'checked' : '' ?>>
                        <span><?= $t('featured') ?></span>
                    </label>
                    <label style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.75rem;cursor:pointer;">
                        <input type="checkbox" name="is_breaking" value="1" <?= ($isEdit && $article->is_breaking) ? 'checked' : '' ?>>
                        <span><?= $t('breaking') ?></span>
                    </label>
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="allow_comments" value="1" <?= (!$isEdit || $article->allow_comments) ? 'checked' : '' ?>>
                        <span><?= $t('allow_comments') ?></span>
                    </label>
                </div>
            </div>
            
            <!-- Tags -->
            <div class="admin-card" style="margin-bottom:1.5rem;">
                <div class="admin-card__header"><h3><?= $t('tags') ?></h3></div>
                <div class="admin-card__body">
                    <input type="text" name="tags" class="form-control" placeholder="<?= $t('tags_placeholder') ?? 'tag1, tag2, tag3' ?>"
                           value="<?= $isEdit ? implode(', ', array_map(fn($t) => $t->name_en ?? $t->name_ku, $articleTags ?? [])) : '' ?>">
                    <small class="text-muted"><?= $t('tags_help') ?? 'Separate with commas' ?></small>
                </div>
            </div>
            
            <!-- Video URL -->
            <div class="admin-card">
                <div class="admin-card__header"><h3><?= $t('video') ?></h3></div>
                <div class="admin-card__body">
                    <input type="url" name="video_url" class="form-control" placeholder="YouTube URL" 
                           value="<?= $isEdit ? ($article->video_url ?? '') : '' ?>">
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function switchLangTab(lang) {
    document.querySelectorAll('.lang-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.lang-panel').forEach(p => p.style.display = 'none');
    event.target.classList.add('active');
    document.getElementById('langPanel-' + lang).style.display = 'block';
}
</script>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
