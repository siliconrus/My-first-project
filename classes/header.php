<?php
require_once "database.php";
require_once ($_SERVER['DOCUMENT_ROOT'].'/lib/func.php');
?>
<!DOCTYPE>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        nav-links {
            padding: .5rem 1rem;
            padding-left: .5rem;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?
                $id = $_SESSION['user_logs']['id'];

                if(isset($_SESSION['user_logs'])) :

                    $sql = "SELECT * FROM users WHERE id = :id";
                    $params = [':id' => $id];
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);

                    $userss = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($userss) {

                      $_SESSION['user_logs'] = $userss;

                      $_SESSION['admin'] = $userss;
                    }

                    if(checkBan($pdo, $_SESSION['user_logs']['id'], 2)) {

                      unset($_SESSION['user_logs']);
                      unset($_SESSION['admin']);
                    }
                  echo getIp();
                   ?>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                            <b class="nav-links"><? siteTime(); ?>, <a class="nav-links" href="profile.php"><?=$_SESSION['user_logs']['login'];?></a></b>
                            </li>
                            <? if (($_SESSION['admin']['is_admin']) == 1) : ?><li class="nav-item">
                                &nbsp; | <a class="nav-links" href="/admin.php">Админ-панель</a>
                            </li><? endif;?>
                            <li class="nav-item">
                                &nbsp; | <a class="nav-links" href="backend/logout.php">Выйти</a>
                            </li>
                    </ul>
                    <? else : ?>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Авторизоваться</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Зарегистрироваться</a>
                            </li>
                    </ul>
                <? endif; ?>
                </div>
            </div>
        </nav>
