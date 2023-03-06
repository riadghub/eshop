<?php
require_once '../include/init.php';

if (!isAuthUserAdmin()) {
    header('location:../index.php');
    exit();
}

$showTable = '';

if ($_POST) {
    if(isset($_GET['action']) && $_GET['action']=="update"){
        $imgBdd = $_POST['nouvelle_photo'];
    }

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(addslashes($value));
    }

    // Vérifier si la référence existe déjà
    $verifRef = $pdo->prepare("SELECT * FROM produit WHERE reference = :reference");
    $verifRef->bindValue(':reference', $_POST['reference'], PDO::PARAM_STR);
    $verifRef->execute();


    // Vérifier si tous les champs sont remplis

    if (empty($_POST['reference']) || empty($_POST['titre']) || empty($_POST['public']) || empty($_POST['stock']) || empty($_POST['categorie']) || empty($_POST['couleur']) || empty($_POST['taille']) || empty($_POST['prix']) || empty($_POST['description'])) {
        $erreur .= '<div class="alert alert-danger">Veuillez remplir tous les champs</div>';
    }

    // Vérifier la taille du fichier image et son extension

    if (!empty($_FILES['photo'])) { // Si le fichier existe
        $imgName = $_FILES['photo']['name']; // On récupère le nom de l'image
        $imgName = "Produit_" . time() . "_" . $imgName; // On modifie le nom de l'image
        $extension = pathinfo($imgName, PATHINFO_EXTENSION); // On récupère l'extension de l'image


        $imgBdd = URL . "public/images/$imgName"; // On crée le chemin de l'image pour la BDD


        $imgServer = RACINE_SITE . "public/images/$imgName"; // On crée le chemin de l'image pour le serveur

        if ($_FILES['photo']['size'] > 4000000) { // Si la taille de l'image est supérieure à 4Mo
            $erreur .= '<div class="alert alert-danger">Taille de l\'image trop grande</div>';
        }
        $extension = strtolower($extension); // On met l'extension en minuscule
        $tabExt = ['jpg', 'jpeg', 'png']; // On crée un tableau avec les extensions autorisées



        if(isset($_GET['action']) && $_GET['action']=="update"){
            if(!empty($_FILES['photo']['name'])){

                copy($_FILES['photo']['tmp_name'], $imgServer);
                $pdo->query("UPDATE produit
                SET reference = '$_POST[reference]',
                categorie = '$_POST[categorie]',
                titre = '$_POST[titre]',
                description = '$_POST[description]',
                couleur = '$_POST[couleur]',
                taille = '$_POST[taille]',
                public = '$_POST[public]',
                photo = '$imgBdd',
                prix = '$_POST[prix]',
                stock = '$_POST[stock]'
                WHERE id_produit = '$_POST[id_produit]'");
            }else{
                $imgBdd = $_POST['nouvelle_photo'];
                $pdo->query("UPDATE produit
                SET reference = '$_POST[reference]',
                categorie = '$_POST[categorie]',
                titre = '$_POST[titre]',
                description = '$_POST[description]',
                couleur = '$_POST[couleur]',
                taille = '$_POST[taille]',
                public = '$_POST[public]',
                photo = '$imgBdd',
                prix = '$_POST[prix]',
                stock = '$_POST[stock]'
                WHERE id_produit = '$_POST[id_produit]'");
            }

        } else{
            if (!in_array($extension, $tabExt)) { // Si l'extension n'est pas dans le tableau
                $erreur .= '<div class="alert alert-danger">Extension de l\'image non autorisée</div>';
            }

            if (empty($erreur)) { // Si il n'y a pas d'erreur
                if ($verifRef->rowCount() > 0) {
                    $erreur .= '<div class="alert alert-danger">Référence indisponible</div>';
                }

                $reqProduit = $pdo->prepare("INSERT INTO `produit`(`reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES (:reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)");
    
                $reqProduit->bindValue(':reference', $_POST['reference'], PDO::PARAM_STR);
                $reqProduit->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
                $reqProduit->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $reqProduit->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $reqProduit->bindValue(':couleur', $_POST['couleur'], PDO::PARAM_STR);
                $reqProduit->bindValue(':taille', $_POST['taille'], PDO::PARAM_STR);
                $reqProduit->bindValue(':public', $_POST['public'], PDO::PARAM_STR);
                $reqProduit->bindValue(':photo', $imgBdd, PDO::PARAM_STR);
                $reqProduit->bindValue(':prix', $_POST['prix'], PDO::PARAM_STR);
                $reqProduit->bindValue(':stock', $_POST['stock'], PDO::PARAM_STR);
    
                if ($reqProduit->execute()) {
                    copy($_FILES['photo']['tmp_name'], $imgServer); // On copie l'image dans le dossier images
                    $validation .= '<div class="alert alert-success">Produit ajouté</div>';
                }
            }
        }


    }



    $validation .= $erreur;
}

// Récupérer tous les produits de la BDD
$reqProduit = $pdo->query("SELECT * FROM produit");


if ($reqProduit->rowCount() > 0) {

    $showTable .= '<table class="table table-striped table-hover"><thead><tr>';
    for ($i = 0; $i < $reqProduit->columnCount(); $i++) {
        $colonne = $reqProduit->getColumnMeta($i);
        $showTable .= '<th>' . $colonne['name'] . '</th>';
    }
    $showTable .= '<th>Actions</th>';
    $showTable .= '</tr>';

    while ($produits = $reqProduit->fetch(PDO::FETCH_ASSOC)) {
        $showTable .= '<tr>';

        foreach ($produits as $key => $value) {
            if ($key == 'photo') {
                $showTable .= '<td><img src="' . $value . '" width="100" height="100"></td>';
            } else {
                if(strlen($value) > 150){
                    $value = substr($value, 0, 150) . '...';
                }
                $showTable .= '<td>' . $value . '</td>';
            }
        }
        $showTable .= '<td>
                        <a href="gestionProduits.php?action=update&id_produit=' . $produits['id_produit'] . '" class="btn btn-secondary m-1">
                        <i class="bi bi-pencil-square"></i>
                        </a>
                        
                        <a href="gestionProduits.php?action=delete&id_produit=' . $produits['id_produit'] . '" class="btn btn-danger m-1">
                        <i class="bi bi-trash"></i>
                        </a>
                    </td>';
        $showTable .= '</tr>';
    }

    $showTable .= '</table>';
}

// Supprimer un produit
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $delAction = $pdo->prepare("DELETE FROM produit WHERE id_produit = :id_produit");
    $delAction->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_INT);
    if ($delAction->execute()) {
        header('location:gestionProduits.php');
    } else {
        $validation .= '<div class="alert alert-danger">Erreur lors de la suppression</div>';
    }
}



// Modifier un produit

if (isset($_GET['action']) && $_GET['action'] == 'update') {
    $reqProduit = $pdo->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
    $reqProduit->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_STR);

    if ($reqProduit->execute()) {
        $produitModif = $reqProduit->fetch(PDO::FETCH_ASSOC);
    }
}

$id_produit = (isset($produitModif['id_produit'])) ? $produitModif['id_produit'] : '';
$reference = (isset($produitModif['reference'])) ? $produitModif['reference'] : '';
$categorie = (isset($produitModif['categorie'])) ? $produitModif['categorie'] : '';
$titre = (isset($produitModif['titre'])) ? $produitModif['titre'] : '';
$description = (isset($produitModif['description'])) ? $produitModif['description'] : '';
$couleur = (isset($produitModif['couleur'])) ? $produitModif['couleur'] : '';
$taille = (isset($produitModif['taille'])) ? $produitModif['taille'] : '';
$public = (isset($produitModif['public'])) ? $produitModif['public'] : '';
$photo = (isset($produitModif['photo'])) ? $produitModif['photo'] : '';
$prix = (isset($produitModif['prix'])) ? $produitModif['prix'] : '';
$stock = (isset($produitModif['stock'])) ? $produitModif['stock'] : '';






?>


<!-- PARTIE AFFICHAGE -->
<?php require_once 'common/head.php'; ?>
<div class="container">
    <?= $showTable ?>
    <div class="row">
        <div class="col-8 m-auto">
            <?php if (isset($_GET['action']) && $_GET['action'] == 'update') : ?>
                <h4 class="text-center text-uppercase">Modification du produit: <span class="text-info"><?= $titre ?></span> </h4>
            <?php else : ?>
                <h1 class="text-center text-uppercase">Ajoutez un produit</h1>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">


        <div class="col-md-8 m-auto">
            <?= $validation ?>
            <section class="shadow-lg p-5">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_produit" value="<?= $id_produit ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Réf du produit" name="reference" value="<?= $reference ?>">
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="titre du produit" name="titre" value="<?= $titre ?>">
                            </div>
                            <select class="form-select" name='public'>
                                <option value="m" <?php if ($public == "m") echo 'selected' ?>>Homme</option>
                                <option value="f" <?php if ($public == "f") echo 'selected' ?>>Femme</option>
                                <option value="mixte" <?php if ($public == "mixte") echo 'selected' ?>>Mixte</option>
                                <option value="enfant" <?php if ($public == "enfant") echo 'selected' ?>>Enfant</option>
                            </select>
                            <div class="input-group mb-3 mt-3">
                                <input type="text" class="form-control" placeholder="Stock du produit" name="stock" value="<?= $stock ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Catégorie du produit" name="categorie" value="<?= $categorie ?>">
                            </div>
                            <select class="form-select" name='couleur'>
                                <option <?php if ($couleur == "Rouge") echo 'selected' ?>>Rouge</option>
                                <option <?php if ($couleur == "Noir") echo 'selected' ?>>Noir</option>
                                <option <?php if ($couleur == "Vert") echo 'selected' ?>>Vert</option>
                                <option <?php if ($couleur == "Blanc") echo 'selected' ?>>Blanc</option>
                                <option <?php if ($couleur == "Violet") echo 'selected' ?>>Violet</option>
                                <option <?php if ($couleur == "Multicolore") echo 'selected' ?>>Multicolore</option>
                                <option <?php if ($couleur == "Autre") echo 'selected' ?>>Autre</option>
                            </select>
                            <div class="input-group mb-3 mt-2">
                                <select class="form-select" name='taille'>
                                    <option <?php if ($taille == "XS") echo 'selected' ?>>XS</option>
                                    <option <?php if ($taille == "M") echo 'selected' ?>>M</option>
                                    <option <?php if ($taille == "L") echo 'selected' ?>>L</option>
                                    <option <?php if ($taille == "XL") echo 'selected' ?>>XL</option>
                                    <option <?php if ($taille == "XXL") echo 'selected' ?>>XXL</option>
                                    <option <?php if ($taille == "Autre") echo 'selected' ?>>Autre</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Prix du produit" name="prix" value="<?= $prix ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-floating">
                            <textarea class="form-control mt-2" id="floatingTextarea" name="description"><?= $description ?></textarea>
                            <label for="floatingTextarea">Détails</label>
                        </div>
                        <div class="input-group mb-3 mt-3">
                            <input type="file" class="form-control" placeholder="Photo du produit" name="photo" value="<?= $photo ?>">
                        </div>
                        <?php if (!empty($photo)) : ?>
                            <p>
                                <img src="<?= $photo ?>" alt="photo du produit" width="100">
                            </p>
                        <?php endif; ?>

                        <input type="hidden" name="nouvelle_photo" value="<?= $photo ?>">
                    </div>

                    <div class="d-grid gap-2 col-6 mx-auto">
                        <?php if (isset($_GET['action']) && $_GET['action'] == 'update') : ?>
                            <input type="submit" class="btn btn-warning" value="Modifier">
                        <?php else : ?>
                            <input type="submit" class="btn btn-primary" value="Ajouter">
                        <?php endif; ?>
                    </div>


                </form>
            </section>
        </div>



    </div>
</div>
<?php require_once 'common/foot.php'; ?>