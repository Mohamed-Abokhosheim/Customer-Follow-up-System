<?php
class UserModel
{
    private $db;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, username, email, password, role, status, lang_pref) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'],
            $data['status'],
            $data['lang_pref']
        ]);
    }

    public function update($id, $data)
    {
        $query = "UPDATE users SET name = ?, username = ?, email = ?, role = ?, status = ?, lang_pref = ?";
        $params = [$data['name'], $data['username'], $data['email'], $data['role'], $data['status'], $data['lang_pref']];

        if (!empty($data['password'])) {
            $query .= ", password = ?";
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $query .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
}
