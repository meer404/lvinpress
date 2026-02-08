<?php
/**
 * 403 Forbidden - Advanced Tailwind CSS
 */
$lang = $_SESSION['lang'] ?? 'ku';
$dir = in_array($lang, ['ku', 'ar']) ? 'rtl' : 'ltr';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - <?= $lang === 'ku' ? 'ڕێگەپێنەدراو' : ($lang === 'ar' ? 'غير مسموح' : 'Forbidden') ?> | LVINPress</title>
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
                    'shake': 'shake 0.5s ease-in-out',
                    'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    'pulse-slow': 'pulse 3s ease-in-out infinite',
                },
                keyframes: {
                    float: { '0%,100%': { transform: 'translateY(0) rotate(0deg)' }, '50%': { transform: 'translateY(-20px) rotate(5deg)' } },
                    morph: { '0%,100%': { borderRadius: '60% 40% 30% 70%/60% 30% 70% 40%' }, '50%': { borderRadius: '30% 60% 70% 40%/50% 60% 30% 60%' } },
                    shake: { '0%,100%': { transform: 'translateX(0)' }, '25%': { transform: 'translateX(-5px)' }, '75%': { transform: 'translateX(5px)' } },
                    fadeInUp: { '0%': { opacity: '0', transform: 'translateY(30px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                }
            }
        }
    }
    </script>
    <style>
        .noise-bg::before { content:''; position:absolute; inset:0; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E"); pointer-events:none; z-index:1; }
        .orb { position:absolute; border-radius:50%; filter:blur(80px); opacity:0.12; animation:float 10s ease-in-out infinite; }
        .shield-icon { animation: shake 0.5s ease-in-out 1s 1; }
        .magnetic-btn { transition: transform 0.2s ease-out; }
    </style>
</head>
<body class="font-body bg-stone-50 text-stone-900 min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden noise-bg">
    <!-- Background orbs -->
    <div class="orb w-80 h-80 bg-red-500 top-10 -left-20" style="animation-delay:-2s"></div>
    <div class="orb w-72 h-72 bg-brand-gold bottom-20 -right-16" style="animation-delay:-5s"></div>
    <div class="orb w-48 h-48 bg-red-400 top-1/2 left-1/3" style="animation-delay:-3s"></div>

    <!-- Floating shapes -->
    <div class="absolute top-24 left-[12%] w-14 h-14 border-2 border-red-500/15 rounded-lg animate-float rotate-45 hidden md:block"></div>
    <div class="absolute bottom-28 right-[18%] w-10 h-10 border-2 border-brand-gold/20 rounded-full animate-float-delayed hidden md:block"></div>
    <div class="absolute top-1/4 right-[12%] w-20 h-20 animate-morph bg-gradient-to-br from-red-500/10 to-brand-gold/5 hidden md:block"></div>
    <div class="absolute bottom-1/3 left-[8%] w-6 h-6 bg-red-500/15 rounded-full animate-pulse-slow hidden md:block"></div>

    <div class="text-center max-w-lg mx-auto relative z-10">
        <!-- Shield icon + error code -->
        <div class="mb-6 opacity-0 animate-fade-in-up">
            <div class="relative inline-block">
                <span class="font-display text-[10rem] leading-none font-black bg-gradient-to-br from-red-500 via-red-600 to-red-700 bg-clip-text text-transparent select-none">403</span>
                <div class="absolute -top-4 -right-4 shield-icon">
                    <div class="w-16 h-16 rounded-2xl bg-red-500/10 backdrop-blur-sm flex items-center justify-center border border-red-500/20">
                        <i class="fas fa-shield-alt text-2xl text-red-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="font-display text-3xl font-bold mb-4 opacity-0 animate-fade-in-up" style="animation-delay:0.2s">
            <?= $lang === 'ku' ? 'ڕێگەپێنەدراو' : ($lang === 'ar' ? 'غير مسموح بالوصول' : 'Access Forbidden') ?>
        </h1>
        <p class="text-stone-500 leading-relaxed mb-10 text-lg opacity-0 animate-fade-in-up" style="animation-delay:0.4s">
            <?= $lang === 'ku' ? 'ببورە، تۆ ڕێگەت پێنەدراوە بۆ بینینی ئەم پەڕەیە.' : ($lang === 'ar' ? 'عذراً، ليس لديك صلاحية الوصول إلى هذه الصفحة.' : 'Sorry, you do not have permission to access this page.') ?>
        </p>

        <!-- Permission denied visual -->
        <div class="mb-10 opacity-0 animate-fade-in-up" style="animation-delay:0.5s">
            <div class="inline-flex items-center gap-3 px-5 py-3 bg-red-50 border border-red-200/60 rounded-2xl text-red-600 text-sm">
                <i class="fas fa-lock"></i>
                <span><?= $lang === 'ku' ? 'ئەم ناوەڕۆکە پاراستراوە' : ($lang === 'ar' ? 'هذا المحتوى محمي' : 'This content is protected') ?></span>
            </div>
        </div>

        <div class="flex items-center justify-center gap-4 flex-wrap opacity-0 animate-fade-in-up" style="animation-delay:0.7s">
            <a href="<?= APP_URL . '/' . $lang ?>" class="magnetic-btn inline-flex items-center gap-2.5 px-8 py-3.5 bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 font-bold rounded-2xl shadow-lg shadow-brand-gold/25 hover:shadow-xl hover:shadow-brand-gold/30 hover:-translate-y-1 transition-all duration-300">
                <i class="fas fa-home"></i> <?= $lang === 'ku' ? 'گەڕانەوە بۆ ماڵەوە' : ($lang === 'ar' ? 'العودة للرئيسية' : 'Go Home') ?>
            </a>
            <a href="<?= APP_URL . '/login' ?>" class="magnetic-btn inline-flex items-center gap-2.5 px-8 py-3.5 bg-white/80 backdrop-blur border border-stone-200/80 rounded-2xl font-semibold hover:border-brand-gold/50 hover:text-brand-gold hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <i class="fas fa-sign-in-alt"></i> <?= $lang === 'ku' ? 'چوونەژوورەوە' : ($lang === 'ar' ? 'تسجيل الدخول' : 'Login') ?>
            </a>
        </div>
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
