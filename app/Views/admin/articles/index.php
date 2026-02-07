<?php
/**
 * Admin Articles List
 */
$pageTitle = $t('articles');
ob_start();
?>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><?= $t('all_articles') ?> (<?= $total ?? 0 ?>)</h3>
        <a href="<?= url('admin/articles/create') ?>" class="btn btn-gold btn-sm">
            <i class="fas fa-plus"></i> <?= $t('add_new') ?>
        </a>
    </div>
    
    <!-- Filters -->
    <div style="padding:1rem 1.5rem;border-bottom:1px solid var(--border-color);display:flex;gap:1rem;flex-wrap:wrap;">
        <a href="<?= url('admin/articles') ?>" class="btn btn-sm <?= empty($statusFilter) ? 'btn-gold' : 'btn-outline' ?>"><?= $t('all') ?></a>
        <a href="<?= url('admin/articles?status=published') ?>" class="btn btn-sm <?= ($statusFilter ?? '') === 'published' ? 'btn-gold' : 'btn-outline' ?>"><?= $t('published') ?></a>
        <a href="<?= url('admin/articles?status=draft') ?>" class="btn btn-sm <?= ($statusFilter ?? '') === 'draft' ? 'btn-gold' : 'btn-outline' ?>"><?= $t('draft') ?></a>
        <a href="<?= url('admin/articles?status=pending') ?>" class="btn btn-sm <?= ($statusFilter ?? '') === 'pending' ? 'btn-gold' : 'btn-outline' ?>"><?= $t('pending') ?></a>
    </div>
    
    <div class="admin-card__body" style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px;"><input type="checkbox" id="selectAll"></th>
                    <th><?= $t('image') ?></th>
                    <th><?= $t('title') ?></th>
                    <th><?= $t('category') ?></th>
                    <th><?= $t('author') ?></th>
                    <th><?= $t('status') ?></th>
                    <th><?= $t('views') ?></th>
                    <th><?= $t('date') ?></th>
                    <th><?= $t('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($articles)): ?>
                    <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="<?= $article->id ?>"></td>
                        <td>
                            <?php if ($article->featured_image): ?>
                            <img src="<?= upload_url($article->featured_image) ?>" alt="" style="width:60px;height:40px;object-fit:cover;border-radius:4px;">
                            <?php else: ?>
                            <div style="width:60px;height:40px;background:var(--bg-secondary);border-radius:4px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= url('admin/articles/edit/' . $article->id) ?>" style="font-weight:500;">
                                <?= excerpt($article->{'title_' . $lang} ?? $article->title_ku, 50) ?>
                            </a>
                            <?php if ($article->is_featured): ?>
                            <i class="fas fa-star" style="color:var(--gold);margin-left:4px;" title="Featured"></i>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="color:<?= $article->category_color ?? '#d4af37' ?>;">
                                <?= $article->category_name ?? '-' ?>
                            </span>
                        </td>
                        <td class="text-sm"><?= $article->author_name ?? '-' ?></td>
                        <td>
                            <span class="badge badge-<?= $article->status === 'published' ? 'success' : ($article->status === 'draft' ? 'warning' : 'info') ?>">
                                <?= $t($article->status) ?>
                            </span>
                        </td>
                        <td class="text-sm"><?= number_format($article->views ?? 0) ?></td>
                        <td class="text-sm text-muted"><?= date('Y-m-d', strtotime($article->created_at)) ?></td>
                        <td>
                            <div style="display:flex;gap:0.25rem;">
                                <a href="<?= url('admin/articles/edit/' . $article->id) ?>" class="btn btn-sm btn-outline" title="<?= $t('edit') ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= url('admin/articles/delete/' . $article->id) ?>" class="btn btn-sm" style="background:#e74c3c;color:#fff;" 
                                   onclick="return confirm('<?= $t('confirm_delete') ?>')" title="<?= $t('delete') ?>">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="9" class="text-center text-muted" style="padding:2rem;"><?= $t('no_articles') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if (($totalPages ?? 1) > 1): ?>
    <div style="padding:1rem 1.5rem;display:flex;justify-content:center;">
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= url('admin/articles?page=' . $i . ($statusFilter ? '&status=' . $statusFilter : '')) ?>" 
               class="pagination__btn <?= $i == ($currentPage ?? 1) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('input[name="ids[]"]').forEach(cb => cb.checked = this.checked);
});
</script>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
