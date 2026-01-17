<?php
class SourceModel
{
    private $db;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function getAll($onlyActive = true)
    {
        $query = "SELECT * FROM sources";
        if ($onlyActive)
            $query .= " WHERE active = 1";
        return $this->db->query($query)->fetchAll();
    }

    public function addSource($data)
    {
        $stmt = $this->db->prepare("INSERT INTO sources (name_ar, name_en) VALUES (?, ?)");
        return $stmt->execute([$data['name_ar'], $data['name_en']]);
    }
}
