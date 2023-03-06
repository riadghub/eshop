<!-- PARTIE TRAITEMENT -->

<?php
require_once 'include/init.php';

if(isset($_GET['action']) && $_GET['action'] == 'logout'){
    unset($_SESSION['user']);
    header('location:index.php');
    exit();
}


if($_POST){

    // SECURITE
    foreach($_POST as $key=>$val){
        $_POST[$key] = htmlspecialchars(addslashes(trim($val)));
    }

    // Vérification des champs du formulaire

    if(!empty($_POST['email']) && !empty($_POST['mdp'])){

        // Vérifier si le mail existe en BDD
        $checkEmail = $pdo->prepare("SELECT * FROM membre WHERE email = :email");
        $checkEmail->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $checkEmail->execute();

        if($checkEmail->rowCount() > 0){
            $user = $checkEmail->fetch(PDO::FETCH_ASSOC);

            // Vérifier le mot de passe

            if(password_verify($_POST['mdp'],$user['mdp'])){
                echo "ok welcome";
                // Si le mot de passe est bon, on connecte l'utilisateur
                $_SESSION['user']['pseudo'] = $user['pseudo'];
                $_SESSION['user']['id_membre'] = $user['id'];
                $_SESSION['user']['email'] = $user['email'];
                $_SESSION['user']['nom'] = $user['nom'];
                $_SESSION['user']['prenom'] = $user['prenom'];
                $_SESSION['user']['civilite'] = $user['civilite'];
                $_SESSION['user']['statut'] = $user['statut'];
                $_SESSION['user']['adresse'] = $user['adresse'];
                $_SESSION['user']['code_postal'] = $user['code_postal'];
                $_SESSION['user']['ville'] = $user['ville'];
                $_SESSION['user']['pays'] = $user['pays'];
                
                header('location:profil.php'); 


            }else{
                $validation .= '<div class="alert alert-danger">Email ou mot de passe incorrect</div>';
            }

        }else{
            $validation .= '<div class="alert alert-danger">Email ou mot de passe incorrect</div>';}

    }else{
        $validation .= '<div class="alert alert-danger">Veuillez remplir tous les champs</div>';
    }
}


?>





<!-- PARTIE AFFICHAGE -->

<?php require_once 'common/header.php'; ?>

<div class="container">
    <div class="row">
        <h1 class="text-center">Connexion</h1>
        <div class="col-6 m-auto">
            <?= $validation ?>
            <form action="" method="post">

                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Votre email" name="email">
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Votre mot de passe" name="mdp">
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <input type="submit" value="se connecter" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'common/footer.php'; ?>