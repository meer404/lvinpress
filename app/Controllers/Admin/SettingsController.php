<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class SettingsController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $settings = $this->db->fetchAll("SELECT * FROM lvp_settings ORDER BY setting_group, setting_key");
        
        $grouped = [];
        foreach ($settings as $s) {
            $grouped[$s->setting_group][] = $s;
        }
        
        $this->view('admin.settings.index', [
            'settings' => $grouped,
            'pageTitle' => 'Settings'
        ]);
    }

    public function update(): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) { flash('error', 'Invalid token'); $this->redirect(APP_URL . '/admin/settings'); }

        foreach ($_POST as $key => $value) {
            if ($key === CSRF_TOKEN_NAME) continue;
            $this->db->query(
                "INSERT INTO lvp_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?",
                [$key, $value, $value]
            );
        }

        flash('success', 'Settings updated');
        $this->redirect(APP_URL . '/admin/settings');
    }
}
