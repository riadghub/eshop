<?php
require_once 'include/init.php'; // Connexion à la base de données

// Vérifier si l'id est bien présent dans l'URL.Sinon, on redirige vers la boutique
if(!isset($_GET['id_produit'])){
    header('location:boutique.php');
    exit();    
}

// récupérer les données de l'article en BDD grâce à l'id
if(isset($_GET['id_produit'])){
    $req = $pdo->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
    $req->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_INT);
    $req->execute();
    $produit = $req->fetch(PDO::FETCH_ASSOC);
}

if($req->rowCount() <= 0){
    header('location:boutique.php');
    exit();
}

// Afficher les données de l'article dans la page


?>


<?php require_once 'common/header.php'; ?>

<h1 class="text-center fst-italic h1 text-uppercase">Fiche produit</h1>

<div class="container">
    <div class="row">
        <div class="col-8 m-auto">
            <div class="card mb-3">
                <img src="<?= $produit['photo'] ?>" class="card-img-top" alt="..." style="height: 400px; width: 320px;margin-left:30%;">
                <div class="card-body">
                    <h5 class="card-title"><?= $produit['titre'] ?></h5>
                    <p class="card-text"><?= $produit['description'] ?></p>
                    <p class="card-text"><small class="text-muted">Catégorie : <?= $produit['categorie'] ?></small></p>
                    <p class="card-text"><small class="text-muted">Couleur : <?= $produit['couleur'] ?></small><p>
                    <p class="card-text"><small class="text-muted">Taille :<?= $produit['taille'] ?></small></p>
                    <p class="card-text"><small class="text-muted">Public : <?= $produit['public'] ?></small></p>
                    <p class="card-text"><small class="fw-bold h5"><?= $produit['prix'] ?> €</small></p>
                    <?php if($produit['stock'] > 0): ?>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="id_produit" value="<?= $produit['id_produit'] ?>">
                        <input type="hidden" name="prix" value="<?= $produit['prix'] ?>">
                        <label for="">Quantité</label>
                        <select class="form-select mb-3" name="quantite">
                            <?php for($i = 1; $i <= $produit['stock']; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <input type="submit" value="ajouter au panier" class="btn btn-primary" name="cart">
                    </form>
                    <?php else: ?>
                        <p class="text-danger">Rupture de stock</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once 'common/footer.php'; ?>