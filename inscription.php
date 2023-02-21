<?php
session_start();
require_once './class/User.php';
$user = new User();

if (isset($_POST['username'])){

    // validation inputs.
    $login = $user->isValid($_POST['username']);
    $email = $user->isValid($_POST['email']);
    $password = $user->isValid($_POST['password']);
    $co_password = $user->isValid($_POST['co_password']);


    //  Verify that the user has completed the entire form.
    $err = [];
    if (empty($login)):
        $err[] = '<li> Veiller remplir le Login </li>';
    endif;

    if (empty($email)):
        $err[] = '<li>Veiller remplir votre Email</li>';
    endif;

    if (empty($password)):
        $err[] = '<li>Veiller remplir le Password</li>';
    endif;

    if (empty($co_password)):
        $err[] = '<li>Veiller confirmer le Password</li>';
    endif;

    // Verify that the user has entered the same password. 
    if ($password !== $co_password):
        $err[] = '<li>Veiller rentrer le meme password</li>';
    else: //  cryptage du password
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    endif;


    //  Verify that the user has completed the entire form.
    if ($email && $login && $password && $co_password):

        if(empty($user->check_DB($login))):

            $user->register($email, $login, $password);
            
            //  change status HTTP de 200 a 201
            header("HTTP/1.1 201 created account");

            //TODO redirection to connexion.php.
            // header("location:./connexion.php");

            $_SESSION['login'] = $login;

        else:
            $err[] = '<li>Le login n\'est pas disponible, Veuillez le changer !</li>';
        endif;
    endif;
    
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/connection.css">
    <script src="./app.js" defer></script>
    <title>Inscription</title>
</head>
<body>
<?php include 'includes/header.php' ?>
<main>
    <div class="form">

    <!-- error display -->
        <ul class="errs"><?php
                if (!empty($err)){
                    $i = 0;
                    while(isset($err[$i])):
                        echo $err[$i];
                        $i++;
                    endwhile;
                }
        ?></ul>
        <form action="#" method="post" id="formInscription">
            <h1>Inscription</h1>

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Entre Votre Email">
            <small></small>

            <label for="username">Login</label>
            <input type="text" name="username" placeholder="Entre Votre Login">
            <small></small>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Entre Votre Password">
            <small></small>

            <label for="co-password">Confirmer Password</label>
            <input type="password" name="co_password" placeholder="Confirmer Votre Password">
            <small></small>

            <button type="submit">Valider</button>
        </form>

    </div>
</main>
<?php include 'includes/footer.php' ?>
</body>
</html>