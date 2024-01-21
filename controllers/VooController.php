
<?php

class VooController{
  public $conn;
  public function __construct(){
    $db = DatabaseConnection::getInstance();
    $this->conn = $db->conn;
  }
  public function create($inputData){
    $data = "'". implode("','", $inputData) ."'";
    $register_query = "INSERT INTO Voo (Origem,Destino,AssentosDisponiveis,ValorPassagem) VALUES ($data)";
    $result = $this->conn->query($register_query);

    if($result){
      return true;
    }else{
      return false;
    }
  }
  public function index() {
    $voo_query = "SELECT * FROM Voo";
    $result = $this->conn->query($voo_query);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}
public function delete($id) {
  $voo_id = validateInput($this->conn, $id);
  $vooDeleteQuery = "DELETE FROM Voo WHERE idVoo ='$voo_id' LIMIT 1";
  $result = $this->conn->query($vooDeleteQuery);
  if ($result) {
      return true;
  } else {
      return false;
  }
}

  
}



?>
