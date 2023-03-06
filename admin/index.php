<?php
require_once '../include/init.php';

if(!isAuthUserAdmin()){
    header('location:../index.php');
    exit();
}

?>
<?php require_once 'common/head.php'; ?>
<h1 class="text-center">DASHBOARD</h1>

<?php require_once 'common/foot.php'; ?>


