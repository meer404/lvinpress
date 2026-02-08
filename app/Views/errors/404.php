<?php
/**
 * 404 Not Found - Advanced Tailwind CSS
 */
$lang = $_SESSION['lang'] ?? 'ku';
$dir = in_array($lang, ['ku', 'ar']) ? 'rtl' : 'ltr';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - <?= $lang === 'ku' ? 'پەڕە نەدۆزرایەوە' : ($lang === 'ar' ? 'الصفحة غير موجودة' : 'Page Not Found') ?> | LVINPress</title>
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
                    'glitch': 'glitch 2s ease-in-out infinite',
                    'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    'pulse-slow': 'pulse 3s ease-in-out infinite',
                },
                keyframes: {
                    float: { '0%,100%': { transform: 'translateY(0) rotate(0deg)' }, '50%': { transform: 'translateY(-20px) rotate(5deg)' } },
                    morph: { '0%,100%': { borderRadius: '60% 40% 30% 70%/60% 30% 70% 40%' }, '50%': { borderRadius: '30% 60% 70% 40%/50% 60% 30% 60%' } },
                    glitch: { '0%,100%': { textShadow: '2px 0 #d4af37, -2px 0 #B80000' }, '25%': { textShadow: '-2px -2px #d4af37, 2px 2px #B80000' }, '50%': { textShadow: '2px 2px #d4af37, -2px -2px #B80000' }, '75%': { textShadow: '-2px 0 #d4af37, 2px 0 #B80000' } },
                    fadeInUp: { '0%': { opacity: '0', transform: 'translateY(30px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                }
            }
        }
    }
    </script>
    <style>
        .noise-bg::before { content:''; position:absolute; inset:0; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E"); pointer-events:none; z-index:1; }
        .glitch-text { position:relative; }
        .glitch-text::before, .glitch-text::after { content:attr(data-text); position:absolute; left:0; top:0; width:100%; height:100%; }
        .glitch-text::before { animation: glitchClip 3s infinite linear alternate-reverse; clip-path:polygon(0 0,100% 0,100% 45%,0 45%); transform:translate(-3px,-2px); opacity:0.7; }
        .glitch-text::after { animation: glitchClip 3s infinite linear alternate-reverse 1.5s; clip-path:polygon(0 55%,100% 55%,100% 100%,0 100%); transform:translate(3px,2px); opacity:0.7; }
        @keyframes glitchClip { 0%{clip-path:polygon(0 0,100% 0,100% 45%,0 45%)} 20%{clip-path:polygon(0 15%,100% 15%,100% 55%,0 55%)} 40%{clip-path:polygon(0 30%,100% 30%,100% 70%,0 70%)} 60%{clip-path:polygon(0 10%,100% 10%,100% 50%,0 50%)} 80%{clip-path:polygon(0 40%,100% 40%,100% 80%,0 80%)} 100%{clip-path:polygon(0 0,100% 0,100% 45%,0 45%)} }
        .orb { position:absolute; border-radius:50%; filter:blur(80px); opacity:0.15; animation:float 10s ease-in-out infinite; }
        .magnetic-btn { transition: transform 0.2s ease-out; }
    </style>
</head>
<body class="font-body bg-stone-50 text-stone-900 min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden noise-bg">
    <!-- Background orbs -->
    <div class="orb w-72 h-72 bg-brand-gold top-10 -left-20" style="animation-delay:-2s"></div>
    <div class="orb w-96 h-96 bg-brand-red bottom-10 -right-20" style="animation-delay:-5s"></div>
    <div class="orb w-48 h-48 bg-brand-gold-light top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" style="animation-delay:-3s"></div>

    <!-- Floating shapes -->
    <div class="absolute top-20 left-[15%] w-16 h-16 border-2 border-brand-gold/20 rounded-lg animate-float rotate-12 hidden md:block"></div>
    <div class="absolute bottom-32 right-[20%] w-12 h-12 border-2 border-brand-red/20 rounded-full animate-float-delayed hidden md:block"></div>
    <div class="absolute top-1/3 right-[10%] w-8 h-8 bg-brand-gold/10 rounded-full animate-pulse-slow hidden md:block"></div>
    <div class="absolute bottom-1/4 left-[10%] w-20 h-20 animate-morph bg-gradient-to-br from-brand-gold/10 to-brand-red/5 hidden md:block"></div>

    <div class="text-center max-w-lg mx-auto relative z-10">
        <!-- Glitch error code -->
        <div class="mb-6 opacity-0 animate-fade-in-up">
            <span class="glitch-text font-display text-[10rem] leading-none font-black bg-gradient-to-br from-brand-gold via-brand-gold-dark to-brand-gold-light bg-clip-text text-transparent select-none" data-text="404">404</span>
        </div>

        <h1 class="font-display text-3xl font-bold mb-4 opacity-0 animate-fade-in-up" style="animation-delay:0.2s">
            <?= $lang === 'ku' ? 'پەڕەکە نەدۆزرایەوە' : ($lang === 'ar' ? 'الصفحة غير موجودة' : 'Page Not Found') ?>
        </h1>
        <p class="text-stone-500 leading-relaxed mb-10 text-lg opacity-0 animate-fade-in-up" style="animation-delay:0.4s">
            <?= $lang === 'ku' ? 'ببورە، ئەو پەڕەیەی بەدوایدا دەگەڕێیت بوونی نییە یان گۆڕدراوە.' : ($lang === 'ar' ? 'عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.' : 'Sorry, the page you are looking for does not exist or has been moved.') ?>
        </p>

        <div class="flex items-center justify-center gap-4 flex-wrap mb-10 opacity-0 animate-fade-in-up" style="animation-delay:0.6s">
            <a href="<?= APP_URL . '/' . $lang ?>" class="magnetic-btn inline-flex items-center gap-2.5 px-8 py-3.5 bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 font-bold rounded-2xl shadow-lg shadow-brand-gold/25 hover:shadow-xl hover:shadow-brand-gold/30 hover:-translate-y-1 transition-all duration-300">
                <i class="fas fa-home"></i> <?= $lang === 'ku' ? 'گەڕانەوە بۆ ماڵەوە' : ($lang === 'ar' ? 'العودة للرئيسية' : 'Go Home') ?>
            </a>
            <a href="<?= APP_URL . '/' . $lang . '/search' ?>" class="magnetic-btn inline-flex items-center gap-2.5 px-8 py-3.5 bg-white/80 backdrop-blur border border-stone-200/80 rounded-2xl font-semibold hover:border-brand-gold/50 hover:text-brand-gold hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <i class="fas fa-search"></i> <?= $lang === 'ku' ? 'گەڕان' : ($lang === 'ar' ? 'بحث' : 'Search') ?>
            </a>
        </div>

        <div class="max-w-md mx-auto opacity-0 animate-fade-in-up" style="animation-delay:0.8s">
            <form action="<?= APP_URL . '/' . $lang . '/search' ?>" method="GET" class="flex gap-2 bg-white/80 backdrop-blur-sm p-2 rounded-2xl border border-stone-200/60 shadow-sm">
                <input type="text" name="q" placeholder="<?= $lang === 'ku' ? 'گەڕان...' : ($lang === 'ar' ? 'بحث...' : 'Search...') ?>"
                       class="flex-1 px-5 py-3 bg-transparent text-sm outline-none placeholder:text-stone-400">
                <button type="submit" class="magnetic-btn px-6 py-3 bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 rounded-xl font-bold hover:shadow-lg hover:shadow-brand-gold/20 transition-all duration-300">
                    <i class="fas fa-arrow-right text-sm"></i>
                </button>
            </form>
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
