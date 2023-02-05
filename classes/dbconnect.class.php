<?php

class DatabaseConnection
{
    public $conn;
    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'stanje');

        if($this->conn->connect_error)
        {
            die ("<h1>Veza sa bazom podataka nije uspela</h1>");
        }
    }
}

