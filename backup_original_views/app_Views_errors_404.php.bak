<?php
/**
 * 404 Not Found
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
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <style>
        body { background: var(--bg-primary, #fff); color: var(--text-primary, #1c1917); }
        .error-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 2rem;
        }
        .error-illustration {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(212,175,55,0.1) 0%, transparent 70%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .error-code {
            font-size: 6rem;
            font-weight: 900;
            font-family: 'Playfair Display', Georgia, serif;
            background: linear-gradient(135deg, #d4af37, #f0d060);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }
        .error-title {
            font-size: 1.5rem;
            font-family: 'Playfair Display', Georgia, serif;
            margin: 1rem 0;
        }
        .error-desc {
            color: #78716c;
            max-width: 500px;
            margin-bottom: 2rem;
            line-height: 1.7;
        }
        .error-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-gold {
            background: linear-gradient(135deg, #d4af37, #b8941e);
            color: #0a0a0a;
            box-shadow: 0 4px 14px rgba(212, 175, 55, 0.3);
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }
        .btn-outline {
            background: transparent;
            border: 1px solid rgba(0,0,0,0.1);
            color: inherit;
        }
        .btn-outline:hover {
            border-color: #d4af37;
            color: #d4af37;
        }
        .error-search {
            margin-top: 2rem;
            max-width: 400px;
            width: 100%;
        }
        .error-search form {
            display: flex;
            gap: 0.5rem;
        }
        .error-search input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 100px;
            font-size: 0.9rem;
            outline: none;
        }
        .error-search input:focus {
            border-color: #d4af37;
        }
    </style>
</head>
<body data-theme="light">
    <div class="error-page">
        <div class="error-illustration">
            <div class="error-code">404</div>
        </div>
        <h1 class="error-title">
            <?= $lang === 'ku' ? 'پەڕەکە نەدۆزرایەوە' : ($lang === 'ar' ? 'الصفحة غير موجودة' : 'Page Not Found') ?>
        </h1>
        <p class="error-desc">
            <?= $lang === 'ku' ? 'ببورە، ئەو پەڕەیەی بەدوایدا دەگەڕێیت بوونی نییە یان گۆڕدراوە. لەوانەیە سڕاوە یان بەستەرەکە هەڵە بێت.' : ($lang === 'ar' ? 'عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها. ربما تم حذفها أو أن الرابط غير صحيح.' : 'Sorry, the page you are looking for does not exist or has been moved. It might have been deleted or the link might be incorrect.') ?>
        </p>
        <div class="error-actions">
            <a href="<?= APP_URL . '/' . $lang ?>" class="btn btn-gold">
                <i class="fas fa-home"></i> <?= $lang === 'ku' ? 'گەڕانەوە بۆ ماڵەوە' : ($lang === 'ar' ? 'العودة للرئيسية' : 'Go Home') ?>
            </a>
            <a href="<?= APP_URL . '/' . $lang . '/search' ?>" class="btn btn-outline">
                <i class="fas fa-search"></i> <?= $lang === 'ku' ? 'گەڕان' : ($lang === 'ar' ? 'بحث' : 'Search') ?>
            </a>
        </div>
        <div class="error-search">
            <form action="<?= APP_URL . '/' . $lang . '/search' ?>" method="GET">
                <input type="text" name="q" placeholder="<?= $lang === 'ku' ? 'گەڕان...' : ($lang === 'ar' ? 'بحث...' : 'Search...') ?>">
                <button type="submit" class="btn btn-gold"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
</body>
</html>
