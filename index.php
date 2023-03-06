<!----- TRAITEMENT ----->
<?php
require_once 'include/init.php';

$req = $pdo->query("SELECT * FROM produit");
$produit = $req->fetchAll(PDO::FETCH_ASSOC);

?>

<!----- AFFICHAGE ----->
<?php require_once 'common/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center fst-italic">Accueil</h1>
        </div>
    </div>
    <div class="row d-flex justify-content-evenly">

        <?php foreach ($produit as $key => $value) : ?>
            <div class="card shadow-lg m-2" style="width: 20rem;">
                <img src="<?= $produit[$key]['photo'] ?>" class="card-img-top" alt="<?= $produit[$key]['titre'] ?>" style="aspect-ratio:1.8/2; heigth='200px'">
                <div class="card-body">
                    <h5 class="card-title"><?= $produit[$key]['titre'] ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $produit[$key]['categorie'] ?></h6>
                    <p class="fw-bold text-success"><?= $produit[$key]['prix'] ?> €</p>
                    <a href="boutique.php" class="btn btn-primary"><i class="bi bi-eye"> </i>Voir ce produit</a>
                </div>
            </div>
        <?php endforeach; ?>





    </div>

</div>

<?php require_once 'common/footer.php'; ?>