<?php
/**
 * Admin Polls Management
 */
$pageTitle = $t('polls') ?? 'Polls';
ob_start();
?>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><?= $t('all_polls') ?? 'All Polls' ?></h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('pollModal').style.display='flex'">
            <i class="fas fa-plus"></i> <?= $t('add_new') ?>
        </button>
    </div>
    <div class="admin-card__body" style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><?= $t('question') ?></th>
                    <th><?= $t('votes') ?? 'Total Votes' ?></th>
                    <th><?= $t('status') ?></th>
                    <th><?= $t('expires') ?? 'Expires' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($polls)): ?>
                    <?php foreach ($polls as $poll): ?>
                    <tr>
                        <td><?= htmlspecialchars($poll->{'question_' . $lang} ?? $poll->question_ku ?? '') ?></td>
                        <td><?= number_format($poll->total_votes ?? 0) ?></td>
                        <td>
                            <span class="badge badge-<?= ($poll->is_active ?? 0) ? 'success' : 'warning' ?>">
                                <?= ($poll->is_active ?? 0) ? $t('active') : $t('inactive') ?>
                            </span>
                        </td>
                        <td class="text-sm text-muted"><?= $poll->expires_at ? date('Y-m-d', strtotime($poll->expires_at)) : '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="4" class="text-center text-muted" style="padding:2rem;"><?= $t('no_polls') ?? 'No polls found' ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Poll Modal -->
<div id="pollModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:1000;">
    <div style="background:var(--bg-primary);border-radius:var(--radius-lg);padding:1.5rem;max-width:600px;width:90%;max-height:90vh;overflow-y:auto;">
        <h3 style="margin-bottom:1rem;"><?= $t('add_poll') ?? 'Add Poll' ?></h3>
        <form method="POST" action="<?= url('admin/polls/store') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label"><?= $t('question') ?> (کوردی)</label>
                <input type="text" name="question_ku" class="form-control" dir="rtl" required>
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('question') ?> (English)</label>
                <input type="text" name="question_en" class="form-control" dir="ltr">
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('question') ?> (العربية)</label>
                <input type="text" name="question_ar" class="form-control" dir="rtl">
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('options') ?? 'Options' ?> (<?= $t('one_per_line') ?? 'One per line' ?>)</label>
                <textarea name="options" class="form-control" rows="5" required placeholder="Option 1&#10;Option 2&#10;Option 3"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('expires_at') ?? 'Expires At' ?></label>
                <input type="datetime-local" name="expires_at" class="form-control">
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span><?= $t('active') ?></span>
                </label>
            </div>
            <div style="display:flex;gap:0.5rem;justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('pollModal').style.display='none'"><?= $t('cancel') ?></button>
                <button type="submit" class="btn btn-gold"><?= $t('save') ?></button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
