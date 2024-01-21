<?php

class ReservarController {
    public $conn;

    public function __construct() {
        $db = DatabaseConnection::getInstance();
        $this->conn = $db->conn;
    }

    public function create($inputData) {
      $data = "'" . implode("','", $inputData) . "'";
      $flightId = $inputData['Voo_idVoo'];
  
  
      $reserva_query = "INSERT INTO Reserva (Voo_idVoo, nome_cliente, assento_reservado) VALUES ($data)";
      $result = $this->conn->query($reserva_query);
  
      if ($result) {
         
          $discount = $this->calculateDiscount($flightId);
          $valorPassagem = $this->getValorPassagem($flightId); 
          $finalValue = $valorPassagem * (1 - $discount);
  
         
          $updateQuery = "UPDATE Reserva SET desconto = $discount, valorFinal = $finalValue WHERE idReserva = LAST_INSERT_ID()";
          $this->conn->query($updateQuery);
  
          return true;
      } else {
          return false;
      }
  }
  
  public function getValorPassagem($flightId) {
    $query = "SELECT ValorPassagem FROM Voo WHERE idVoo = $flightId";
    $result = $this->conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['ValorPassagem'];
    } else {
        return 0; 
    }
}

    public function index() {
        $reserva_query = "SELECT * FROM Reserva";
        $result = $this->conn->query($reserva_query);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function delete($id) {
        $reserva_id = validateInput($this->conn, $id);
        $reservaDeleteQuery = "DELETE FROM Reserva WHERE idReserva='$reserva_id' LIMIT 1";
        $result = $this->conn->query($reservaDeleteQuery);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function cancelReservation($reservationId) {
       
        $flightIdQuery = "SELECT Voo_idVoo FROM Reserva WHERE idReserva = $reservationId";
        $result = $this->conn->query($flightIdQuery);
        $row = $result->fetch_assoc();
        $flightId = $row['Voo_idVoo'];

        
        $deleteQuery = "DELETE FROM Reserva WHERE idReserva = $reservationId";
        $this->conn->query($deleteQuery);

      
        $this->updateDiscount($flightId);
    }
    
    

    public function updateDiscount($flightId) {
        $discount = $this->calculateDiscount($flightId);

        $updateQuery = "UPDATE Reserva SET desconto = $discount WHERE idReserva = LAST_INSERT_ID()";
        $this->conn->query($updateQuery);
    }

    public function calculateDiscount($flightId) {
      
        $countQuery = "SELECT COUNT(*) AS num_reservations FROM Reserva WHERE Voo_idVoo = $flightId";
        $result = $this->conn->query($countQuery);
        $row = $result->fetch_assoc();
        $numReservations = $row['num_reservations'];

        //Coloquei números menores para testar melhor as porcentagens.
        if ($numReservations == 1) {
            return 0.25; 
        } elseif ($numReservations == 2) {
            return 0.15; 
        } elseif ($numReservations == 3) {
            return 0.05; 
        } else {
            return 0; 
        }
    }

    public function findById($id) {
        $id = validateInput($this->conn, $id);
        $query = "SELECT * FROM Reserva WHERE idReserva = $id";
        $result = $this->conn->query($query);
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    

    public function countReservationsWithDiscount($flightId, $discount) {
        $countQuery = "SELECT COUNT(*) AS num_reservations FROM Reserva WHERE Voo_idVoo = $flightId AND desconto = $discount";
        $result = $this->conn->query($countQuery);
        $row = $result->fetch_assoc();
        return $row['num_reservations'];
    }
    
    public function getTotalRevenue($flightId) {
        $query = "SELECT SUM(valorFinal) AS totalRevenue FROM Reserva WHERE Voo_idVoo = $flightId";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['totalRevenue'];
        } else {
            return 0; 
        }
    }

    public function getTotalSeats($flightId) {
        $query = "SELECT AssentosDisponiveis FROM Voo WHERE idVoo = $flightId";
        $result = $this->conn->query($query);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['AssentosDisponiveis'];
        } else {
            return 0; 
        }
    }

    
    
   public function getReservedSeats($flightId) {
    $query = "SELECT COUNT(DISTINCT assento_reservado) AS num_reserved_seats FROM Reserva WHERE Voo_idVoo = $flightId";
    $result = $this->conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['num_reserved_seats'];
    } else {
        return 0;
    }
}

    public function calculateAvailableSeats($flightId) {
        $totalSeats = $this->getTotalSeats($flightId);
        $reservedSeats = $this->getReservedSeats($flightId);
        $availableSeats = $totalSeats - $reservedSeats;
    
        return $availableSeats;
    }


    public function getFullTotalRevenue() {
        $query = "SELECT SUM(valorFinal) AS fullTotalRevenue FROM Reserva";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['fullTotalRevenue'];
        } else {
            return 0; 
        }
    }

    public static function checkFlightExists($id) {
        $db = DatabaseConnection::getInstance();
        $conn = $db->conn;
    
        $id = validateInput($conn, $id);
        $query = "SELECT * FROM Voo WHERE idVoo = $id";
        $result = $conn->query($query);
    
        return ($result->num_rows > 0);
    }
    
    
}
?>
