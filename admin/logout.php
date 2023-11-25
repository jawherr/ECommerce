<?php
 require_once $_SERVER['DOCUMENT_ROOT'].'/PhpProject1/ECommerce/core/init.php';
 unset($_SESSION['SBUser']);
 header('Location: login.php');
 ?>