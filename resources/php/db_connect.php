<?php


class DB_CONNECT {

    
    function __construct() {
       
        $this->connect();
    }

    
    function __destruct() {
        
        $this->close();
    }

   
    function connect() {
   
        require_once __DIR__ . '/db_config.php';

        
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());

        // Selecing database
        $db = mysql_select_db(DB_DATABASE) or die(mysql_error()) or die(mysql_error());

        
        return $con;
    }

    
    function close() {
        // closing db connection
        mysql_close();
    }

}

?>