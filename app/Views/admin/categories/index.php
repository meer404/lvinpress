<?php
/**
 * Admin Categories List
 */
$pageTitle = $t('categories');
ob_start();
?>

<div style="display:grid;grid-template-columns:1fr 400px;gap:1.5rem;">
    <!-- Categories List -->
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><?= $t('all_categories') ?></h3>
        </div>
        <div class="admin-card__body" style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th><?= $t('color') ?></th>
                        <th><?= $t('name') ?> (KU)</th>
                        <th><?= $t('name') ?> (EN)</th>
                        <th><?= $t('name') ?> (AR)</th>
                        <th><?= $t('articles') ?></th>
                        <th><?= $t('order') ?></th>
                        <th><?= $t('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><span style="display:inline-block;width:20px;height:20px;border-radius:50%;background:<?= $cat->color ?? '#d4af37' ?>;"></span></td>
                            <td><?= $cat->name_ku ?></td>
                            <td><?= $cat->name_en ?></td>
                            <td><?= $cat->name_ar ?></td>
                            <td><?= $cat->article_count ?? 0 ?></td>
                            <td><?= $cat->sort_order ?? 0 ?></td>
                            <td>
                                <div style="display:flex;gap:0.25rem;">
                                    <button class="btn btn-sm btn-outline" onclick="editCategory(<?= htmlspecialchars(json_encode($cat)) ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="<?= url('admin/categories/delete/' . $cat->id) ?>" class="btn btn-sm" style="background:#e74c3c;color:#fff;" 
                                       onclick="return confirm('<?= $t('confirm_delete') ?>')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted"><?= $t('no_categories') ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Add/Edit Category Form -->
    <div class="admin-card">
        <div class="admin-card__header">
            <h3 id="catFormTitle"><?= $t('add_category') ?></h3>
        </div>
        <div class="admin-card__body">
            <form method="POST" id="categoryForm" action="<?= url('admin/categories/store') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="catId" value="">
                
                <div class="form-group">
                    <label class="form-label"><?= $t('name') ?> (کوردی) <span style="color:#e74c3c;">*</span></label>
                    <input type="text" name="name_ku" id="catNameKu" class="form-control" required dir="rtl">
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('name') ?> (English)</label>
                    <input type="text" name="name_en" id="catNameEn" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('name') ?> (العربية)</label>
                    <input type="text" name="name_ar" id="catNameAr" class="form-control" dir="rtl">
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('slug') ?></label>
                    <input type="text" name="slug" id="catSlug" class="form-control" dir="ltr">
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('description') ?> (کوردی)</label>
                    <textarea name="description_ku" id="catDescKu" class="form-control" rows="2" dir="rtl"></textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="form-group">
                        <label class="form-label"><?= $t('color') ?></label>
                        <input type="color" name="color" id="catColor" class="form-control" value="#d4af37" style="height:42px;">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('order') ?></label>
                        <input type="number" name="sort_order" id="catOrder" class="form-control" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="is_active" id="catActive" value="1" checked>
                        <span><?= $t('active') ?></span>
                    </label>
                </div>
                <button type="submit" class="btn btn-gold" style="width:100%;">
                    <i class="fas fa-save"></i> <?= $t('save') ?>
                </button>
                <button type="button" class="btn btn-outline" style="width:100%;margin-top:0.5rem;" onclick="resetForm()" id="cancelBtn" style="display:none;">
                    <?= $t('cancel') ?>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function editCategory(cat) {
    document.getElementById('catFormTitle').textContent = '<?= $t('edit_category') ?>';
    document.getElementById('categoryForm').action = '<?= url('admin/categories/update/') ?>' + cat.id;
    document.getElementById('catId').value = cat.id;
    document.getElementById('catNameKu').value = cat.name_ku || '';
    document.getElementById('catNameEn').value = cat.name_en || '';
    document.getElementById('catNameAr').value = cat.name_ar || '';
    document.getElementById('catSlug').value = cat.slug || '';
    document.getElementById('catDescKu').value = cat.description_ku || '';
    document.getElementById('catColor').value = cat.color || '#d4af37';
    document.getElementById('catOrder').value = cat.sort_order || 0;
    document.getElementById('catActive').checked = cat.is_active == 1;
    document.getElementById('cancelBtn').style.display = 'block';
}

function resetForm() {
    document.getElementById('catFormTitle').textContent = '<?= $t('add_category') ?>';
    document.getElementById('categoryForm').action = '<?= url('admin/categories/store') ?>';
    document.getElementById('categoryForm').reset();
    document.getElementById('catId').value = '';
    document.getElementById('cancelBtn').style.display = 'none';
}
</script>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
