<?php

class Web {
    // DB stuff
    private $conn;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all record
    public function get_all() {
        $sql = "SELECT * FROM websites";
        $query = $this->conn->prepare($sql);
        $query->execute(array());

        if($query->rowCount() > 0){
            $results = array();
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $results[] =  $row;
            }
            return $results;

        }
    }


    // Get single record
    public function get_one(array $data) {
        $sql = "SELECT * FROM websites WHERE id = ?";
        $query = $this->conn->prepare($sql);
        $query->execute($data);
        if ($row = $query->fetch(PDO::FETCH_ASSOC)){
            return $row;
        }
    }


    // Create new record
    public function create(array $data) {        
        $sql = "INSERT INTO websites(website, url, description)
            VALUES(?, ?, ?)";
        $query = $this->conn->prepare($sql);
        // Execute
        $row = $query->execute($data);
        //checking result 
        if($query->rowCount() > 0){
            return true;
         
        }
        
    }

    // Update record
    public function update(array $data) {
        $sql = "UPDATE websites 
        SET
            website =?,
            url = ?,
            description = ?
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

    //Delete post
    public function delete(array $data) {
         
        $sql = "DELETE FROM websites WHERE id = ?";
        
        $query = $this->conn->prepare($sql);
        // Execute
        $row = $query->execute($data);
        //checking result 
        if($query->rowCount() > 0){
            return true;
         
        }
    }

    public function makeApiCall($url,$dt)
    {

        $options = ['http' => [
            'method' => 'POST',
            'header' => 'Content-type:application/json',
            'content' => $json_dt
        ]];
        
      

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response) {
            return $response;
        }
    }

}