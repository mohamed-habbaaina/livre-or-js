<?php
session_start();
require_once './class/User.php';
$user = new User();

if (isset($_POST['username'])):

    $login = $user->isValid($_POST['username']);
    $password = $user->isValid($_POST['password']);


        if (isset($login) && isset($password)):



                if($user->connection($login, $password)):
                
                
                    // Création des variables global de session
                    $_SESSION['login'] = $login;
                    $_SESSION['id'] = $user->getId($login);

                    //  change status HTTP de 200 a 201
                    header("HTTP/1.1 201 you are connected");
                
                    // redirection vers la page 
                    header('location: commentaires.php');

                else:
                    $err_pw_bd = 'Login ou Password incorrecte !';
                endif;

            else:
                $err_comp = 'Veiller remplir tous les champs !';
        endif;
endif;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/connection.css">
    <script src="./js/app.js" defer></script>
    <script src="./js/appConnect.js" defer></script>
    <title>Connexion</title>
</head>
<body>
<?php include 'includes/header.php' ?>
<main>
    <div class="form">

    <!-- l'affichage des erreurs -->
        <p class="errs"><?php
        if (isset($err_c)){
            echo $err_c;
        }
        if (isset($err_comp)){
            echo $err_comp;
        }
        if (isset($err_pw_bd)){
            echo $err_pw_bd;
        }
        ?></p>
        <form action="#" method="post" id="formConnect">
            <h1>Connexion</h1>

            <label for="username">Login</label>
            <input type="text" name="username" placeholder="<?php if (isset($login)) {
                echo $login;
            } else {
                echo 'login';} ?>">
            <small></small>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Entre Votre Password">
            <small></small>

            <button type="submit">Valider</button>
        </form>

    </div>
</main>
<?php include 'includes/footer.php' ?>
</body>
</html>