
 <?php
 
 include('../config/app.php');
 include_once('../controllers/VooController.php');

  if(isset($_POST['cadastrar-btn'])){
    
    $inputData = [
      'Origem' => validateInput($db->conn,$_POST['origem']),
      'Destino' => validateInput($db->conn,$_POST['destino']),
      'AssentosDisponiveis' => validateInput($db->conn,$_POST['qtdeassentos']),
      'valorPassagem' => validateInput($db->conn,$_POST['valor']),
    ];

    $register = new VooController;
    $result = $register->create($inputData);
    
    if($result){
      redirect("Vôo adicionado com sucesso!","/index.php");
    }else{
      redirect("Vôo não foi adicionado","/index.php");
    }
  }

  if(isset($_POST['deletarVoo'])){
    $id = validateInput($db->conn,$_POST['deletarVoo']);
    $voo = new VooController;
    $result = $voo->delete($id);
    if($result){
      redirect("Voo deletado com sucesso!", "/index.php");
    }else{
        redirect("Voo não pôde ser deletado", "/index.php");
      }
  }
?>