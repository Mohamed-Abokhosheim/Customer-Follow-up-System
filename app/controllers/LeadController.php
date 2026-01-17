<?php
require_once __DIR__ . '/../models/LeadModel.php';
require_once __DIR__ . '/../models/ServiceModel.php';
require_once __DIR__ . '/../models/SourceModel.php';
require_once __DIR__ . '/../models/FollowupModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class LeadController
{
    public function index()
    {
        $leadModel = new LeadModel();
        $sourceModel = new SourceModel();
        $userModel = new UserModel();

        $filters = [
            'search' => $_GET['search'] ?? '',
            'source_id' => $_GET['source_id'] ?? '',
            'created_by' => $_GET['created_by'] ?? '',
        ];
        $sort = $_GET['sort'] ?? 'newest';

        $leads = $leadModel->getAll($filters, $sort);
        $sources = $sourceModel->getAll();
        $users = $userModel->getAll();

        $title = __('leads');
        include __DIR__ . '/../views/leads/index.php';
    }

    public function create()
    {
        $serviceModel = new ServiceModel();
        $sourceModel = new SourceModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CSRF::verify($_POST['csrf_token']);

            $leadModel = new LeadModel();
            $data = [
                'full_name' => $_POST['full_name'],
                'mobile' => $_POST['mobile'],
                'company_or_activity' => $_POST['company_or_activity'],
                'source_id' => $_POST['source_id'],
                'referral_referrer_name' => $_POST['referral_referrer_name'] ?? null,
                'source_notes' => $_POST['source_notes'] ?? null,
                'services' => []
            ];

            if (!empty($_POST['services'])) {
                foreach ($_POST['services'] as $svc_id) {
                    $statuses = $serviceModel->getStatuses($svc_id);
                    $data['services'][$svc_id] = $statuses[0]['id'] ?? 0;
                }
            }

            $lead_id = $leadModel->create($data);
            if ($lead_id) {
                Flash::set('success', __('success_msg'));
                header('Location: index.php?route=leads/view&id=' . $lead_id);
                exit;
            }
        }

        $services = $serviceModel->getAll();
        $sources = $sourceModel->getAll();
        $title = __('add_new') . ' ' . __('leads');
        include __DIR__ . '/../views/leads/create.php';
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;
        if (!$id)
            header('Location: index.php?route=leads');

        $leadModel = new LeadModel();
        $serviceModel = new ServiceModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            CSRF::verify($_POST['csrf_token']);
            if ($_POST['action'] === 'update_status') {
                $leadModel->updateStatus($id, $_POST['service_id'], $_POST['status_id']);
                Flash::set('success', 'Status updated');
            } elseif ($_POST['action'] === 'add_followup') {
                $followupModel = new FollowupModel();
                $followupModel->create([
                    'lead_id' => $id,
                    'assigned_to' => $_POST['assigned_to'],
                    'followup_at' => $_POST['followup_date'] . ' ' . $_POST['followup_time'],
                    'notes' => $_POST['notes']
                ]);
                Flash::set('success', 'Follow-up scheduled');
            }
            header("Location: index.php?route=leads/view&id=$id");
            exit;
        }

        $lead = $leadModel->find($id);
        $lead_services = $leadModel->getServices($id);

        $userModel = new UserModel();
        $users = $userModel->getAll();

        $title = $lead['full_name'];
        include __DIR__ . '/../views/leads/view.php';
    }
}
