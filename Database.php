

<?php
//This php file is used to connect the SINGCO codes to the database where password and username are needed. 
  class database{
      private static $dbName = 'singco';
      private static $dbHost = 'localhost';
      private static $dbUsername = 'root';
      private static $dbPassword = '';
      private static $cont = null;

      public function contruct(){
          die('Init function is not allowed');}

      public static function letsconnect (){
          if(null==self::$cont){
            try{
                self::$cont = new PDO("mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbPassword);}
            catch(PDOException $e){
                die($e->getMessage());}
           }
        return self::$cont;
     }

    function disconnect(){
        self::$cont = null;}
  }

?>
