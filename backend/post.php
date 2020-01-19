<?php
/* БЭКЕНД КОММЕНТАРИЕВ */
require ("../classes/database.php");
require_once "../lib/func.php";

  $data = $_POST;

  $username = htmlspecialchars($data['username']);
  $comment = htmlentities(htmlspecialchars($data['comment']));
  $user_id = $_SESSION['user_logs']['id'];
  $MyComDel = $_GET['MyComDel'];
  $Datetime = date('d:m:Y');
  $error = false;

if(isset($data['do_submit'])) {

    if(trim($comment) == "") {

      $_SESSION['komments_error'] = 'Введите сообщение..';

      $error = true;
    }

    if(strlen($comment) < 3 || strlen($comment) > 100) {

      $_SESSION['komments_error'] = 'Ваше сообщение не должно быть менее 3 символов и более 100!';

      $error = true;
    }

    if(checkBan($pdo, $_SESSION['user_logs']['id'], 1)) {

      $_SESSION['komments_error'] = 'Вы заблокированы! Причина: '.$checkBan['cause'].'';

      $error = true;
    }

    header('Location: /');
}

if(empty( $error )) {

    $sql = "INSERT INTO `comments` (user_id, comment, time) VALUES (:user_id, :comment, :time)";
    $params  = [':user_id' => $user_id, ':comment' => $comment, ':time' => $Datetime ];
    $sql_komm = $pdo->prepare($sql);
    $sql_komm->execute($params);

  $_SESSION['komments_error'] = 'Ваш комментарий успешно добавлен!';

    $error = true;
    header('Location: /');

}

?>
