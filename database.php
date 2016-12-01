<?php
  //Query From databas function
    
class Database{
  
  // private instant variables
  var $dbConnectionID;
  var $record;
  var $host;
  var $database;
  var $user;
  var $password;
  var $res;
  /* 
    constructor
    connect to datbase server and select specified database
  */
  function Database($host="localhost", $db="exitetogo", $user="exitetogo", $pwd="@exitetogo@"){
       
    $this->host = $host;
    // Check if the server runs locally, so it sets the default database name.
    if($_SERVER['SERVER_NAME'] == "localhost")
      $this->database = "eldad-exitetogo-com";
    else
      $this->database = str_ireplace(".","-",$_SERVER['SERVER_NAME']);
    $this->user = $user;
    $this->password = $pwd;
    

  }
  
  
  /*
    private method
    used internally to generate dbConnectionID
  */
  function connect(){
    $this->dbConnectionID = @mysqli_connect($this->host, $this->user, $this->password,$this->database);
    if(!$this->dbConnectionID){
      echo(mysqli_connect_errno());
      exit;
    }
    else{

      $status = @mysqli_select_db($this->dbConnectionID,$this->database);
      if (!$status) {
        $this->database="www-".$this->database;
        $status = @mysqli_select_db($this->dbConnectionID,$this->database);
      }
      if(!$status){
        echo(mysqli_connect_errno());
        exit;
      }
    } 
  }
  
  
  //  public methods
  
  function query($sql){
    // connect to db incase connection id is not set
    if(empty($this->dbConnectionID))
      $this->connect();
      

    @mysqli_query($this->dbConnectionID,"SET NAMES UTF8");
    $this->res = @mysqli_query($this->dbConnectionID,$sql);
    
    // handle error
    if(!$this->res){
      echo(mysqli_connect_errno());
      exit;
    }
  }  
  
  function nextRecord(){
    $this->record = @mysqli_fetch_array($this->res);
    $status = is_array($this->record);
    return($status);
  }
  
  function numRows(){
    $rows = @mysqli_num_rows($this->res);
    return($rows);
  }
  
  // get record field value from the current record pointed by $record
  function getField($field) {
    //$fieldname=mysqli_fetch_field_direct($this->queryID,$index);
    return($this->record[$field]);
  }

  function numFields() {
      $numfields=mysqli_num_fields($this->res);
      return($numfields);
  }
  function getFieldName($index) {
      $fieldname=mysqli_fetch_field_direct($this->res,$index);
      return($fieldname->name);
  }
}
include_once('Predis/Autoloader.php');
Predis\Autoloader::register();
$m = new Predis\Client();
?>
