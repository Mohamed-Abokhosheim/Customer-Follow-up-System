<?php
class ServiceModel
{
    private $db;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function getAll($onlyActive = true)
    {
        $query = "SELECT * FROM services";
        if ($onlyActive)
            $query .= " WHERE active = 1";
        return $this->db->query($query)->fetchAll();
    }

    public function getStatuses($service_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM service_statuses WHERE service_id = ? ORDER BY sort_order ASC");
        $stmt->execute([$service_id]);
        return $stmt->fetchAll();
    }

    public function addService($name_ar, $name_en)
    {
        $stmt = $this->db->prepare("INSERT INTO services (name_ar, name_en) VALUES (?, ?)");
        return $stmt->execute([$name_ar, $name_en]);
    }
}
