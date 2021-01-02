<?php
require "00DDBBVariables.php";

class queryToDDBB
{

    function __construct($stringQuery)
    {
        $this->stringQuery = $stringQuery;
    }
    function read()
    {
        $this->response = "failed";
        //Crear la lectura en base de datos
        global $servername, $dbname, $username, $password;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->query($this->stringQuery);
            $this->response = "null";
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                $this->response = $row[0];
            }
        } catch (PDOException $e) {
            $this->response = "failed: " . $this->stringQuery . $e->getMessage();
        }
        $conn = null;
        return $this->response;
    }
    function write()
    {
        $this->response = "failed";
        //Crear la escritura en base de datos
        global $servername, $dbname, $username, $password;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // use exec() because no results are returned
            $this->response = "failed: algo se rompió al ejecutar la escritura";
            $conn->exec($this->stringQuery);
            $this->response = "success";
        } catch (PDOException $e) {
            $this->response =  "failed:" . $this->stringQuery . "<br>" . $e->getMessage();
        }
        $conn = null;
        return $this->response;
    }
}