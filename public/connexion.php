<?php

use App\config\Connect;

require_once (__DIR__ . '/../include.php');

    if (!empty($_POST) && !empty($_POST['username'] && !empty($_POST['password'])))
    {
        $pdo = Connect::getPDO();
        $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR mail = :username) AND confirmed_at IS NOT NULL');
        $req->execute(['username' => $_POST['username']]);
        $user = $req->fetch();
        if (password_verify($_POST['password'], $user->password))
        {
            session_start();
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = 'Vous êtes connecté !';
            header('Location: /public/account.php');
            exit();
        }
        else{
            $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorecte';
        }
    }

?>
<h1>Connexion</h1>
<form action="" method="POST">

    <label for="username-id">Votre pseudo</label>
    <p><input type="text" name="username" id="username-id"></p>

    <label for="pass-id">Votre Mot de passe</label>
    <p><input type="password" name="password" id="pass-id"></p>

    <p><input type="submit" value="connexion"></p>
</form>
