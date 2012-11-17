<?php
$mod = isset($_GET["mod"]) ? $_GET["mod"] : "index";


include 'modules/' . $mod . '.php';
?>
