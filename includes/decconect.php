<?php
session_start();
require_once("./../class/User.php");

$user = new User();

$user->deconnect();

header("location:../index.php"); // redirige l'utilisateur