<?php
require_once("./../class/User.php");

$user = new User();

// Retrieve the data from the comments table and the login that posted the comment
$data = $user->livrOr();

echo(json_encode($data));