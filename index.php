<?php
include('controllers/ReservarController.php');
include('config/app.php');
include('includes/header.php');
include('includes/navbar.php');
include('controllers/VooController.php')

?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php include('message.php')?>
                
                <?php
                $reservas = new ReservarController;
                $FulltotalRevenue = $reservas->getFullTotalRevenue();
                ?>
                <div class="card mx-auto" style="width: 18rem;">
                    <img src="https://i.pinimg.com/736x/a2/b6/25/a2b625b8e391f7cd85c83f4f0ea3d548.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">TOTAL DE ARRECADADO: R$ <?=$FulltotalRevenue?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>Lista de Vôos</h4>
          </div>
          <div class="card-body">
<div class="table-responsive">
                 <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID:</th>
                                <th>Origem:</th>
                                <th>Destino:</th>
                                <th>Assentos disponíveis:</th>
                                <th>Valor da passagem:</th>
                                <th>Deletar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $vooController = new VooController;
                            $voos = $vooController->index(); // Assuming you have an index method in your VooController

                            if ($voos) {
                                foreach ($voos as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['idVoo'] ?></td>
                                        <td><?= $row['Origem'] ?></td>
                                        <td><?= $row['Destino'] ?></td>
                                        <td><?= $row['AssentosDisponiveis'] ?></td>
                                        <td><?= $row['ValorPassagem'] ?></td>
                                        <td>
                                            <form action="codes/voo_code.php" method="POST">
                                                <button type="submit" name="deletarVoo" value="<?= $row['idVoo'] ?>" class="btn btn-danger">Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                echo '<tr><td colspan="6">No flights available.</td></tr>';
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