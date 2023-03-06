<?php

// Pour voir si l'utilisateur est connecté
function isAuthUser()
{
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

// Pour voir si l'utilisateur est connecté et admin
function isAuthUserAdmin()
{
    if (isAuthUser() && $_SESSION['user']['statut'] == 1) {
        return true;
    } else {
        return false;
    }
}

// Créer une session panier vide dans une function

function init_panier()
{
    if (!isset($_SESSION['panier'])) {

        $_SESSION['panier'] = array();

        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}

// Fonction qui ajoute un produit dans le panier

function ajouter_panier($id_produit, $quantite, $prix)
{

    init_panier();

    $findProduct = array_search($id_produit, $_SESSION['panier']['id_produit']);

    if ($findProduct !== false) {

        $_SESSION['panier']['quantite'][$findProduct] += $quantite;
    } else {

        $_SESSION['panier']['id_produit'][] = $id_produit;
        $_SESSION['panier']['quantite'][] = $quantite;
        $_SESSION['panier']['prix'][] = $prix;
    }
}
function panierPrice()
{
    $total = 0;

    for ($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {

        $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
    }
    return $total;
}

// Fonction pour retirer un produit du panier
function removeProduct($id_produit){
    $findProduct = array_search($id_produit, $_SESSION['panier']['id_produit']);
    
    array_splice($_SESSION['panier']['id_produit'], $findProduct, 1); 
    array_splice($_SESSION['panier']['quantite'], $findProduct, 1);
    array_splice($_SESSION['panier']['prix'], $findProduct, 1);
}
?>
