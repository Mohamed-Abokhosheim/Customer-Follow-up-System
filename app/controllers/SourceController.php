<?php
require_once __DIR__ . '/../models/SourceModel.php';

class SourceController
{
    public function index()
    {
        Auth::adminOnly();
        $sourceModel = new SourceModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CSRF::verify($_POST['csrf_token']);
            $sourceModel->addSource([
                'name_ar' => $_POST['name_ar'],
                'name_en' => $_POST['name_en']
            ]);
            Flash::set('success', 'Source added');
            header('Location: index.php?route=admin/sources');
            exit;
        }

        $sources = $sourceModel->getAll(false);
        $title = __('sources');
        include __DIR__ . '/../views/admin/sources.php';
    }
}
