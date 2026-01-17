<?php
require_once __DIR__ . '/../models/ServiceModel.php';

class ServiceController
{
    public function index()
    {
        Auth::adminOnly();
        $serviceModel = new ServiceModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CSRF::verify($_POST['csrf_token']);
            $serviceModel->addService($_POST['name_ar'], $_POST['name_en']);
            Flash::set('success', 'Service added');
            header('Location: index.php?route=admin/services');
            exit;
        }

        $services = $serviceModel->getAll(false);
        $title = __('services');
        include __DIR__ . '/../views/admin/services.php';
    }
}
