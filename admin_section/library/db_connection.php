<?php

class dbConnect {
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '';
    private $db_name = 'library_system';
    public $conn;
    
    function __construct() {
        $this->conn = $this->db_connect();
    }
    
    function db_connect() {
        $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        
        if( $conn->connect_error ) {
            die( 'Could Not Connect to Database: ' . $conn->connect_error );
        }
        
        return $conn;
    }
    
    function query_exe($query='') {
        $sql = $this->conn->query( $query );
        return $sql;
    }
}