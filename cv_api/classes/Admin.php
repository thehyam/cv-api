<?php

class Admin {
    // DB stuff
    private $conn;


    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    public function get_admin_details(array $data) {
        $sql = "SELECT * FROM admins WHERE uname = ? AND pword = ?";
        $query = $this->conn->prepare($sql);
        $query->execute($data);
        if ($row = $query->fetch(PDO::FETCH_ASSOC)){
            return $row;
        }
    }

    public function get_admin_by_token(array $data) {
        $sql = "SELECT * FROM admins WHERE token = ?";
        $query = $this->conn->prepare($sql);
        $query->execute($data);
        if ($row = $query->fetch(PDO::FETCH_ASSOC)){
            return $row;
        }
    }

    // Update record
    public function update_admin_token(array $data) {
        $sql = "UPDATE admins 
        SET
            token =?,
            last_login = ?
        WHERE
            id = ?";

        $query = $this->conn->prepare($sql);
        // Execute
        $row = $query->execute($data);
        //checking result 
        if($query->rowCount() > 0){
            return true;
         
        }
    }



    function md5_encrypt($dt)
    {
        return md5($dt);
    }

    function gen_token()
    {
        return $this->md5_encrypt(rand(1,1000));
    }

    function comparing_two_date_time($dt1, $dt2)
    {   
        
        $dt_1 = new DateTime($dt1);
        $dt_2 = new DateTime($dt2);

        $dt_1->modify('+1 hour');//add 1 hour

        //comparing two datetime
        $com_dt = $dt_2->diff($dt_1);
        $passx = $com_dt->invert;// for tracking time passed 
        $pass = false;
      
        //first comparism
        if ( $passx > 0 ) {
            $pass = true;
        }else{
            
        }
        
        if ($pass ) {
            return $pass;
        }

        
    }





}