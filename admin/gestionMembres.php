<?php require_once '../include/init.php';
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    if (!isAuthUserAdmin()) {
        header('location:../index.php');
        exit();
    }
    $showTable = '';
    $reqMembres = $pdo->query("SELECT * FROM membre");
    if($reqMembres->rowCount() > 0){
        $showTable .= '<table class="table table-bordered"><thead><tr>';
        for($i = 0; $i < $reqMembres->columnCount(); $i++){
            $colonne = $reqMembres -> getColumnMeta($i);
            $showTable .= "<th>". $colonne['name'] . "</th>";
        }
        $showTable .= "<th>Actions</th>";
        $showTable .= "</tr></thead><tbody>";
        while($membre = $reqMembres->fetch(PDO::FETCH_ASSOC)){
            $showTable .= "<tr>";
            foreach($membre as $key => $value){
                if(strlen($value) > 15){
                    $value = substr($value,0,15) . '...';
                }else{
                    $value = substr($value,0,19);
                }
                $showTable .= "<td>$value</td>";
            }
            $showTable .= '<td>
                                <a href="gestionMembres.php?action=update&id=' . $membre['id'] . '" class="btn btn-secondary m-1">
                                <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>';
        }
        $showTable .= "</tbody></table>";
    }else{
        $showTable .= '<div class="alert alert-danger">Aucun membre enregistré.</div>';
    }
    // Modifier un membre
    if (isset($_GET['action']) && $_GET['action'] == 'update') {
        $reqMembres = $pdo->prepare("SELECT * FROM membre WHERE id = :id");
        $reqMembres->bindValue(':id', $_GET['id'], PDO::PARAM_STR);

        if ($reqMembres->execute()) {
            $membreModif = $reqMembres->fetch(PDO::FETCH_ASSOC);
        }
    }
    // Afficher les commandes
    if (isset($_GET['action']) && $_GET['action'] == 'show') {
        $reqMembres = $pdo->prepare("SELECT * FROM commande WHERE id_membre = :id");
        $reqMembres->bindValue(':id', $_GET['id'], PDO::PARAM_STR);

        if ($reqMembres->execute()) {
            $membreModif = $reqMembres->fetch(PDO::FETCH_ASSOC);
        }
    }
    $id_membre = (isset($membreModif['id_membre'])) ? $membreModif['id_membre'] : '';
    $membre = (isset($membreModif['id'])) ? $membreModif['id'] : '';
    $statut = (isset($membreModif['statut'])) ? $membreModif['statut'] : '';
    $id_commande = (isset($membreModif['id_commande'])) ? $membreModif['id_commande'] : '';

?>
<?php require_once 'common/head.php'; ?>
    <div class="container">
        <?= $showTable ?>
        <div class="row">
            <div class="col-8 m-auto">
                <?php if(isset($_GET['action']) && $_GET['action']=="update"){
                    $stmt = $pdo->prepare("UPDATE membre SET statut = :statut WHERE id = :id");
                    $stmt->bindParam(':statut', $_POST['statut']);
                    $stmt->bindParam(':id', $_POST['id']);
                    $stmt->execute();
                ?>
                    <h4 class="text-center text-uppercase">Modification du membre: <span class="text-info"><?= $membre ?></span> </h4>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 m-auto">
                <?= $validation ?>
                <section class="shadow-lg p-5">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $membreModif['id'] ?>">
                    <input type="hidden" name="id_membre" value="<?= $id_membre ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-select" name='statut'>
                                <option value='0' <?php if ($statut == "0") echo 'selected' ?>>membre</option>
                                <option value='1' <?php if ($statut == "1") echo 'selected' ?>>administrateur</option>
                            </select>
                        </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <?php if (isset($_GET['action']) && $_GET['action'] == 'update'){ ?>
                            <input type="submit" class="btn btn-warning" value="Modifier">
                        <?php } ?>
                    </div>
                    </div>
                </form>
                </section>
            </div>
        </div>
    </div>
<?php require_once 'common/foot.php'; ?>