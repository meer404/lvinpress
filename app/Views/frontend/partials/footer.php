    </main>

    <!-- Newsletter Section -->
    <section class="newsletter-section relative bg-gradient-to-br from-dark-card via-dark-secondary to-dark-primary py-16 lg:py-24 overflow-hidden noise-bg">
        <!-- Animated background orbs -->
        <div class="orb orb-1 top-10 left-[10%]"></div>
        <div class="orb orb-2 bottom-10 right-[15%]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_50%,rgba(184,0,0,0.08),transparent_70%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_80%,rgba(212,175,55,0.06),transparent_60%)]"></div>
        
        <div class="max-w-container mx-auto px-4 lg:px-6 relative z-10">
            <div class="max-w-xl mx-auto text-center" data-animate>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-gold/10 border border-brand-gold/20 text-brand-gold text-xs font-semibold mb-5 tracking-wider uppercase">
                    <i class="fas fa-envelope text-[10px]"></i> <?= $t('newsletter') ?>
                </div>
                <h2 class="font-display text-2xl lg:text-4xl font-bold text-white mb-3"><?= $t('newsletter') ?></h2>
                <p class="text-stone-400 text-sm lg:text-base mb-8 leading-relaxed"><?= $t('subscribe_text') ?></p>
                <form class="flex flex-col sm:flex-row gap-3" id="newsletterForm" onsubmit="return subscribeNewsletter(event)">
                    <div class="flex-1 relative">
                        <input type="email" name="email" class="w-full bg-white/5 border border-white/10 rounded-full px-6 py-4 text-white placeholder-white/30 outline-none focus:border-brand-gold/40 focus:ring-2 focus:ring-brand-gold/10 transition-all pr-12" placeholder="<?= $t('enter_email') ?>" required>
                        <i class="far fa-envelope absolute right-5 top-1/2 -translate-y-1/2 text-white/20"></i>
                    </div>
                    <button type="submit" class="magnetic-btn px-8 py-4 bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 font-bold rounded-full shadow-lg shadow-brand-gold/20 hover:shadow-xl hover:shadow-brand-gold/30 hover:-translate-y-0.5 transition-all whitespace-nowrap text-sm tracking-wide">
                        <?= $t('subscribe') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?> text-xs ml-1 rtl:ml-0 rtl:mr-1"></i>
                    </button>
                </form>
                <p class="text-sm mt-4 hidden transition-all" id="newsletterMsg"></p>
                <p class="text-xs text-stone-600 mt-4 flex items-center justify-center gap-1.5">
                    <i class="fas fa-lock text-[10px]"></i> <?= $lang === 'ku' ? 'هیچ سپامێک نییە. دڵنیاییت.' : ($lang === 'ar' ? 'لا بريد مزعج. مضمون.' : 'No spam. Unsubscribe anytime.') ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-stone-950 text-stone-400 relative overflow-hidden">
        <!-- Gradient accent -->
        <div class="gradient-border"></div>
        
        <div class="pt-16 pb-8">
        <div class="max-w-container mx-auto px-4 lg:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <!-- Brand -->
                <div data-animate>
                    <div class="mb-5">
                        <div class="font-display text-2xl font-bold text-shimmer mb-2">LVINPRESS</div>
                        <p class="text-stone-500 text-sm leading-relaxed"><?= $settings->{'site_description_' . $lang} ?? 'Premium Luxury News Platform' ?></p>
                    </div>
                    <div class="flex items-center gap-2 share-btn-group">
                        <?php if (!empty($settings->social_facebook)): ?>
                        <a href="<?= $settings->social_facebook ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-stone-400 hover:bg-[#1877f2] hover:text-white transition-all duration-300" aria-label="Facebook"><i class="fab fa-facebook-f text-sm"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings->social_twitter)): ?>
                        <a href="<?= $settings->social_twitter ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-stone-400 hover:bg-stone-800 hover:text-white transition-all duration-300" aria-label="Twitter"><i class="fab fa-x-twitter text-sm"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings->social_instagram)): ?>
                        <a href="<?= $settings->social_instagram ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-stone-400 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-500 hover:text-white transition-all duration-300" aria-label="Instagram"><i class="fab fa-instagram text-sm"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings->social_youtube)): ?>
                        <a href="<?= $settings->social_youtube ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-stone-400 hover:bg-red-600 hover:text-white transition-all duration-300" aria-label="YouTube"><i class="fab fa-youtube text-sm"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($settings->social_telegram)): ?>
                        <a href="<?= $settings->social_telegram ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-stone-400 hover:bg-[#0088cc] hover:text-white transition-all duration-300" aria-label="Telegram"><i class="fab fa-telegram text-sm"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div data-animate>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-5 relative pl-4 rtl:pl-0 rtl:pr-4 before:absolute before:left-0 rtl:before:left-auto rtl:before:right-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:bg-brand-gold before:rounded-full"><?= $t('quick_links') ?></h4>
                    <ul class="space-y-2.5">
                        <li><a href="<?= lang_url() ?>" class="text-sm text-stone-500 hover:text-brand-gold hover:translate-x-1 rtl:hover:-translate-x-1 transition-all duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] opacity-40 rtl:rotate-180"></i><?= $t('home') ?></a></li>
                        <li><a href="<?= lang_url('page/about') ?>" class="text-sm text-stone-500 hover:text-brand-gold hover:translate-x-1 rtl:hover:-translate-x-1 transition-all duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] opacity-40 rtl:rotate-180"></i><?= $t('about_us') ?></a></li>
                        <li><a href="<?= lang_url('page/contact') ?>" class="text-sm text-stone-500 hover:text-brand-gold hover:translate-x-1 rtl:hover:-translate-x-1 transition-all duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] opacity-40 rtl:rotate-180"></i><?= $t('contact_us') ?></a></li>
                        <li><a href="<?= lang_url('page/privacy') ?>" class="text-sm text-stone-500 hover:text-brand-gold hover:translate-x-1 rtl:hover:-translate-x-1 transition-all duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] opacity-40 rtl:rotate-180"></i><?= $t('privacy_policy') ?></a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div data-animate>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-5 relative pl-4 rtl:pl-0 rtl:pr-4 before:absolute before:left-0 rtl:before:left-auto rtl:before:right-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:bg-brand-gold before:rounded-full"><?= $t('categories') ?></h4>
                    <ul class="space-y-2.5">
                        <?php foreach ($menuCats ?? [] as $fCat): ?>
                        <li><a href="<?= lang_url('category/' . $fCat->slug_en) ?>" class="text-sm text-stone-500 hover:text-brand-gold hover:translate-x-1 rtl:hover:-translate-x-1 transition-all duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] opacity-40 rtl:rotate-180"></i><?= $fCat->{'name_' . $lang} ?? $fCat->name_en ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Follow Us -->
                <div data-animate>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-5 relative pl-4 rtl:pl-0 rtl:pr-4 before:absolute before:left-0 rtl:before:left-auto rtl:before:right-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:bg-brand-gold before:rounded-full"><?= $t('follow_us') ?></h4>
                    <ul class="space-y-2.5">
                        <?php if (!empty($settings->social_facebook)): ?>
                        <li><a href="<?= $settings->social_facebook ?>" target="_blank" class="text-sm text-stone-500 hover:text-brand-gold transition-colors flex items-center gap-2"><i class="fab fa-facebook-f w-4 opacity-60"></i>Facebook</a></li>
                        <?php endif; ?>
                        <?php if (!empty($settings->social_twitter)): ?>
                        <li><a href="<?= $settings->social_twitter ?>" target="_blank" class="text-sm text-stone-500 hover:text-brand-gold transition-colors flex items-center gap-2"><i class="fab fa-x-twitter w-4 opacity-60"></i>Twitter / X</a></li>
                        <?php endif; ?>
                        <?php if (!empty($settings->social_instagram)): ?>
                        <li><a href="<?= $settings->social_instagram ?>" target="_blank" class="text-sm text-stone-500 hover:text-brand-gold transition-colors flex items-center gap-2"><i class="fab fa-instagram w-4 opacity-60"></i>Instagram</a></li>
                        <?php endif; ?>
                        <?php if (!empty($settings->social_youtube)): ?>
                        <li><a href="<?= $settings->social_youtube ?>" target="_blank" class="text-sm text-stone-500 hover:text-brand-gold transition-colors flex items-center gap-2"><i class="fab fa-youtube w-4 opacity-60"></i>YouTube</a></li>
                        <?php endif; ?>
                        <?php if (!empty($settings->social_telegram)): ?>
                        <li><a href="<?= $settings->social_telegram ?>" target="_blank" class="text-sm text-stone-500 hover:text-brand-gold transition-colors flex items-center gap-2"><i class="fab fa-telegram w-4 opacity-60"></i>Telegram</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-white/5 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-stone-600">
                <span>&copy; <?= date('Y') ?> <?= $settings->{'site_name_' . $lang} ?? 'LVINPress' ?>. <?= $t('all_rights_reserved') ?></span>
                <span class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-brand-red rounded-full animate-pulse"></span>
                    Luxury News Platform
                </span>
            </div>
        </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button class="back-to-top-btn fixed bottom-6 right-6 rtl:right-auto rtl:left-6 w-12 h-12 bg-gradient-to-br from-brand-gold to-brand-gold-dark text-stone-900 rounded-xl shadow-lg shadow-brand-gold/30 flex items-center justify-center opacity-0 translate-y-4 pointer-events-none transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:rounded-2xl z-50 group" id="backToTop">
        <i class="fas fa-chevron-up text-sm group-hover:animate-bounce"></i>
    </button>

    <!-- Keyboard Shortcuts Panel -->
    <div id="shortcutsPanel" class="fixed inset-0 z-[3000] bg-black/60 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6 border border-stone-200 dark:border-white/10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-lg font-bold text-stone-900 dark:text-white flex items-center gap-2"><i class="fas fa-keyboard text-brand-gold"></i> <?= $lang === 'ku' ? 'کورتبڕەکان' : 'Keyboard Shortcuts' ?></h3>
                <button onclick="toggleShortcuts()" class="text-stone-400 hover:text-stone-600 dark:hover:text-stone-300"><i class="fas fa-times"></i></button>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between py-2 border-b border-stone-100 dark:border-white/5"><span class="text-stone-600 dark:text-stone-400"><?= $lang === 'ku' ? 'گەڕان' : 'Search' ?></span><kbd class="px-2 py-1 bg-stone-100 dark:bg-dark-tertiary rounded text-xs font-mono">⌘ K</kbd></div>
                <div class="flex items-center justify-between py-2 border-b border-stone-100 dark:border-white/5"><span class="text-stone-600 dark:text-stone-400"><?= $lang === 'ku' ? 'دۆخی تیشکخستن' : 'Focus Mode' ?></span><kbd class="px-2 py-1 bg-stone-100 dark:bg-dark-tertiary rounded text-xs font-mono">F</kbd></div>
                <div class="flex items-center justify-between py-2 border-b border-stone-100 dark:border-white/5"><span class="text-stone-600 dark:text-stone-400"><?= $lang === 'ku' ? 'تاریک/ڕووناک' : 'Dark/Light' ?></span><kbd class="px-2 py-1 bg-stone-100 dark:bg-dark-tertiary rounded text-xs font-mono">D</kbd></div>
                <div class="flex items-center justify-between py-2"><span class="text-stone-600 dark:text-stone-400"><?= $lang === 'ku' ? 'کورتبڕەکان' : 'Shortcuts' ?></span><kbd class="px-2 py-1 bg-stone-100 dark:bg-dark-tertiary rounded text-xs font-mono">?</kbd></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= asset('js/app.js') ?>"></script>
    <script>
    // Mobile nav toggle
    (function() {
        const toggle = document.getElementById('mobileMenuToggle');
        const drawer = document.getElementById('mobileNavDrawer');
        const overlay = document.getElementById('mobileNavOverlay');
        const panel = document.getElementById('mobileNavPanel');
        const close = document.getElementById('mobileNavClose');
        
        function openNav() {
            drawer.classList.add('pointer-events-auto');
            drawer.classList.remove('pointer-events-none');
            overlay.classList.add('opacity-100');
            overlay.classList.remove('opacity-0');
            panel.classList.remove('translate-x-full', 'rtl:-translate-x-full');
            panel.classList.add('translate-x-0');
            toggle.classList.add('active');
        }
        function closeNav() {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            panel.classList.add('translate-x-full', 'rtl:-translate-x-full');
            panel.classList.remove('translate-x-0');
            toggle.classList.remove('active');
            setTimeout(() => {
                drawer.classList.remove('pointer-events-auto');
                drawer.classList.add('pointer-events-none');
            }, 300);
        }
        
        if (toggle) toggle.addEventListener('click', openNav);
        if (close) close.addEventListener('click', closeNav);
        if (overlay) overlay.addEventListener('click', closeNav);
    })();
    
    // Command Palette / Search
    (function() {
        const searchOverlay = document.getElementById('searchOverlay');
        const searchToggle = document.getElementById('searchToggle');
        const cmdTrigger = document.getElementById('cmdPaletteTrigger');
        const searchClose = document.getElementById('searchClose');
        const searchInput = document.getElementById('searchInput');
        const palette = searchOverlay?.querySelector('.command-palette');
        
        window.openSearch = function() {
            searchOverlay.classList.remove('opacity-0', 'pointer-events-none');
            searchOverlay.classList.add('opacity-100', 'pointer-events-auto');
            if (palette) palette.style.animationPlayState = 'running';
            setTimeout(() => searchInput?.focus(), 150);
        }
        window.closeSearch = function() {
            searchOverlay.classList.add('opacity-0', 'pointer-events-none');
            searchOverlay.classList.remove('opacity-100', 'pointer-events-auto');
        }
        
        if (searchToggle) searchToggle.addEventListener('click', openSearch);
        if (cmdTrigger) cmdTrigger.addEventListener('click', openSearch);
        if (searchClose) searchClose.addEventListener('click', closeSearch);
        searchOverlay?.addEventListener('click', (e) => { if (e.target === searchOverlay) closeSearch(); });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeSearch();
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); openSearch(); }
        });
    })();
    
    // Back to top
    (function() {
        const btn = document.getElementById('backToTop');
        if (btn) {
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 400) {
                    btn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    btn.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                } else {
                    btn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    btn.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                }
            }, { passive: true });
            btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        }
    })();
    
    // Header auto-hide + shadow
    (function() {
        const header = document.getElementById('header');
        if (!header) return;
        let lastScroll = 0;
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const cur = window.pageYOffset;
                    if (cur > 80) {
                        header.classList.add('shadow-lg', 'shadow-stone-900/5');
                        if (cur > lastScroll && cur > 300) {
                            header.style.transform = 'translateY(-100%)';
                        } else {
                            header.style.transform = 'translateY(0)';
                        }
                    } else {
                        header.classList.remove('shadow-lg', 'shadow-stone-900/5');
                        header.style.transform = 'translateY(0)';
                    }
                    lastScroll = cur;
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    })();
    
    // Keyboard shortcuts panel
    window.toggleShortcuts = function() {
        const panel = document.getElementById('shortcutsPanel');
        if (panel.classList.contains('opacity-0')) {
            panel.classList.remove('opacity-0', 'pointer-events-none');
            panel.classList.add('opacity-100', 'pointer-events-auto');
        } else {
            panel.classList.remove('opacity-100', 'pointer-events-auto');
            panel.classList.add('opacity-0', 'pointer-events-none');
        }
    };
    </script>
    <?= $settings->footer_scripts ?? '' ?>
</body>
</html>
