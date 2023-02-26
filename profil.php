<?php
session_start();
require_once './class/User.php';
$user = new User();

if(!$user->isConnected()):
    
    header("location: index.php");

else:
    $login = $_SESSION['login'];
endif;


if (isset($_POST['nw_login'])){


    if(isset($_POST['nw_login']) && isset($_POST['password']) && isset($_POST['con_password'])):

        $nwLogin = $user->isValid($_POST['nw_login']);
        $password = $user->isValid($_POST['password']);
        $con_password = $user->isValid($_POST['con_password']);

        if($password === $con_password):

                //hash password
                $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

            if(empty($user->check_DB($nwLogin)) || $login === $nwLogin):


                $user->update($nwLogin, $password, $login);
                $messUpdat = 'Vos modifications ont été enregistrées';

                //  change status HTTP de 200 a 201
                header("HTTP/1.1 201 created account");

            $_SESSION['login'] = $login;


            else: $err_logi = 'Le login n\'est pas disponible, Veuillez le changer !';
            endif;


        else: $err_pass = 'Veiller rentrer le meme password';

        endif;


    else: $err_don = 'Veiller remplir tous les champs !';
    endif;

}
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
    <script src="./js/appProfil.js" defer></script>

    <title>Profil</title>
</head>
<body>
<?php require 'includes/header.php'; ?>
<main>
    <div class="form">

        <p class="errs"><?php if (isset($err_don)){
            echo $err_don;
        }
        if (isset($err_pass)){
            echo $err_pass;
        }
        if (isset($err_logi)){
            echo $err_logi;
        }
        if(isset($messUpdat)){
            echo $messUpdat;
        }
        ?></p>
        <h3 style="margin-left: 30px;">Modifier Vos Informations:</h3>

        <form action="#" method="post" id="formProfil">

            <label for="nw_login">Login</label>
            <input type="text" name="nw_login" value="<?php echo $login ?>">
            <small></small>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Rentre Votre Password">
            <small></small>

            <label for="con_password">Confermer Votre Password</label>
            <input type="password" name="con_password" placeholder="Confermer Votre Password">
            <small></small>

            <button>Valider</button>

        </form>
    </div>
<?php require 'includes/footer.php'; ?>
</main>
</body>
</html>