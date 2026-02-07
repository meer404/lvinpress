<?php
namespace App\Controllers\Api;

use App\Core\Controller;

class LangController extends Controller
{
    public function change(): void
    {
        $lang = $_GET['lang'] ?? 'ku';
        $supported = unserialize(SUPPORTED_LANGS);
        
        if (in_array($lang, $supported)) {
            $_SESSION['lang'] = $lang;
        }
        
        $this->json(['success' => true, 'lang' => $_SESSION['lang']]);
    }
}
