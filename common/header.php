<?php require_once 'include/init.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>rShop</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">rShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="boutique.php">Boutique</a>
                    </li>

                    <?php if (isAuthUser()) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="profil.php"><?php echo($_SESSION['user']['pseudo']);?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="connexion.php?action=logout">Déconnexion</a>
                        </li>

                    <?php else : ?>

                        <li class="nav-item">
                            <a class="nav-link" href="inscription.php">Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="connexion.php" id='login'>Connexion</a>
                        </li>
                        </li>

                    <?php endif; ?>

                    <?php if (isAuthUserAdmin()) : ?>

                        <li class="nav-item">
                            <a class="nav-link" href="admin/gestionProduits.php">Administration</a>
                        </li>
                    <?php endif; ?>

                    </li>
                    <?php if (isAuthUser()) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Panier
                            <?php if (isset($_SESSION['panier'])) : ?>
                                <span class="badge bg-danger"><?= count($_SESSION['panier']['id_produit']) ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger">0</span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>