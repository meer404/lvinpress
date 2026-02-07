<?php
/**
 * Login Page
 */
include VIEW_PATH . '/frontend/partials/header.php';
?>

<section class="auth-page">
    <div class="auth-card">
        <div class="auth-card__header">
            <h1><?= $t('login') ?></h1>
            <p class="text-muted"><?= $t('login_desc') ?? $t('login') ?></p>
        </div>
        
        <?php $flashError = $_SESSION['flash']['error'] ?? null; unset($_SESSION['flash']['error']); ?>
        <?php if ($flashError): ?>
            <div class="flash-message flash-error"><?= $flashError ?></div>
        <?php endif; ?>
        
        <form method="POST" action="<?= url('login') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label"><?= $t('email') ?></label>
                <input type="text" name="login" class="form-control" value="<?= htmlspecialchars(old('login') ?? '') ?>" required autofocus placeholder="<?= $t('email') ?> / <?= $t('username') ?>">
            </div>
            <div class="form-group">
                <label class="form-label"><?= $t('password') ?></label>
                <div style="position:relative;">
                    <input type="password" name="password" id="loginPassword" class="form-control" required>
                    <button type="button" onclick="togglePassword('loginPassword')" 
                            style="position:absolute;top:50%;right:12px;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--spacing-lg);">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                    <input type="checkbox" name="remember" value="1"> 
                    <span class="text-sm"><?= $t('remember_me') ?></span>
                </label>
            </div>
            <button type="submit" class="btn btn-gold" style="width:100%;padding:0.875rem;"><?= $t('login') ?></button>
        </form>
        
        <div class="auth-card__footer">
            <p><?= $t('no_account') ?> <a href="<?= url('register') ?>"><?= $t('register') ?></a></p>
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
