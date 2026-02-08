<?php
/**
 * Admin Settings
 */
$pageTitle = $t('settings');
ob_start();
?>

<form method="POST" action="<?= url('admin/settings/update') ?>">
    <?= csrf_field() ?>
    
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
        <!-- General Settings -->
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-cog"></i> <?= $t('general_settings') ?></h3></div>
            <div class="admin-card__body">
                <div class="form-group">
                    <label class="form-label"><?= $t('site_name') ?> (KU)</label>
                    <input type="text" name="settings[site_name_ku]" class="form-control" value="<?= htmlspecialchars($settings['site_name_ku'] ?? 'لڤین پرێس') ?>" dir="rtl">
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('site_name') ?> (EN)</label>
                    <input type="text" name="settings[site_name_en]" class="form-control" value="<?= htmlspecialchars($settings['site_name_en'] ?? 'LVINPress') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('site_name') ?> (AR)</label>
                    <input type="text" name="settings[site_name_ar]" class="form-control" value="<?= htmlspecialchars($settings['site_name_ar'] ?? 'لفين برس') ?>" dir="rtl">
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('tagline') ?> (KU)</label>
                    <input type="text" name="settings[tagline_ku]" class="form-control" value="<?= htmlspecialchars($settings['tagline_ku'] ?? '') ?>" dir="rtl">
                </div>
                <div class="form-group">
                    <label class="form-label"><?= $t('default_language') ?></label>
                    <select name="settings[default_lang]" class="form-control">
                        <option value="ku" <?= ($settings['default_lang'] ?? 'ku') === 'ku' ? 'selected' : '' ?>>کوردی</option>
                        <option value="en" <?= ($settings['default_lang'] ?? '') === 'en' ? 'selected' : '' ?>>English</option>
                        <option value="ar" <?= ($settings['default_lang'] ?? '') === 'ar' ? 'selected' : '' ?>>العربية</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- SEO Settings -->
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-search"></i> <?= $t('seo_settings') ?></h3></div>
            <div class="admin-card__body">
                <div class="form-group">
                    <label class="form-label">Meta Description (KU)</label>
                    <textarea name="settings[meta_description_ku]" class="form-control" rows="3" dir="rtl"><?= htmlspecialchars($settings['meta_description_ku'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Description (EN)</label>
                    <textarea name="settings[meta_description_en]" class="form-control" rows="3"><?= htmlspecialchars($settings['meta_description_en'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="settings[meta_keywords]" class="form-control" value="<?= htmlspecialchars($settings['meta_keywords'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Google Analytics ID</label>
                    <input type="text" name="settings[google_analytics]" class="form-control" value="<?= htmlspecialchars($settings['google_analytics'] ?? '') ?>" placeholder="G-XXXXXXXXXX">
                </div>
            </div>
        </div>
        
        <!-- Social Media -->
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-share-alt"></i> <?= $t('social_media') ?></h3></div>
            <div class="admin-card__body">
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-facebook"></i> Facebook</label>
                    <input type="url" name="settings[social_facebook]" class="form-control" value="<?= htmlspecialchars($settings['social_facebook'] ?? '') ?>" dir="ltr">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-x-twitter"></i> X (Twitter)</label>
                    <input type="url" name="settings[social_twitter]" class="form-control" value="<?= htmlspecialchars($settings['social_twitter'] ?? '') ?>" dir="ltr">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-instagram"></i> Instagram</label>
                    <input type="url" name="settings[social_instagram]" class="form-control" value="<?= htmlspecialchars($settings['social_instagram'] ?? '') ?>" dir="ltr">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-youtube"></i> YouTube</label>
                    <input type="url" name="settings[social_youtube]" class="form-control" value="<?= htmlspecialchars($settings['social_youtube'] ?? '') ?>" dir="ltr">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-telegram"></i> Telegram</label>
                    <input type="url" name="settings[social_telegram]" class="form-control" value="<?= htmlspecialchars($settings['social_telegram'] ?? '') ?>" dir="ltr">
                </div>
            </div>
        </div>
        
        <!-- Content Settings -->
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-newspaper"></i> <?= $t('content_settings') ?></h3></div>
            <div class="admin-card__body">
                <div class="form-group">
                    <label class="form-label"><?= $t('articles_per_page') ?></label>
                    <input type="number" name="settings[articles_per_page]" class="form-control" value="<?= $settings['articles_per_page'] ?? 12 ?>" min="1" max="50">
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="settings[comments_enabled]" value="1" <?= ($settings['comments_enabled'] ?? '1') == '1' ? 'checked' : '' ?>>
                        <span><?= $t('enable_comments') ?></span>
                    </label>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="settings[comment_moderation]" value="1" <?= ($settings['comment_moderation'] ?? '1') == '1' ? 'checked' : '' ?>>
                        <span><?= $t('moderate_comments') ?></span>
                    </label>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="settings[registration_enabled]" value="1" <?= ($settings['registration_enabled'] ?? '1') == '1' ? 'checked' : '' ?>>
                        <span><?= $t('enable_registration') ?></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <div style="margin-top:1.5rem;text-align:center;">
        <button type="submit" class="btn btn-gold" style="padding:0.75rem 3rem;">
            <i class="fas fa-save"></i> <?= $t('save_settings') ?>
        </button>
    </div>
</form>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
