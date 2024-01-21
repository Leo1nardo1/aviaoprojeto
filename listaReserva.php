<?php
include('includes/footer.php');
?>
<?php
include('config/app.php');
include('includes/header.php');
include('includes/navbar.php');
include_once('controllers/ReservarController.php');
?>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <?php include('message.php') ?>
        <div class="card">
          <div class="card-header">
            <h4>Lista de Reservas</h4>
          </div>
          <div class="card-body">

            <form action="" method="POST" class="mb-3">
              <label for="searchId">Pesquisar reserva por ID:</label>
              <input type="text" name="searchId" id="searchId" class="form-control">
              <button type="submit" class="btn btn-primary mt-2">Pesquisar</button>
            </form>

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID:</th>
                    <th>Cod. Vôo:</th>
                    <th>Cliente:</th>
                    <th>Assento:</th>
                    <th>Valor do desconto:</th>
                    <th>Valor Final:</th>
                    <th>Deletar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  if (isset($_POST['searchId'])) {
                    $reservas = new ReservarController;
                    $searchId = $_POST['searchId'];
                    $result = $reservas->findById($searchId);

                    if ($result) {

                  ?>
                      <tr>
                        <td><?= $result['idReserva'] ?></td>
                        <td><?= $result['Voo_idVoo'] ?></td>
                        <td><?= $result['nome_cliente'] ?></td>
                        <td><?= $result['assento_reservado'] ?></td>
                        <td><?= $result['desconto'] ?></td>
                        <td><?= $result['valorFinal'] ?></td>
                        <td>
                          <form action="codes/reservar_code.php" method="POST">
                            <button type="submit" name="deletarReserva" value="<?= $result['idReserva'] ?>" class="btn btn-danger">Deletar</button>
                          </form>
                        </td>
                      </tr>
                      <?php
                    } else {
                      echo "Nenhum registro encontrado";
                    }
                  } else {

                    $reservas = new ReservarController;
                    $result = $reservas->index();
                    if ($result) {
                      foreach ($result as $row) {
                      ?>
                        <tr>
                          <td><?= $row['idReserva'] ?></td>
                          <td><?= $row['Voo_idVoo'] ?></td>
                          <td><?= $row['nome_cliente'] ?></td>
                          <td><?= $row['assento_reservado'] ?></td>
                          <td><?= $row['desconto'] ?></td>
                          <td><?= $row['valorFinal'] ?></td>
                          <td>
                            <form action="codes/reservar_code.php" method="POST">
                              <button type="submit" name="deletarReserva" value="<?= $row['idReserva'] ?>" class="btn btn-danger">Deletar</button>
                            </form>
                          </td>
                        </tr>
                  <?php
                      }
                    } else {
                      echo "Nenhum registro encontrado";
                    }
                  }

                  ?>

                </tbody>
              </table>
            </div>

            <div class="table-responsive">
              <form action="" method="POST" class="mb-3">
                <label for="pesquisarId">Pesquisar informações do vôo:</label>
                <input type="text" placeholder="Digite o código do vôo" name="pesquisarId" id="pesquisarId" class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Pesquisar</button>
              </form>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Reservas com 25%:</th>
                    <th>Reservas com 15%:</th>
                    <th>Reservas com 5%:</th>
                    <th>Reservas de valor integral:</th>
                    <th>Quantidade de Assentos reservados:</th>
                    <th>Valor total arrecadado no vôo:</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $reservas = new ReservarController;

                  if (isset($_POST['pesquisarId'])) {
                    $flightId = $_POST['pesquisarId'];


                    $discountCount = $reservas->countReservationsWithDiscount($flightId, 0);
                    $discount25Count = $reservas->countReservationsWithDiscount($flightId, 0.25);
                    $discount15Count = $reservas->countReservationsWithDiscount($flightId, 0.15);
                    $discount5Count = $reservas->countReservationsWithDiscount($flightId, 0.05);
                    $seatsAvailable = $reservas->getReservedSeats($flightId);
                    $totalRevenue = $reservas->getTotalRevenue($flightId);
                  ?>
                    <tr>
                      <td><?= $discount25Count ?></td>
                      <td><?= $discount15Count ?></td>
                      <td><?= $discount5Count ?></td>
                      <td><?= $discountCount ?></td>
                      <td><?=$seatsAvailable ?></td>
                      <td><?= $totalRevenue ?></td>
                    </tr>
                  <?php
                  } else {
                    echo "Nenhum registro encontrado";
                  }

                  ?>
                  
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include('includes/footer.php');
?>