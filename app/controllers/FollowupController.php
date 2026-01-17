<?php
require_once __DIR__ . '/../models/FollowupModel.php';

class FollowupController
{
    public function index()
    {
        $followupModel = new FollowupModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            CSRF::verify($_POST['csrf_token']);
            if ($_POST['action'] === 'mark_done') {
                $followupModel->markDone($_POST['id']);
                Flash::set('success', 'Follow-up marked as completed');
            }
            header('Location: index.php?route=followups');
            exit;
        }

        $filters = ['status' => $_GET['status'] ?? 'pending'];
        $followups = $followupModel->getForUser(Auth::user()['id'], $filters);

        $title = __('my_followups');
        include __DIR__ . '/../views/followups/index.php';
    }
}
