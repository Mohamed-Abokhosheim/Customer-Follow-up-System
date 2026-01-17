<?php
require_once __DIR__ . '/../models/LeadModel.php';
require_once __DIR__ . '/../models/FollowupModel.php';

class DashboardController
{
    public function index()
    {
        $leadModel = new LeadModel();
        $followupModel = new FollowupModel();

        $stats = [
            'total_leads' => $leadModel->countAll(),
            'won_leads' => $leadModel->countByStatusType('won'),
            'lost_leads' => $leadModel->countByStatusType('lost'),
            'leads_by_service' => $leadModel->countByService(),
            'leads_by_source' => $leadModel->countBySource(),
            'upcoming_followups' => $followupModel->getUpcoming(Auth::user()['id'], 5),
            'overdue_count' => $followupModel->countOverdue(Auth::user()['id']),
        ];

        $title = __('dashboard');
        include __DIR__ . '/../views/dashboard.php';
    }
}
