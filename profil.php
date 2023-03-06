<?php
require_once 'include/init.php';

if(!isAuthUser()){
    header('location:connexion.php');
    exit();
}

if(isAuthUserAdmin()){
    $validation .= '<div class="alert alert-success">Vous êtes connecté en tant qu\'administrateur</div>';
}


?>

<!-- PARTIE AFFICHAGE -->

<?php require_once 'common/header.php'; ?>

<?= $validation ?>
<?php

echo 'Bonjour ' . $_SESSION['user']['pseudo'] . ' !<br>';
echo 'Votre email est ' . $_SESSION['user']['email'] . ' !<br>';
echo 'Votre nom est ' . $_SESSION['user']['nom'] . ' !<br>';
echo 'Votre prénom est ' . $_SESSION['user']['prenom'] . ' !<br>';
echo 'Votre civilité est ' . $_SESSION['user']['civilite'] . ' !<br>';
echo 'Votre adresse est ' . $_SESSION['user']['adresse'] . ' !<br>';
echo 'Votre code postal est ' . $_SESSION['user']['code_postal'] . ' !<br>';
echo 'Votre ville est ' . $_SESSION['user']['ville'] . ' !<br>';
echo 'Votre pays est ' . $_SESSION['user']['pays'] . ' !<br>';

?>

<?php require_once 'common/footer.php'; ?>