<?PHP
session_start();
require_once './class/User.php';
$user = new User();

//  Verify that the user is logged in, otherwise redirection to 'home'.

if(!$user->isConnected()):
    
    header("location: index.php");

else:
    $login = $_SESSION['login'];
    $id = $_SESSION['id'];
endif;

if (isset($_POST['submit'])){


    if(isset($_POST['comment'])):


        // secur input
        $comment = $user->securComment($_POST['comment']);

        // valid comment
        if($user->validComment($comment)):

            // inser comment in DB.
            $user->inserComment($comment, $id);

            $mess_inser = 'Votre message est bien enregistré <a href="livre-or.php">"Livre d\'Or"</a> !';

        else:
            $err_comm = 'Votre commentaire est trop court -Minimum 6 caractère !';
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
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/commentair.css">
    <script src="./app.js" defer></script>
    <script src="./js/appComment.js" defer></script>
    <title>Commentaires</title>
</head>
<body>
<?php require 'includes/header.php'; ?>
    <main>
        <div class="bienv">
            <h3><?php echo "Bienvenue $login";?></h3>
            <p class="mess_inser">
                <?php
                if (isset($mess_inser)){
                echo $mess_inser;
                }
                if (isset($err_comm)){
                echo $err_comm;
                }
                ?>
            </p>
            <form action="#" method="post" class="form_comme" id="formComment">

            <label for="comment">Laisser Un Commentaire !</label>
            <input type="textarea" name="comment" placeholder="Poster Votre Commentaire Ici">
            <small></small>
            <input type="submit" name="submit" id="btn_c_v" value="Envoyer">

            </form>
        </div>
    </main>
    <?php require 'includes/footer.php'; ?>
</body>
</html>
