<?php

class Connection {

    private $databaseFile;
    private $connection;

    public function __construct()
    {
        $this->databaseFile = realpath(__DIR__ . "/database/db.sqlite");
        $this->connect();
    }

    private function connect()
    {
        return $this->connection = new PDO("sqlite:{$this->databaseFile}");
    }

    public function getConnection()
    {
        return $this->connection ?: $this->connection = $this->connect();
    }

    public function query($query, $parms=null)
    {
        if(!$parms){
            $result = $this->getConnection()->query($query);
        }else{
            $result = $this->getConnection()->prepare($query);
            $result->execute($parms);
        }

        $result->setFetchMode(PDO::FETCH_INTO, new stdClass);

        return $result;
    }

    /*Função para dar pegar o primeiro já que current, first e pop não funcionaram*/
    public function getFirst($results)
    {
        $obj=null;
        foreach($results as $objT){
            $obj=$objT;
        }
        return $obj;
    }

}