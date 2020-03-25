<?php
class DB
{
    const DB_HOST = 'localhost';
    const DB_NAME = 'quiz_online_cms';
    const DB_PASS = 'koodinh';
    const DB_USERNAME = 'root';
    private $db = null;
    public function __construct()
    {
        //Ket noi CSDL
        $this->db = new mysqli(self::DB_HOST, self::DB_USERNAME, self::DB_PASS, self::DB_NAME);
    }

    public function getDB()
    {
        return $this->db;
    }

    public function disconnect()
    {
        $this->db = null;
    }
}