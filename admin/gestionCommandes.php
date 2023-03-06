<?php require_once '../include/init.php';
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    if (!isAuthUserAdmin()) {
        header('location:../index.php');
        exit();
    }
    $showTable = '';
    if($_POST){
        if(isset($_GET['action']) && $_GET['action']=="update"){
            $pdo->query("UPDATE commande SET etat = '$_POST[etat]' WHERE id = $_POST[id]");
        }
    }
    $reqCommandes = $pdo->query("SELECT * FROM commande");

    if ($reqCommandes->rowCount() > 0) {
        $showTable .= '<table class="table table-striped table-hover"><thead><tr>';
        for ($i = 0; $i < $reqCommandes->columnCount(); $i++) {
            $colonne = $reqCommandes->getColumnMeta($i);
            $showTable .= '<th>' . $colonne['name'] . '</th>';
        }
        $showTable .= '<th>Actions</th>';
        $showTable .= '</tr>';
        while ($commandes = $reqCommandes->fetch(PDO::FETCH_ASSOC)) {
            $showTable .= '<tr>';

            foreach ($commandes as $key => $value) {
                if ($key == 'photo') {
                    $showTable .= '<td><img src="' . $value . '" width="100" height="100"></td>';
                } else {
                    $value = substr($value, 0, 150);

                    $showTable .= '<td>' . $value . '</td>';
                }
            }
            if($commandes['etat'] != "livré"){
                $showTable .= '<td>
                                <a href="gestionCommandes.php?action=update&id=' . $commandes['id'] . '" class="btn btn-secondary m-1">
                                <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>';
                $showTable .= '</tr>';
            }
        }
        $showTable .= '</table>';
    }
    // Modifier une commande
    if (isset($_GET['action']) && $_GET['action'] == 'update') {
        $reqCommandes = $pdo->prepare("SELECT * FROM commande WHERE id = :id");
        $reqCommandes->bindValue(':id', $_GET['id'], PDO::PARAM_STR);

        if ($reqCommandes->execute()) {
            $commandeModif = $reqCommandes->fetch(PDO::FETCH_ASSOC);
        }
    }
    $id_commande = (isset($commandeModif['id_commande'])) ? $commandeModif['id_commande'] : '';
    $statut = (isset($commandeModif['statut'])) ? $commandeModif['statut'] : '';
    $titre = (isset($commandeModif['id'])) ? $commandeModif['id'] : '';
    ?>
    <!-- PARTIE AFFICHAGE -->
    <?php require_once 'common/head.php'; ?>
    <div class="container">
        <?= $showTable ?>
        <div class="row">
            <div class="col-8 m-auto">
                <?php if(isset($_GET['action']) && $_GET['action']=="update"){
                    $stmt = $pdo->prepare("UPDATE commande SET etat = :etat WHERE id = :id");
                    $stmt->bindParam(':etat', $_POST['etat']);
                    $stmt->bindParam(':id', $_POST['id']);
                    $stmt->execute();
                ?>
                    <h4 class="text-center text-uppercase">Modification de la commande: <span class="text-info"><?= $titre ?></span> </h4>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 m-auto">
                <?= $validation ?>
                <section class="shadow-lg p-5">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $commandeModif['id'] ?>">
                    <input type="hidden" name="id_commande" value="<?= $id_commande ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-select" name='etat'>
                                <option value="en cours" <?php if ($statut == "en cours") echo 'selected' ?>>en cours</option>
                                <option value="validé" <?php if ($statut == "validé") echo 'selected' ?>>validé</option>
                                <option value="expédié" <?php if ($statut == "expédié") echo 'selected' ?>>expédié</option>
                                <option value="livré" <?php if ($statut == "livré") echo 'selected' ?>>livré</option>
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