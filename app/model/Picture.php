<?php
class Picture
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPictureById($id)
    {
        $q = 'SELECT * FROM picture WHERE id = ?';
        $this->db->query($q);
        $this->db->bind(1, $id);
        $res = $this->db->resultSet();
        return $res;
    }

    public function getPictureByRoomId($id)
    {
        $q = 'SELECT * FROM pictureonroom WHERE roomId = ?';
        $this->db->query($q);
        $this->db->bind(1, $id);
        $res = $this->db->resultSet();
        return $res;

    }
}