<?php
/**
 * Admin Ads Management
 */
$pageTitle = $t('ads') ?? 'Ads Management';
ob_start();
?>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><?= $t('all_ads') ?? 'All Ads' ?></h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('adModal').style.display='flex'">
            <i class="fas fa-plus"></i> <?= $t('add_new') ?>
        </button>
    </div>
    <div class="admin-card__body" style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><?= $t('title') ?></th>
                    <th><?= $t('position') ?></th>
                    <th><?= $t('status') ?></th>
                    <th><?= $t('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ads)): ?>
                    <?php foreach ($ads as $ad): ?>
                    <tr>
                        <td><?= htmlspecialchars($ad->title ?? '') ?></td>
                        <td><span class="badge"><?= ucfirst($ad->position ?? 'sidebar') ?></span></td>
                        <td>
                            <span class="badge badge-<?= ($ad->is_active ?? 0) ? 'success' : 'warning' ?>">
                                <?= ($ad->is_active ?? 0) ? $t('active') : $t('inactive') ?>
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:0.25rem;">
                                <a href="<?= url('admin/ads/delete/' . $ad->id) ?>" class="btn btn-sm" style="background:#e74c3c;color:#fff;" 
                                   onclick="return confirm('<?= $t('confirm_delete') ?>')"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="4" class="text-center text-muted" style="padding:2rem;"><?= $t('no_ads') ?? 'No ads found' ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Ad Modal -->
<div id="adModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:1000;">
    <div style="background:var(--bg-primary);border-radius:var(--radius-lg);padding:1.5rem;max-width:500px;width:90%;">
        <h3 style="margin-bottom:1rem;"><?= $t('add_ad') ?? 'Add Advertisement' ?></h3>
        <form method="POST" action="<?= url('admin/ads/store') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label"><?= $t('title') ?></label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('position') ?></label>
                <select name="position" class="form-control">
                    <option value="header">Header</option>
                    <option value="sidebar">Sidebar</option>
                    <option value="article">In Article</option>
                    <option value="footer">Footer</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('ad_code') ?? 'Ad Code' ?></label>
                <textarea name="code" class="form-control" rows="4" placeholder="HTML/JavaScript code"></textarea>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span><?= $t('active') ?></span>
                </label>
            </div>
            <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('adModal').style.display='none'"><?= $t('cancel') ?></button>
                <button type="submit" class="btn btn-gold"><?= $t('save') ?></button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
