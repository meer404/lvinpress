<?php
/**
 * Register Page
 */
include VIEW_PATH . '/frontend/partials/header.php';
?>

<section class="auth-page">
    <div class="auth-card">
        <div class="auth-card__header">
            <h1><?= $t('register') ?></h1>
            <p class="text-muted"><?= $t('register_desc') ?? $t('register') ?></p>
        </div>
        
        <?php if ($flash = $_SESSION['flash'] ?? null): ?>
        <?php $flashErrors = $_SESSION['flash']['errors'] ?? null; $flashError = $_SESSION['flash']['error'] ?? null; unset($_SESSION['flash']['errors'], $_SESSION['flash']['error']); ?>
        <?php if ($flashErrors && is_array($flashErrors)): ?>
        <div class="flash-message flash-error">
            <ul style="margin:0;padding-left:1.2rem;">
                <?php foreach ($flashErrors as $err): ?>
                <li><?= $err ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php elseif ($flashError): ?>
        <div class="flash-message flash-error"><?= $flashError ?></div>
        <?php endif; ?>
        <?php endif; ?>
        
        <form method="POST" action="<?= url('register') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label"><?= $t('full_name') ?></label>
                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars(old('full_name') ?? '') ?>" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('username') ?></label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username ?? '') ?>" required pattern="[a-zA-Z0-9_]+" minlength="3">
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('email') ?></label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('password') ?></label>
                <div style="position:relative;">
                    <input type="password" name="password" id="regPassword" class="form-control" required minlength="6">
                    <button type="button" onclick="togglePassword('regPassword')" 
                            style="position:absolute;top:50%;right:12px;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('confirm_password') ?></label>
                <input type="password" name="confirm_password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-gold" style="width:100%;padding:0.875rem;"><?= $t('register') ?></button>
        </form>
        
        <div class="auth-card__footer">
            <p><?= $t('have_account') ?> <a href="<?= url('login') ?>"><?= $t('login') ?></a></p>
        </div>
    </div>
</section>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const icon = input.nextElementSibling?.querySelector('i');
    if (input.type === 'password') { input.type = 'text'; icon?.classList.replace('fa-eye', 'fa-eye-slash'); }
    else { input.type = 'password'; icon?.classList.replace('fa-eye-slash', 'fa-eye'); }
}
</script>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
