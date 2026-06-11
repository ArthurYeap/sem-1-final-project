<?php
if(isset($_SESSION['role'])){
    if($_SESSION['role'] !== "admin"){
        header("Location:main.php"); exit();
    }}
?>