<?php
/**
 * Admin Settings - Tailwind CSS Redesign
 */
$pageTitle = $t('settings');
ob_start();
?>

<form method="POST" action="<?= url('admin/settings/update') ?>">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- General Settings -->
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-4 border-b border-stone-100">
                <i class="fas fa-cog text-stone-400 text-sm"></i>
                <h3 class="font-semibold text-stone-800"><?= $t('general_settings') ?></h3>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('site_name') ?> (KU)</label>
                    <input type="text" name="settings[site_name_ku]" dir="rtl" value="<?= htmlspecialchars($settings['site_name_ku'] ?? 'لڤین پرێس') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('site_name') ?> (EN)</label>
                    <input type="text" name="settings[site_name_en]" value="<?= htmlspecialchars($settings['site_name_en'] ?? 'LVINPress') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('site_name') ?> (AR)</label>
                    <input type="text" name="settings[site_name_ar]" dir="rtl" value="<?= htmlspecialchars($settings['site_name_ar'] ?? 'لفين برس') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('tagline') ?> (KU)</label>
                    <input type="text" name="settings[tagline_ku]" dir="rtl" value="<?= htmlspecialchars($settings['tagline_ku'] ?? '') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('default_language') ?></label>
                    <select name="settings[default_lang]" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                        <option value="ku" <?= ($settings['default_lang'] ?? 'ku') === 'ku' ? 'selected' : '' ?>>کوردی</option>
                        <option value="en" <?= ($settings['default_lang'] ?? '') === 'en' ? 'selected' : '' ?>>English</option>
                        <option value="ar" <?= ($settings['default_lang'] ?? '') === 'ar' ? 'selected' : '' ?>>العربية</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- SEO Settings -->
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-4 border-b border-stone-100">
                <i class="fas fa-search text-stone-400 text-sm"></i>
                <h3 class="font-semibold text-stone-800"><?= $t('seo_settings') ?></h3>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5">Meta Description (KU)</label>
                    <textarea name="settings[meta_description_ku]" rows="3" dir="rtl" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold resize-y"><?= htmlspecialchars($settings['meta_description_ku'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5">Meta Description (EN)</label>
                    <textarea name="settings[meta_description_en]" rows="3" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold resize-y"><?= htmlspecialchars($settings['meta_description_en'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5">Meta Keywords</label>
                    <input type="text" name="settings[meta_keywords]" value="<?= htmlspecialchars($settings['meta_keywords'] ?? '') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5">Google Analytics ID</label>
                    <input type="text" name="settings[google_analytics]" value="<?= htmlspecialchars($settings['google_analytics'] ?? '') ?>" placeholder="G-XXXXXXXXXX" dir="ltr"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-4 border-b border-stone-100">
                <i class="fas fa-share-alt text-stone-400 text-sm"></i>
                <h3 class="font-semibold text-stone-800"><?= $t('social_media') ?></h3>
            </div>
            <div class="p-5 space-y-4">
                <?php
                $socials = [
                    ['name' => 'Facebook', 'key' => 'social_facebook', 'icon' => 'fab fa-facebook', 'color' => 'text-blue-600'],
                    ['name' => 'X (Twitter)', 'key' => 'social_twitter', 'icon' => 'fab fa-x-twitter', 'color' => 'text-stone-800'],
                    ['name' => 'Instagram', 'key' => 'social_instagram', 'icon' => 'fab fa-instagram', 'color' => 'text-pink-500'],
                    ['name' => 'YouTube', 'key' => 'social_youtube', 'icon' => 'fab fa-youtube', 'color' => 'text-red-600'],
                    ['name' => 'Telegram', 'key' => 'social_telegram', 'icon' => 'fab fa-telegram', 'color' => 'text-sky-500'],
                ];
                foreach ($socials as $social): ?>
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-stone-600 mb-1.5">
                        <i class="<?= $social['icon'] ?> <?= $social['color'] ?>"></i> <?= $social['name'] ?>
                    </label>
                    <input type="url" name="settings[<?= $social['key'] ?>]" dir="ltr" value="<?= htmlspecialchars($settings[$social['key']] ?? '') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Content Settings -->
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-4 border-b border-stone-100">
                <i class="fas fa-newspaper text-stone-400 text-sm"></i>
                <h3 class="font-semibold text-stone-800"><?= $t('content_settings') ?></h3>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('articles_per_page') ?></label>
                    <input type="number" name="settings[articles_per_page]" value="<?= $settings['articles_per_page'] ?? 12 ?>" min="1" max="50"
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="settings[comments_enabled]" value="1" <?= ($settings['comments_enabled'] ?? '1') == '1' ? 'checked' : '' ?> class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30">
                    <span class="text-sm text-stone-700"><?= $t('enable_comments') ?></span>
                </label>
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="settings[comment_moderation]" value="1" <?= ($settings['comment_moderation'] ?? '1') == '1' ? 'checked' : '' ?> class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30">
                    <span class="text-sm text-stone-700"><?= $t('moderate_comments') ?></span>
                </label>
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="settings[registration_enabled]" value="1" <?= ($settings['registration_enabled'] ?? '1') == '1' ? 'checked' : '' ?> class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30">
                    <span class="text-sm text-stone-700"><?= $t('enable_registration') ?></span>
                </label>
            </div>
        </div>
    </div>

    <div class="mt-6 text-center">
        <button type="submit" class="px-8 py-3 bg-brand-gold text-white font-semibold rounded-xl hover:bg-brand-gold-dark transition shadow-sm inline-flex items-center gap-2">
            <i class="fas fa-save"></i> <?= $t('save_settings') ?>
        </button>
    </div>
</form>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
