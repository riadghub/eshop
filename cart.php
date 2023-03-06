<?php
require_once 'include/init.php';

// Faire une requête pour récupérer les infos du produit en BDD grâce à l'id_produit qui est dans le formulaire en hidden

// Faire une fonction qui va créer session panier vide (function.php)

// faire une function qui ajoute un produit dans le panier (function.php)

// faire une function qui calcule le total du panier (function.php)

if (isset($_POST['cart'])) {
    ajouter_panier($_POST['id_produit'], $_POST['quantite'], $_POST['prix']);
}

if(isset($_POST['remove'])){
    removeProduct($_SESSION['panier']['id_produit'][$i]);
}

if (isset($_POST['valider'])) {

    for($i=0; $i<count($_SESSION['panier']['id_produit']); $i++){
        $reqStock = $pdo->query("SELECT stock FROM produit WHERE id_produit = " . $_SESSION['panier']['id_produit'][$i]);
        $stock = $reqStock->fetch(PDO::FETCH_ASSOC);
    

        if($stock['stock'] < $_SESSION['panier']['quantite'][$i]){
            
            if($stock['stock'] > 0){ // si le stock est supérieur à 0
    
                $_SESSION['panier']['quantite'][$i] = $stock['stock']; // on met la quantité du panier à la quantité du stock

                $validation .= "Le produit " . $_SESSION['panier']['id_produit'][$i] . " n'est plus disponible en quantité demandée, la quantité a été modifiée";

            }else{
                removeProduct($_SESSION['panier']['id_produit'][$i]); // on retire le produit du panier
                $validation .= "Le produit " . $_SESSION['panier']['id_produit'][$i] . " n'est plus disponible";

                $i--; // on décrémente i pour ne pas sauter un produit
                header('location:cart.php');
            }
            $flag = true;
        }



    }


    if(!isset($flag)){
        $id_user = $_SESSION['user']['id_membre'];
        $prix = panierPrice();
        $pdo->query("INSERT INTO `commande`( `id_membre`, `montant`, `etat`) VALUES ('  $id_user ' , '$prix' ,'en cours')");
        $id_commande = $pdo->lastInsertId();
        
        for($i=0; $i<count($_SESSION['panier']['id_produit']); $i++){
            $pdo->query("INSERT INTO `details_commande`(`id_commande`, `id_produit`, `quantite`, `prix`) VALUES (" . $id_commande . ", " . $_SESSION['panier']['id_produit'][$i] . ", " . $_SESSION['panier']['quantite'][$i] . ", " . $_SESSION['panier']['prix'][$i] . ")");

            // Mettre à jour le stock

            $pdo->query("UPDATE produit SET stock = stock - " . $_SESSION['panier']['quantite'][$i] . " WHERE id_produit = " . $_SESSION['panier']['id_produit'][$i]);

            $validation = "Votre commande a bien été enregistrée.";
        }
            // vider la session panier
            unset($_SESSION['panier']);
    }

}



?>


<?php require_once 'common/header.php'; ?>

<h1 class="text-center fst-italic h1 text-uppercase">Panier</h1>
<!-- Afficher le contenu du panier -->

<div class="container">
    <div class="row">
        <div class="col-10 m-auto">
            <?php if (!empty($validation)) : ?>
                <div class="alert alert-success"><?= $validation ?></div>
            <?php endif; ?>
            <table class="table table-striped shadow-lg">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Retirer</th>
                    </tr>
                </thead>
                <?php if (empty($_SESSION['panier']) || count($_SESSION['panier']['id_produit'])==0) : ?>
                    
                    <tr>
                        <td colspan="4" class="text-center">Votre panier est vide</td>
                    </tr>
                <?php else : ?>
                    <?php for ($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) : ?>
                        <tr>
                            <td><?= $_SESSION['panier']['id_produit'][$i] ?></td>
                            <td><?= $_SESSION['panier']['quantite'][$i] ?></td>
                            <td><?= $_SESSION['panier']['prix'][$i] ?></td>
                            <td>
                                <form action="" method="post" name="rmProduct">
                                    <input type="submit" name="remove" value="-" class="btn btn-primary">
                                </form>
                            </td>
                        </tr>
                    <?php endfor; ?>
                    <th colspan="4" class="text-end">
                        Montant total : <?= panierPrice() ?> €
                    </th>
                    <tr>
                        <td colspan="4" class="">
                            <a href="boutique.php" class="btn btn-primary">Continuer mes achats</a>

                            <?php if (isAuthUser()) : ?>
                                <form action="" method="post" name="checkForm">
                                    <input type="submit" name="valider" value="Valider ma commande" class="btn btn-success">
                                </form>

                            <?php else : ?>
                                <a href="connexion.php" class="">Connexion</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>



<?php require_once 'common/footer.php'; ?>