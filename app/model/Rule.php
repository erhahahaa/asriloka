<?php
class Rule
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getRuleByPublicity($isGeneral)
    {
        $q = 'SELECT * FROM rule';
        $this->db->query($q);
        $res = $this->db->resultSet();

        if (count($res) > 0) {
            return $res;
        } else {
            $dummy = [
                "id" => 0,
                "name" => "No Rule Setted",
                "description" => "No Rule Setted",
                "created_at" => "No Rule Setted",
                "updated_at" => "No Rule Setted"
            ];
            return [$dummy];
        }

    }

    public function getRuleById($id)
    {
        $q = 'SELECT * FROM rule WHERE id = ?';
        $this->db->query($q);
        $this->db->bind(1, $id);
        $res = $this->db->resultSet();
        return $res;
    }

    public function getRuleByRoomId($id)
    {
        $q = 'SELECT * FROM ruleonroom WHERE roomId = ?';
        $this->db->query($q);
        $this->db->bind(1, $id);
        $res = $this->db->resultSet();
        return $res;

    }
}