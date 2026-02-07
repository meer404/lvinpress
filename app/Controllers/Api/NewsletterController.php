<?php
namespace App\Controllers\Api;

use App\Core\Controller;

class NewsletterController extends Controller
{
    public function subscribe(): void
    {
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        
        if (!$email) {
            $this->json(['success' => false, 'message' => 'Invalid email'], 400);
            return;
        }

        $exists = $this->db->fetch("SELECT id FROM lvp_newsletter WHERE email = ?", [$email]);
        
        if ($exists) {
            $this->json(['success' => false, 'message' => 'Already subscribed']);
            return;
        }

        $this->db->insert('lvp_newsletter', [
            'email' => $email,
            'name' => $this->sanitize($_POST['name'] ?? ''),
            'language' => $this->lang,
            'token' => bin2hex(random_bytes(32))
        ]);

        $this->json(['success' => true, 'message' => 'Successfully subscribed!']);
    }
}
