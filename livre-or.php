<?php
session_start();
require_once './class/User.php';
$user = new User();

// $user->livrOr();

if($user->isConnected()):
    
    $login = $_SESSION['login'];
    $id = $_SESSION['id'];
endif;



if (isset($_POST['comment'])){

    // secur input
    $comment = $user->securComment($_POST['comment']);

    // valid comment
    if($user->validComment($comment)):

        // inser comment in DB.
        $user->inserComment($comment, $id);
    
    else:
        $err_comm = 'Votre commentaire est trop court -Minimum 8 caractère !';
        
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
    <link rel="stylesheet" href="style/livreor.css">
    <script src="./js/app.js" defer></script>
    <script src="./js/appLivreOr.js" defer></script>

    <title>Le Livre d'Or</title>
</head>
<body>
    <?php require 'includes/header.php'; ?>
<main>
    <div class="livre_or">
         <h1>Le livre d'Or</h1>
          <table>    <!--  Display table  -->
            <thead>
                <th>Posté le</th>
                <th>Par l'Utilisateur</th>
                <th id="com">Commentaire</th>
            </thead>

            <tbody>

            <!-- Create tbody with Fetch Api -->

            </tbody>
         </table>
    </div>

    <?php
    if($user->isConnected()):
    ?>
    
    <div class="commen_or">
        <p class="mess_inser">
            <?php
            
            if (isset($err_comm)) {
                echo $err_comm;
            }?>
        </p>
                
        <form action="#" method="post" id="formlivre">
    
                
            <label for="commentaire">Laisser Un Commentaire !</label>
            <input type="textarea" name="comment" placeholder="Poster Votre Commentaire Ici">
            <small></small>
            <button  id="btn_com">Envoyer</button>
        </form>
    </div>

        <?php endif;?>

</main>
<?php include 'includes/footer.php' ?>
</body>
</html>