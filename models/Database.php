<?php

class DBAbstract
{
    protected $db;

    function __construct()
    {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->db->connect_error) {
            die('Error de conexión: ' . $this->db->connect_error);
        }

        // Asegurar codificación correcta
        if ($this->db) {
            $this->db->set_charset('utf8mb4');
        }
    }

    /* solo funciona para hacer select a futuro lo haremos para todas las dml: SELECT, INSERT, UPDATE, DELETE */
    public function consultar($sql){
        $response = $this->db->query($sql);
        return $response->fetch_all(MYSQLI_ASSOC);
    }

    public function ejecutar($sql) {
        return $this->db->query($sql);
    }
}
?>