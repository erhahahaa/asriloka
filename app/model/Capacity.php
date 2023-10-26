<?php
class Capacity
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getCapacityById($id)
    {
        $q = 'SELECT * FROM capacity WHERE id = ?';
        $this->db->query($q);
        $this->db->bind(1, $id);
        $res = $this->db->resultSet();
        return $res;
    }

    public function getCapacityByRoomId($id)
    {
        $q = 'SELECT * FROM capacityonroom WHERE roomId = ?';
        $this->db->query($q);
        $this->db->bind(1, $id);
        $res = $this->db->resultSet();
        return $res;

    }
}