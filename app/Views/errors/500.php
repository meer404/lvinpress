<?php
/**
 * 500 Server Error
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
            background: linear-gradient(135deg, rgba(230,126,34,0.1) 0%, transparent 70%);
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
            background: linear-gradient(135deg, #e67e22, #d35400);
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
        .error-icon {
            font-size: 4rem;
            color: #e67e22;
            margin-bottom: 1rem;
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
        .error-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .loading-icon {
            animation: spin 2s linear infinite;
        }
    </style>
</head>
<body data-theme="light">
    <div class="error-page">
        <div class="error-illustration">
            <i class="fas fa-exclamation-triangle error-icon"></i>
        </div>
        <div class="error-code">500</div>
        <h1 class="error-title">
            <?= $lang === 'ku' ? 'هەڵەی سێرڤەر' : ($lang === 'ar' ? 'خطأ في الخادم' : 'Internal Server Error') ?>
        </h1>
        <p class="error-desc">
            <?= $lang === 'ku' ? 'ببورە، کێشەیەک ڕوویدا لە سێرڤەرەکەدا. تیمی تەکنیکیمان ئاگاداری ئەم کێشەیەن. تکایە دواتر هەوڵ بدەرەوە.' : ($lang === 'ar' ? 'عذراً، حدث خطأ في الخادم. الفريق التقني على علم بهذه المشكلة. يرجى المحاولة لاحقاً.' : 'Sorry, something went wrong on our end. Our technical team has been notified. Please try again later.') ?>
        </p>
        <div class="error-actions">
            <a href="<?= APP_URL . '/' . $lang ?>" class="btn btn-gold">
                <i class="fas fa-home"></i> <?= $lang === 'ku' ? 'ماڵەوە' : ($lang === 'ar' ? 'الرئيسية' : 'Home') ?>
            </a>
            <button onclick="location.reload()" class="btn btn-outline">
                <i class="fas fa-redo"></i> <?= $lang === 'ku' ? 'هەوڵدانەوە' : ($lang === 'ar' ? 'إعادة المحاولة' : 'Retry') ?>
            </button>
        </div>
    </div>
</body>
</html>
