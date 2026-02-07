<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class PollController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $polls = $this->db->fetchAll("SELECT * FROM lvp_polls ORDER BY created_at DESC");
        $this->view('admin.polls.index', [
            'pageTitle' => 'Polls',
            'polls' => $polls
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/polls');
        }

        $options = array_filter(array_map('trim', explode("\n", $this->input('options', ''))));
        
        $this->db->insert('lvp_polls', [
            'question_ku' => $this->sanitize($this->input('question_ku', '')),
            'question_en' => $this->sanitize($this->input('question_en', '')),
            'question_ar' => $this->sanitize($this->input('question_ar', '')),
            'options' => json_encode($options),
            'votes' => json_encode(array_fill(0, count($options), 0)),
            'total_votes' => 0,
            'is_active' => $this->input('is_active', 0),
            'expires_at' => $this->input('expires_at') ?: null
        ]);

        flash('success', 'Poll created successfully');
        $this->redirect(APP_URL . '/admin/polls');
    }
}
