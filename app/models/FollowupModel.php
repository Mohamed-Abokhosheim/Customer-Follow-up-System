<?php
class FollowupModel
{
    private $db;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function getUpcoming($user_id, $limit = 10)
    {
        $stmt = $this->db->prepare("
            SELECT f.*, l.full_name as lead_name 
            FROM followups f
            JOIN leads l ON f.lead_id = l.id
            WHERE f.assigned_to = :user_id AND f.is_done = 0 AND f.followup_at >= NOW()
            ORDER BY f.followup_at ASC
            LIMIT :limit
        ");
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countOverdue($user_id)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM followups 
            WHERE assigned_to = ? AND is_done = 0 AND followup_at < NOW()
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn();
    }

    public function getForUser($user_id, $filters = [])
    {
        $query = "SELECT f.*, l.full_name as lead_name, l.mobile as lead_mobile 
                  FROM followups f
                  JOIN leads l ON f.lead_id = l.id
                  WHERE (f.assigned_to = ? OR ? = 'admin')";
        $params = [$user_id, Auth::user()['role']];

        if (isset($filters['status'])) {
            if ($filters['status'] === 'pending')
                $query .= " AND f.is_done = 0";
            if ($filters['status'] === 'done')
                $query .= " AND f.is_done = 1";
        }

        $query .= " ORDER BY f.followup_at ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO followups (lead_id, assigned_to, followup_at, notes) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['lead_id'],
            $data['assigned_to'],
            $data['followup_at'],
            $data['notes']
        ]);
    }

    public function markDone($id)
    {
        $stmt = $this->db->prepare("UPDATE followups SET is_done = 1, done_at = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
