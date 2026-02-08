<?php
/**
 * Login Page - Advanced Tailwind CSS
 */
include VIEW_PATH . '/frontend/partials/header.php';
?>

<section class="relative flex items-center justify-center min-h-[70vh] px-4 py-12 overflow-hidden">
    <!-- Animated bg orbs -->
    <div class="orb orb-1 top-20 left-[20%]"></div>
    <div class="orb orb-2 bottom-20 right-[20%]"></div>
    
    <div class="w-full max-w-md relative z-10" data-animate data-animate-type="scale">
        <div class="glass-card bg-white dark:bg-dark-card rounded-2xl shadow-xl dark:shadow-black/20 border border-stone-100 dark:border-white/5 overflow-hidden">
            <!-- Header -->
            <div class="text-center pt-8 pb-4 px-8">
                <div class="w-14 h-14 bg-gradient-to-br from-brand-red to-brand-red-dark rounded-xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-brand-red/20 pulse-glow">
                    <i class="fas fa-user text-white text-lg"></i>
                </div>
                <h1 class="font-display text-2xl font-bold text-stone-900 dark:text-white"><?= $t('login') ?></h1>
                <p class="text-sm text-stone-400 dark:text-stone-500 mt-1"><?= $t('login_desc') ?? $t('login') ?></p>
            </div>
            
            <!-- Body -->
            <div class="px-8 pb-8 pt-2">
                <?php $flashError = $_SESSION['flash']['error'] ?? null; unset($_SESSION['flash']['error']); ?>
                <?php if ($flashError): ?>
                <div class="flex items-center gap-2 p-3 mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-xl text-sm text-red-600 dark:text-red-400 animate-slide-down">
                    <i class="fas fa-exclamation-circle"></i> <?= $flashError ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="<?= url('login') ?>" class="space-y-4">
                    <?= csrf_field() ?>
                    <div class="relative">
                        <input type="text" name="login" id="loginEmail" value="<?= htmlspecialchars(old('login') ?? '') ?>" required autofocus placeholder=" "
                               class="peer w-full px-4 py-3 pt-5 bg-stone-50 dark:bg-dark-tertiary border border-stone-200 dark:border-white/10 rounded-xl text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/10 transition-all">
                        <label for="loginEmail" class="floating-label"><i class="far fa-envelope text-xs opacity-50 mr-1"></i> <?= $t('email') ?> / <?= $t('username') ?></label>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="loginPassword" required placeholder=" "
                               class="peer w-full px-4 py-3 pt-5 bg-stone-50 dark:bg-dark-tertiary border border-stone-200 dark:border-white/10 rounded-xl text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/10 transition-all pr-10">
                        <label for="loginPassword" class="floating-label"><i class="fas fa-lock text-xs opacity-50 mr-1"></i> <?= $t('password') ?></label>
                        <button type="button" onclick="togglePassword('loginPassword')" 
                                class="absolute top-1/2 right-3 -translate-y-1/2 text-stone-400 hover:text-stone-600 dark:hover:text-stone-300 transition-colors p-1">
                            <i class="far fa-eye text-sm"></i>
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" value="1" class="accent-brand-red w-4 h-4 rounded"> 
                            <span class="text-sm text-stone-500 dark:text-stone-400 group-hover:text-stone-700 dark:group-hover:text-stone-300 transition-colors"><?= $t('remember_me') ?></span>
                        </label>
                    </div>
                    <button type="submit" class="magnetic-btn w-full py-3 bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 font-bold rounded-xl shadow-md shadow-brand-gold/20 hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm">
                        <?= $t('login') ?> <i class="fas fa-arrow-<?= $isRtl ?? false ? 'left' : 'right' ?> text-xs ml-1"></i>
                    </button>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="text-center py-4 border-t border-stone-100 dark:border-white/5 bg-stone-50/50 dark:bg-dark-tertiary/50">
                <p class="text-sm text-stone-500 dark:text-stone-400">
                    <?= $t('no_account') ?> <a href="<?= url('register') ?>" class="text-brand-red font-semibold hover:text-brand-gold transition-colors"><?= $t('register') ?> <i class="fas fa-arrow-<?= $isRtl ?? false ? 'left' : 'right' ?> text-[10px]"></i></a>
                </p>
            </div>
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
