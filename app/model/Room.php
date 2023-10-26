<?php
class Room{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getRoom()
    {
        $q = 'SELECT * FROM room';
        $this->db->query($q);
        $res = $this->db->resultSet();
        return $res;
    }

    public function getRoomById($id)
    {
        $q = 'SELECT * FROM room WHERE id = ?';
        $this->db->query($q);
        $this->db->bind(1, $id);
        $res = $this->db->resultSet();
        return $res;
    }
}