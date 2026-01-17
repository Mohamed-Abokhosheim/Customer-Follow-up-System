<?php
class LeadModel
{
    private $db;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function countAll()
    {
        return $this->db->query("SELECT COUNT(*) FROM leads")->fetchColumn();
    }

    public function countByStatusType($type)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(DISTINCT lead_id) 
            FROM lead_services ls
            JOIN service_statuses ss ON ls.status_id = ss.id
            WHERE ss.type = ?
        ");
        $stmt->execute([$type]);
        return $stmt->fetchColumn();
    }

    public function countByService()
    {
        return $this->db->query("
            SELECT s.name_en, s.name_ar, COUNT(*) as count 
            FROM lead_services ls
            JOIN services s ON ls.service_id = s.id
            GROUP BY s.id
        ")->fetchAll();
    }

    public function countBySource()
    {
        return $this->db->query("
            SELECT s.name_en, s.name_ar, COUNT(*) as count 
            FROM leads l
            JOIN sources s ON l.source_id = s.id
            GROUP BY s.id
        ")->fetchAll();
    }

    public function getAll($filters = [], $sort = 'newest')
    {
        $query = "SELECT l.*, s.name_en as source_name_en, s.name_ar as source_name_ar, u.name as creator_name 
                  FROM leads l
                  LEFT JOIN sources s ON l.source_id = s.id
                  LEFT JOIN users u ON l.created_by = u.id
                  WHERE 1=1";
        $params = [];

        if (!empty($filters['search'])) {
            $query .= " AND (l.full_name LIKE ? OR l.mobile LIKE ? OR l.company_or_activity LIKE ?)";
            $term = "%" . $filters['search'] . "%";
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
        }

        if (!empty($filters['source_id'])) {
            $query .= " AND l.source_id = ?";
            $params[] = $filters['source_id'];
        }

        if (!empty($filters['created_by'])) {
            $query .= " AND l.created_by = ?";
            $params[] = $filters['created_by'];
        }

        switch ($sort) {
            case 'oldest':
                $query .= " ORDER BY l.created_at ASC";
                break;
            case 'last_contact':
                $query .= " ORDER BY l.last_contact_at DESC";
                break;
            default:
                $query .= " ORDER BY l.created_at DESC";
                break;
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT l.*, s.name_en as source_name_en, s.name_ar as source_name_ar, u.name as creator_name 
            FROM leads l
            LEFT JOIN sources s ON l.source_id = s.id
            LEFT JOIN users u ON l.created_by = u.id
            WHERE l.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getServices($lead_id)
    {
        $stmt = $this->db->prepare("
            SELECT ls.*, s.name_en, s.name_ar, ss.name_en as status_en, ss.name_ar as status_ar, ss.type as status_type
            FROM lead_services ls
            JOIN services s ON ls.service_id = s.id
            JOIN service_statuses ss ON ls.status_id = ss.id
            WHERE ls.lead_id = ?
        ");
        $stmt->execute([$lead_id]);
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
                INSERT INTO leads (full_name, mobile, company_or_activity, source_id, referral_referrer_name, source_notes, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $data['full_name'],
                $data['mobile'],
                $data['company_or_activity'],
                $data['source_id'],
                $data['referral_referrer_name'],
                $data['source_notes'],
                Auth::user()['id']
            ]);
            $lead_id = $this->db->lastInsertId();

            if (!empty($data['services'])) {
                foreach ($data['services'] as $service_id => $status_id) {
                    $stmt = $this->db->prepare("INSERT INTO lead_services (lead_id, service_id, status_id) VALUES (?, ?, ?)");
                    $stmt->execute([$lead_id, $service_id, $status_id]);
                }
            }

            $this->db->commit();
            return $lead_id;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function updateStatus($lead_id, $service_id, $status_id)
    {
        $stmt = $this->db->prepare("UPDATE lead_services SET status_id = ? WHERE lead_id = ? AND service_id = ?");
        return $stmt->execute([$status_id, $lead_id, $service_id]);
    }
}
