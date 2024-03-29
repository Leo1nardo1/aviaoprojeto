<?php
 include('../config/app.php');
  include_once('../controllers/ReservarController.php');

  if (isset($_POST['reservar-btn'])) {
    $flightId = validateInput($db->conn, $_POST['idVoo-fk']);

   
    $flightExists = ReservarController::checkFlightExists($flightId);

    if (!$flightExists) {
        redirect("O vôo associado a reserva não existe.", "/index.php");
    } else {
        
        $inputData = [
            'Voo_idVoo' => $flightId,
            'nome_cliente' => validateInput($db->conn, $_POST['nomeCliente']),
            'numAssento' => validateInput($db->conn, $_POST['numAssento']),
        ];

        $reservar = new ReservarController;
        $result = $reservar->create($inputData);

        if ($result) {
            redirect("Reserva adicionada com sucesso!", "/index.php");
        } else {
            redirect("Reserva não pode ser adicionada", "/index.php");
        }
    }
}

  if(isset($_POST['deletarReserva'])){
    $id = validateInput($db->conn,$_POST['deletarReserva']);
    $reservar = new ReservarController;
    $result = $reservar->delete($id);
    if($result){
      redirect("Reserva deletada com sucesso!", "/listaReserva.php");
    }else{
        redirect("Reserva não pôde ser deletada", "/listaReserva.php");
      }
  }
  
?>