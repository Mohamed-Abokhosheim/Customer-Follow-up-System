<?php
require_once __DIR__ . '/../models/LeadModel.php';

class ReportController
{
    public function index()
    {
        $leadModel = new LeadModel();

        $serviceStats = $leadModel->countByService();
        $sourceStats = $leadModel->countBySource();


        global $pdo;
        $pipelineReport = $pdo->query("
            SELECT s.name_en as service_name, ss.name_en as status_name, COUNT(ls.lead_id) as lead_count
            FROM services s
            JOIN service_statuses ss ON s.id = ss.service_id
            LEFT JOIN lead_services ls ON ss.id = ls.status_id
            GROUP BY s.id, ss.id
            ORDER BY s.id, ss.sort_order
        ")->fetchAll();

        if (isset($_GET['export']) && $_GET['export'] === 'csv') {
            $this->exportCSV($pipelineReport);
            exit;
        }

        $title = __('reports');
        include __DIR__ . '/../views/reports/index.php';
    }

    private function exportCSV($data)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=pipeline_report.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Service', 'Status', 'Lead Count']);
        foreach ($data as $row) {
            fputcsv($output, [$row['service_name'], $row['status_name'], $row['lead_count']]);
        }
        fclose($output);
    }
}
