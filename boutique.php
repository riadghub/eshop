<!-- PARTIE TRAITEMENT -->
<?php
require_once 'include/init.php';

// Récupération des catégories sans doublons
$requestCategories = "SELECT DISTINCT categorie FROM produit";

$resultCategories = $pdo->query($requestCategories);

if(isset($_GET['categorie'])){
    $reqCat = $pdo->prepare("SELECT * FROM produit WHERE categorie = :categorie");
    $reqCat->bindValue(':categorie', $_GET['categorie'], PDO::PARAM_STR);
}else{
    $reqCat = $pdo->prepare("SELECT * FROM produit");
}
    $reqCat->execute();

?>





<!--PARTIE AFFICHAGE-->

<?php require_once 'common/header.php'; ?>

<h1 class="text-center fst-italic h1 text-uppercase">boutique</h1>

<div class="container">
    <div class="row">
        <div class="col-3 shadow-lg border">
            <h5>Les Catégories</h5>
            <ul>    
                <li>
                    <a href="boutique.php">TOUT AFFICHER</a>
                </li>
                <?php while($categorie = $resultCategories->fetch(PDO::FETCH_ASSOC)): ?>
                <li>
                    <a href="boutique.php?categorie=<?= $categorie['categorie'] ?>"><?= $categorie['categorie'] ?></a>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="col-9">
            <h5>Les Produits</h5>
            <?php if(isset($reqCat)) : ?>
                <?php while($produits = $reqCat->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?=$produits['photo'] ?>" class="img-fluid rounded-start" alt="<?=$produits['titre'] ?>" style="height:200px">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?=$produits['titre'] ?></h5>
                            <p class="card-text"><?= substr($produits['description'],0, 250)?></p>
                            <p class="card-text"><small class="fw-bold text-success px-5"><?=$produits['prix'] ?> €</small>
                            <a href="fiche.php?id_produit=<?=$produits['id_produit'] ?>" class="btn btn-dark">Voir le produit</a>
                            </p> 
                        </div>
                    </div>
                </div>
            </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'common/footer.php'; ?>