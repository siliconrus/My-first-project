<?php
/* БЭКЕНД АДМИН ПАНЕЛИ */
require_once '../classes/database.php';

$data = $_GET;

$id = $data['delete'];
$valueOne = $data['valueOne'];
$valueTwo = $data['valueTwo'];
$MyComDel = $data['MyComDel'];
$ChatBan  = $data['ChatBan'];
$CheckBan = $data['ChatBan'];

$DelChatBan = $data['DelChatBan'];
$type = $data['type'];

/* Удаление */
if(isset($data['delete'])) {

  $sql = 'DELETE FROM comments WHERE id = :id';
  $params = [':id'=>$id];
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);

  header('Location: /admin.php');

}
/* Разрешить комментарии */
if(isset($data['valueOne'])) {

  $sql = "UPDATE comments SET value = 0 WHERE id = :id";
  $params = [':id' =>$valueOne];
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);

  header('Location: /admin.php');

}
/* Запретить комментарии */
if(isset($data['valueTwo'])) {

  $sql = "UPDATE comments SET value = 1 WHERE id = :id";
  $params = [':id' =>$valueTwo];
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);

  header('Location: /admin.php');

}

/* Удаление комментария пользователем */
if(isset($_GET['MyComDel'])) {

  $sql = 'DELETE FROM comments WHERE id = :id';
  $params = [':id'=>$MyComDel];
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);

  header('Location: /');

}

/* Разбан в чате */
if(isset($data['DelChatBan'])) {

  $sql = 'DELETE  FROM ban_list WHERE id = :id';
  $params = [':id' => $DelChatBan];
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);

  header('Location: /admin.php?action=bans');
}
/* Бан в чате */

/* Чекаем бан лист */
$sql = 'SELECT * FROM ban_list WHERE user_id = :id AND type = :type';
$params = [':id' => $ChatBan, ':type' => $type];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$check_banList = $stmt->fetch(PDO::FETCH_ASSOC);

if($check_banList > 0) {

  $_SESSION['admin_succ'] = 'Already banned!';

  header('Location: /admin.php?action=users');

} else {

  /* Записываем юзера в бан-лист */
  $sql_c = 'INSERT INTO ban_list (user_id, cause, type) VALUES (:user_id, :cause, :type)';
  $params = [':user_id' => $ChatBan, ':cause' => 'Вас забанил анти-чит', ':type' => $type ];
  $stmt = $pdo->prepare($sql_c);
  $stmt->execute($params);

  header('Location: /admin.php?action=users');

  $_SESSION['admin_succ'] = 'Success!';

}
