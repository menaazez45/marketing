<?php


class Database{
    //properties
    public $tableName;
    public $conn;
public $dbname;




    //Methods

    public function __construct($tName , $bd_name)

    {
        $this -> tableName =$tName;
        $this-> dbname =$bd_name;
        $this -> connect();
    }
    public function connect(){
        $this -> conn = new mysqli("localhost" , "root" , "" ,$this->dbname);
    }
    
        public function select($con,$val){
$select = "SELECT * from ($this ->tableName)";
$result = $this->conn ->quer($select);
// print_r($result->fetch_assoc())
while ($admin = $result -> fetch_assoc()){
    print_r($admin);
}


        }
        public function delet($col,$val ){
$delet = "DELETE FROM $this->tableName WHERE $col = $val";
$this-> conn ->quer($delet);
        }

        public function insert($arr) {
            $arr_keys = array_keys($arr);
            $keys = implode(",",$arr_keys);
            $arr_values = array_values($arr);
            $values = "'" . implode("','",$arr_values)."'";
            
           $insert = "INSERT INTO $this->tableName($keys) Values($values)";
           $this->conn -> query($insert);
        }
        public function update($arr , $col , $val){
            $array1=array_keys($arr);
            $array2=array_values($arr);

            $sel=[];

            for($i=0;$i<count($array1);$i++){
                $sel[$i] = $array1[$i]."="."'".$array2[$i]."'";
            }
                $arr_after=implode(",",$sel);
                $update = "UPDATE $this-> tableName SET $arr_after WHERE $col = $val";
                $this->conn->query($update);
            }

        }
    


        
    //endclass
/////
    $admins = new Database("admins" , "dom_project");
    echo"<pre>";
    $admins-> selectAll();
    $admins-> select("id" , "3");
    $admins->delete("id" , "3");
    $admins -> insert([
            "username" => "islam",
            "password" => "123456789",
            "phone" => "012457863",
            "email" => "islam@i.com",
            "gender" => "1",
            "pr" => "2"
    ]);
$admins -> update([
    "username" => "mena",
    "password" => "123",
    "phone" => "01280188930",
    "email" => "menaazez@gmail.com",
   "gender" =>"1",
   "pr" =>2
], "id" , "4");


?>