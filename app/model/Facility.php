<?php
class Facility
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getFacilityByPublicity($isGeneral)
    {
        $q = 'SELECT * FROM facility WHERE isGeneral = ?';
        $this->db->query($q);
        $this->db->bind(1, $isGeneral);
        $res = $this->db->resultSet();
        return $res;
    }

    public function getFacilityById($id)
    {
        $q = 'SELECT * FROM facility WHERE id = ?';
        $this->db->query($q);
        $this->db->bind(1, $id);
        $res = $this->db->resultSet();
        return $res;
    }

    public function getFacilityByRoomId($id)
    {
        $q = 'SELECT * FROM facilityonroom WHERE roomId = ?';
        $this->db->query($q);
        $this->db->bind(1, $id);
        $res = $this->db->resultSet();
        return $res;
    }
}