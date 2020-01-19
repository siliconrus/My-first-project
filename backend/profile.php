<?php
/* БЭКЕНД ФОРМЫ ПРОФИЛЯ */
ob_start();
require '../classes/database.php';

$data = $_POST;

$error = false;
$error_pwd = false;

$id = $_SESSION['user_logs']['id'];
$login = htmlentities($data['login']);
$email = htmlentities($data['email']);
$password = htmlspecialchars($data['password']);
$current = htmlentities($data['current']);
$img = $data['avatars'];

if(isset($_SESSION['user_logs'])) {

if(isset($data['profile_red'])) {

  if(trim($login) == '') {

    $_SESSION['profile_login'] = 'Введите логин';

    $error = true;

  }

  if(strlen($login) < 6 || strlen($login) > 32 ) {

    $_SESSION['profile_login'] = 'Логин должен быть не менее 6 и не более 32 символов.';

    $error = true;
  }

  $check_login = "SELECT login FROM users WHERE login = :login";
  $params = [':login' => $login];
  $chstmt = $pdo->prepare($check_login);
  $chstmt->execute($params);
  $check_logins = $chstmt->fetch(PDO::FETCH_ASSOC);

  if($check_logins && ($login !== $_SESSION['user_logs']['login'])) {

    $_SESSION['profile_login'] = 'Такой логин уже существует в базе данных!';

    $error = true;
  }

  if(trim($email) =='') {

      $_SESSION['profile_email'] = 'Введите email';

      $error = true;
  }

  if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) { //Проверяем валидатность самого емейла

    $_SESSION['profile_email'] = 'Некорректный Email!';

    $error = true;

  }

    $check_email = "SELECT email FROM users WHERE email = :email";
    $params = [':email' => $email];
    $stmt = $pdo->prepare($check_email);
    $stmt->execute($params);

    $check_emails = $stmt->fetch(PDO::FETCH_ASSOC);

    if($check_emails && ($email !== $_SESSION['user_logs']['email'])) {

      $_SESSION['profile_email'] = 'Такой email уже существует в базе!';

      $error = true;

    }

 if(empty($error)) {

  $sql = $pdo->prepare("UPDATE users SET login = ?,  email = ? WHERE id = ?")->execute([$login, $email ,$id]);

  $_SESSION['profile_success'] = 'Ваш запрос успешно обработан!';

}

  }

  header('Location: /profile.php');

/* БОЛЬШОЙ БЛОК ЗАГРУЗКИ И ВЫВОДА АВТАТАРОВ ПОЛЬЗОВАТЕЛЯ!! */

if(!empty($_FILES['img'])) {

  $error_img = false;
  $extensions = ['jpg', 'png', 'jpeg'];

  $check_photo = 'SELECT avatars FROM users WHERE id = :id';
  $params = [':id' => $id];
  $stmt = $pdo->prepare($check_photo);
  $stmt->execute($params);

  $check_photo = $stmt->fetch(PDO::FETCH_ASSOC);

  if($_FILES['img']['size'] > 1024 * 3 * 1024)  {

    $_SESSION['profile_img'] = 'Размер файла не должен превышать более 3 мб.';

    $error = true;

  }

  if($_FILES['img']['error'] > 0) {

    $_SESSION['profile_img'] = 'Что-то пошло не так..';

    $error = true;

  }

    switch ($_FILES['img']['type']) {
      case 'image/png': $format = 'png';
        break;

      case 'image/jpeg' : $format = 'jpeg';
        break;

      case 'image/jpg' : $format = 'jpg';
        break;

      default: $format = '';
        break;
    }

    if(!in_array($format, $extensions)) {

      $_SESSION['profile_img'] = 'Ваше фото не соответствует форматам: ' . implode(',', $extensions);

      $error = true;

    }

  if($format) {

    $filepath = '../img/users/';
    $ImgName = uniqid() . '.' . basename($_FILES['img']['type']);
    $UploadImg = $filepath . $ImgName;

  if($_SESSION['user_logs']['avatars'] != '') {

    unlink($_SESSION['user_logs']['avatars']);

if(empty($error)) {

  move_uploaded_file($_FILES['img']['tmp_name'], $UploadImg);

  $sql = $pdo->prepare("UPDATE users SET avatars = ? WHERE id = ?")->execute([$UploadImg, $id]);

  $_SESSION['profile_success'] = 'Ваш запрос успешно обработан!';

      }

    }

  }

header('Location: /profile.php');

}
/* БЛОК БЕЗОПАСНОСТИ */

/* Валидация паролей */
if(isset($data['password_r'])) {

if(trim($password) == '') {

  $_SESSION['profile_pwd'] = 'Введите пароль!';

  $error_pwd = true;
}

if($data['password_confirmation'] != $password ) {

  $_SESSION['profile_pwd_conf'] = 'Второй пароль введен неверно!';

  $error_pwd = true;

}
if(strlen($password) < 6) {

  $_SESSION['profile_pwd'] = 'Минимальная длина пароля 6 символов.';
  $error_pwd = true;
}

$sql = "SELECT password FROM users WHERE id = :id";
$params = [':id' => $id];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$pwd_check = $stmt->fetch(PDO::FETCH_ASSOC);
$pass = $pwd_check['password'];

$curr = password_verify($current, $pass);

if($curr == $pwd_check) {

if(empty($error_pwd)) {

  $pwd = password_hash($password, PASSWORD_DEFAULT);

  $sql = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$pwd, $id]);

  $_SESSION['profile_success_sec'] = 'Ваш запрос успешно обработан!';

 unset($_SESSION['user_logs']);

}
    } else $_SESSION['profile_pwd_t'] = 'Неверно введен текущий пароль!';

 header('Location: /profile.php');

  }

}

?>
