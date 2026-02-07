<?php
namespace App\Controllers\Api;

use App\Core\Controller;

class PollController extends Controller
{
    public function vote(): void
    {
        $pollId = (int)($_POST['poll_id'] ?? 0);
        $optionIndex = (int)($_POST['option'] ?? -1);
        
        if (!$pollId || $optionIndex < 0) {
            $this->json(['success' => false, 'message' => 'Invalid vote'], 400);
            return;
        }

        // Check if already voted (by session)
        if (isset($_SESSION['voted_polls'][$pollId])) {
            $this->json(['success' => false, 'message' => 'Already voted']);
            return;
        }

        $poll = $this->db->fetch("SELECT * FROM lvp_polls WHERE id = ? AND is_active = 1", [$pollId]);
        if (!$poll) {
            $this->json(['success' => false, 'message' => 'Poll not found'], 404);
            return;
        }

        $votes = json_decode($poll->votes ?? '{}', true);
        $votes[$optionIndex] = ($votes[$optionIndex] ?? 0) + 1;

        $this->db->update('lvp_polls', [
            'votes' => json_encode($votes),
            'total_votes' => $poll->total_votes + 1
        ], 'id = ?', [$pollId]);

        $_SESSION['voted_polls'][$pollId] = true;

        $this->json(['success' => true, 'votes' => $votes, 'total' => $poll->total_votes + 1]);
    }
}
