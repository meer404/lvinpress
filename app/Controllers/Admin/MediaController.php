<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class MediaController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $media = $this->db->fetchAll("SELECT * FROM lvp_media ORDER BY created_at DESC LIMIT 100");
        $this->view('admin.media.index', ['media' => $media, 'pageTitle' => 'Media Library']);
    }

    public function upload(): void
    {
        $this->requireAdmin();
        if (empty($_FILES['file']['tmp_name'])) {
            $this->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }

        $file = $_FILES['file'];
        $path = upload_image($file, 'media');
        
        if (!$path) {
            $this->json(['success' => false, 'message' => 'Upload failed'], 400);
        }

        $user = $this->getCurrentUser();
        $id = $this->db->insert('lvp_media', [
            'user_id' => $user->id,
            'filename' => basename($path),
            'original_name' => $file['name'],
            'path' => $path,
            'mime_type' => $file['type'],
            'size' => $file['size']
        ]);

        $this->json([
            'success' => true,
            'data' => [
                'id' => $id,
                'url' => upload_url($path),
                'path' => $path
            ]
        ]);
    }

    public function delete(string $id): void
    {
        $this->requireAdmin();
        $media = $this->db->fetch("SELECT * FROM lvp_media WHERE id = ?", [(int)$id]);
        if ($media) {
            $filePath = UPLOAD_PATH . '/' . $media->path;
            if (file_exists($filePath)) unlink($filePath);
            $this->db->delete('lvp_media', 'id = ?', [(int)$id]);
        }
        flash('success', 'Media deleted');
        $this->redirect(APP_URL . '/admin/media');
    }
}
