<!-- PARTIE TRAITEMENT -->
<?php
require_once 'include/init.php'; // Connexion à la base de données + fonctions utiles

// Traitement du formulaire
if ($_POST) {
    //var_dump($_POST);
    // htmlspecialchars() convertit les caractères spéciaux en entités HTML, addslashes() échappe les caractères spéciaux d'une chaîne pour l'utiliser dans une requête SQL, trim() supprime les espaces (ou d'autres caractères) en début et fin de chaîne

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(addslashes(trim($value)));
    }
    
    // Vérifier que le pseudo n'est pas déjà utilisé
    $req = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $req->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $req->execute();

    // rowCount() retourne le nombre de lignes affectées par la dernière requête DELETE, INSERT ou UPDATE exécutée par l'objet PDOStatement associé à l'objet PDO. Si aucune ligne n'a été affectée, rowCount() retourne 0.

    if($req->rowCount() > 0){
        $erreur .= '<div class="alert alert-danger">Pseudo indisponible</div>';
    }

    // Vérifier que le mail n'est pas déjà utilisé

    $res = $pdo->prepare("SELECT * FROM membre WHERE email = :email");
    $res->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $res->execute();

    if($res->rowCount() > 0){
        $erreur .= '<div class="alert alert-danger">Email indisponible</div>';
    }

    // vérifier la longueur du pseudo(entre 4 et 20 caractères)

    if(strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20){
        $erreur .= '<div class="alert alert-danger">Le pseudo doit contenir entre 4 et 20 caractères</div>';
    }

    // vérifier la longueur du nom(entre 2 et 20 caractères)
    if(strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20){
        $erreur .= '<div class="alert alert-danger">Le nom doit contenir entre 2 et 20 caractères</div>';
    }

    // vérifier la longueur du prénom(entre 2 et 50 caractères)
    if(strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 50){
        $erreur .= '<div class="alert alert-danger">Le prénom doit contenir entre 2 et 50 caractères</div>';
    }

    // Vérifier que le format de l'email est correct
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $erreur .= '<div class="alert alert-danger">Email invalide</div>';
    }

    // La longueur du code postal doit être de 5 caractères
    if(strlen($_POST['cp']) != 5){
        $erreur .= '<div class="alert alert-danger">Le code postal doit contenir 5 caractères</div>';
    }
    // vérifier la civilité
    if(!isset($_POST['civilite']) || ($_POST['civilite'] != 'm' && $_POST['civilite'] != 'f')){
        $erreur .= '<div class="alert alert-danger">Civilité invalide</div>';
    }


    if(empty($erreur)){
        // j'ajoute l'utilisateur en BDD
        $hash = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $insertUser = $pdo->prepare("INSERT INTO `membre`(`pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `adresse`, `code_postal`, `ville`, `pays`) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :adresse, :code_postal, :ville, :pays)");
        $insertUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $insertUser->bindValue(':mdp', $hash, PDO::PARAM_STR);
        $insertUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $insertUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $insertUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $insertUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
        $insertUser->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
        $insertUser->bindValue(':code_postal', $_POST['cp'], PDO::PARAM_STR);
        $insertUser->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
        $insertUser->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);

        if($insertUser->execute()){
            $validation .= '<div class="alert alert-success">Vous êtes inscrit</div>';
        }else{
            $validation .= '<div class="alert alert-danger">Erreur lors de l\'inscription</div>';
        }
    }

    $validation .= $erreur;

}


?>


<!-- PARTIE AFFICHAGE -->

<?php require_once 'common/header.php'; ?>

<div class="container">
    <div class="row">
        <h1 class="text-center">Inscription</h1>
        <div class="col-6 m-auto">
            <?= $validation ?>
            <form action="" method="post">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="civilite" id="inlineRadio1" value="m">
                    <label class="form-check-label" for="inlineRadio1">Mr</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="civilite" id="inlineRadio2" value="f">
                    <label class="form-check-label" for="inlineRadio2">Mme</label>
                </div>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Votre pseudo" name="pseudo">
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Votre nom" name="nom">
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Votre prenom" name="prenom">
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Votre email" name="email">
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Votre mot de passe" name="mdp">
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Votre adresse" name="adresse">
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Votre code postal" name="cp">
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Votre ville" name="ville">
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Votre pays" name="pays">
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <input type="submit" value="S'inscrire" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'common/footer.php'; ?>