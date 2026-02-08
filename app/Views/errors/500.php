<?php
/**
 * 500 Internal Server Error - Advanced Tailwind CSS
 */
$lang = $_SESSION['lang'] ?? 'ku';
$dir = in_array($lang, ['ku', 'ar']) ? 'rtl' : 'ltr';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - <?= $lang === 'ku' ? 'هەڵەی سێرڤەر' : ($lang === 'ar' ? 'خطأ في الخادم' : 'Server Error') ?> | LVINPress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: { red: '#B80000', gold: '#d4af37', 'gold-dark': '#b8962e', 'gold-light': '#e8cc6e' },
                    dark: { primary: '#0c0c14', card: '#1a1a2e' }
                },
                fontFamily: {
                    display: ['Playfair Display', 'Georgia', 'serif'],
                    body: ['Inter', 'system-ui', 'sans-serif'],
                },
                animation: {
                    'float': 'float 6s ease-in-out infinite',
                    'float-delayed': 'float 8s ease-in-out 2s infinite',
                    'morph': 'morph 8s ease-in-out infinite',
                    'spin-slow': 'spin 8s linear infinite',
                    'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    'pulse-slow': 'pulse 3s ease-in-out infinite',
                },
                keyframes: {
                    float: { '0%,100%': { transform: 'translateY(0) rotate(0deg)' }, '50%': { transform: 'translateY(-20px) rotate(5deg)' } },
                    morph: { '0%,100%': { borderRadius: '60% 40% 30% 70%/60% 30% 70% 40%' }, '50%': { borderRadius: '30% 60% 70% 40%/50% 60% 30% 60%' } },
                    fadeInUp: { '0%': { opacity: '0', transform: 'translateY(30px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                }
            }
        }
    }
    </script>
    <style>
        .noise-bg::before { content:''; position:absolute; inset:0; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E"); pointer-events:none; z-index:1; }
        .orb { position:absolute; border-radius:50%; filter:blur(80px); opacity:0.12; animation:float 10s ease-in-out infinite; }
        .magnetic-btn { transition: transform 0.2s ease-out; }
        .gear-icon { animation: spin 8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .progress-bar { background: linear-gradient(90deg, #f59e0b, #d97706, #f59e0b); background-size: 200% 100%; animation: shimmer 2s ease-in-out infinite; }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    </style>
</head>
<body class="font-body bg-stone-50 text-stone-900 min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden noise-bg">
    <!-- Background orbs -->
    <div class="orb w-80 h-80 bg-amber-500 top-10 -right-20" style="animation-delay:-2s"></div>
    <div class="orb w-72 h-72 bg-orange-500 bottom-20 -left-16" style="animation-delay:-5s"></div>
    <div class="orb w-48 h-48 bg-amber-400 top-1/3 left-1/4" style="animation-delay:-3s"></div>

    <!-- Floating shapes -->
    <div class="absolute top-20 right-[15%] w-16 h-16 border-2 border-amber-500/15 rounded-lg animate-float rotate-12 hidden md:block"></div>
    <div class="absolute bottom-32 left-[18%] w-10 h-10 border-2 border-orange-500/20 rounded-full animate-float-delayed hidden md:block"></div>
    <div class="absolute top-1/4 left-[10%] w-20 h-20 animate-morph bg-gradient-to-br from-amber-500/10 to-orange-500/5 hidden md:block"></div>
    <div class="absolute bottom-1/4 right-[10%] w-8 h-8 bg-amber-500/15 rounded-full animate-pulse-slow hidden md:block"></div>

    <div class="text-center max-w-lg mx-auto relative z-10">
        <!-- Animated gear + error code -->
        <div class="mb-6 opacity-0 animate-fade-in-up">
            <div class="relative inline-block">
                <span class="font-display text-[10rem] leading-none font-black bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600 bg-clip-text text-transparent select-none">500</span>
                <div class="absolute -top-2 -right-2">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/10 backdrop-blur-sm flex items-center justify-center border border-amber-500/20">
                        <i class="fas fa-cog text-xl text-amber-600 gear-icon"></i>
                    </div>
                </div>
                <div class="absolute -bottom-2 -left-2">
                    <div class="w-10 h-10 rounded-xl bg-orange-500/10 backdrop-blur-sm flex items-center justify-center border border-orange-500/20">
                        <i class="fas fa-cog text-sm text-orange-500 gear-icon" style="animation-direction:reverse;animation-duration:6s"></i>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="font-display text-3xl font-bold mb-4 opacity-0 animate-fade-in-up" style="animation-delay:0.2s">
            <?= $lang === 'ku' ? 'هەڵەی سێرڤەر' : ($lang === 'ar' ? 'خطأ في الخادم' : 'Server Error') ?>
        </h1>
        <p class="text-stone-500 leading-relaxed mb-8 text-lg opacity-0 animate-fade-in-up" style="animation-delay:0.4s">
            <?= $lang === 'ku' ? 'ببورە، هەڵەیەک لە سێرڤەرەکەدا ڕوویدا. تکایە دواتر هەوڵبدەرەوە.' : ($lang === 'ar' ? 'عذراً، حدث خطأ في الخادم. يرجى المحاولة لاحقاً.' : 'Sorry, something went wrong on our end. Please try again later.') ?>
        </p>

        <!-- Fake progress bar -->
        <div class="mb-10 opacity-0 animate-fade-in-up" style="animation-delay:0.5s">
            <div class="max-w-xs mx-auto">
                <div class="flex items-center justify-between text-xs text-stone-400 mb-2">
                    <span><?= $lang === 'ku' ? 'چاککردنەوە...' : ($lang === 'ar' ? 'جاري الإصلاح...' : 'Fixing...') ?></span>
                    <span class="font-mono">...</span>
                </div>
                <div class="h-1.5 bg-stone-200 rounded-full overflow-hidden">
                    <div class="progress-bar h-full rounded-full w-2/3"></div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center gap-4 flex-wrap opacity-0 animate-fade-in-up" style="animation-delay:0.7s">
            <a href="<?= APP_URL . '/' . $lang ?>" class="magnetic-btn inline-flex items-center gap-2.5 px-8 py-3.5 bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 font-bold rounded-2xl shadow-lg shadow-brand-gold/25 hover:shadow-xl hover:shadow-brand-gold/30 hover:-translate-y-1 transition-all duration-300">
                <i class="fas fa-home"></i> <?= $lang === 'ku' ? 'گەڕانەوە بۆ ماڵەوە' : ($lang === 'ar' ? 'العودة للرئيسية' : 'Go Home') ?>
            </a>
            <button onclick="location.reload()" class="magnetic-btn inline-flex items-center gap-2.5 px-8 py-3.5 bg-white/80 backdrop-blur border border-stone-200/80 rounded-2xl font-semibold hover:border-amber-500/50 hover:text-amber-600 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <i class="fas fa-redo"></i> <?= $lang === 'ku' ? 'هەوڵدانەوە' : ($lang === 'ar' ? 'إعادة المحاولة' : 'Try Again') ?>
            </button>
        </div>

        <!-- Auto-retry notice -->
        <p class="mt-8 text-xs text-stone-400 opacity-0 animate-fade-in-up" style="animation-delay:0.9s">
            <i class="fas fa-info-circle me-1"></i>
            <?= $lang === 'ku' ? 'ئەگەر کێشەکە بەردەوام بوو، پەیوەندیمان پێوە بکە' : ($lang === 'ar' ? 'إذا استمرت المشكلة، تواصل معنا' : 'If the problem persists, contact support') ?>
        </p>
    </div>

    <script>
    document.querySelectorAll('.magnetic-btn').forEach(btn => {
        btn.addEventListener('mousemove', e => {
            const rect = btn.getBoundingClientRect();
            const x = (e.clientX - rect.left - rect.width/2) * 0.15;
            const y = (e.clientY - rect.top - rect.height/2) * 0.15;
            btn.style.transform = `translate(${x}px, ${y}px)`;
        });
        btn.addEventListener('mouseleave', () => { btn.style.transform = ''; });
    });
    </script>
</body>
</html>
