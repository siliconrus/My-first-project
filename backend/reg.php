<?php
/* БЭКЕНД ФОРМЫ РЕГИСТРАЦИИ */

require ("../classes/database.php");
require_once "../lib/func.php";

$data = $_POST;

/* POST запросы */

$login = htmlspecialchars($data['login']); //Получаем логин
$email = htmlspecialchars($data['email']); //Получаем емейл
$password = htmlspecialchars($data['password']); //Получаем пароль
$date = date('Y.m.d-H:i:s'); //Получаем дату

$error = false;

$_SESSION['login'] = $login;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;


//$error = [];

if(strlen($login) < 5 or strlen($login) > 15) {
	//exit('Логин должен содержать не менее 5 и не более 15 символов!'); //Проверяем минимальную и максимальную длину логина
	$_SESSION['reg_session_login'] = 'Логин должен содержать не менее 5 и не более 15 символов!';

	$error = true;
}

if(strlen($password) < 3 or strlen($password) > 32) {
	$_SESSION['reg_session_password'] = 'Ваш пароль должен содержать не менее 3 и не более 32 символов'; //Проверяем минимальную и максимальную длину пароля

		$error = true;
}

if(isset($data['do_signup'])) { //Проверяем была ли нажата кнопка сабмит (зарегистрироваться)

	if(trim($login) == '') { //Проверяем на пустоту логин
		$_SESSION['reg_session_login'] = 'Введите логин!';

			$error = true;
	}

	if(trim($email) == '') { //Проверяем на пустоту емейл
		$_SESSION['reg_session_email']= 'Введите Email!';

			$error = true;

	}

	if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) { //Проверяем валидатность самого емейла

		$_SESSION['reg_session_email'] = 'Некорректный Email!';

			$error = true;
	}

	if($password == '') { //Проверяем на пустоту пароль

		$_SESSION['reg_session_password']  = 'Введите Пароль!';

			$error = true;
	}

	if($data['password_confirmation'] != $password) { //Проверяем на соответствие повторный пароль

		$_SESSION['reg_session_password'] = 'Второй пароль введен неверно!';

			$error = true;
	}

	header('Location: /register.php');
}

/* Проверка на дубляж логина */

$sql = "SELECT login FROM users WHERE login = :login";
$params = [':login' => $login];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

if($check_login = $stmt->fetch(PDO::FETCH_ASSOC)) {

	 $_SESSION['reg_session_login'] = 'Такой логин уже существует в базе!';

	 	$error = true;

	 header('Location: /register.php');
}

/* Проверка на дубляж емейл */

$sql = "SELECT email FROM users WHERE email = :email";
$params = [':email' => $email];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

if($check_email = $stmt->fetch(PDO::FETCH_ASSOC)) {

	 $_SESSION['reg_session_email'] = 'Такой email уже зарегистрирован!';

	 	$error = true;

	 header('Location: /register.php');
}

 /* Если все норм, записываем в бд данные регистрации */

if(empty( $error )) {


	$pwd = password_hash($password, PASSWORD_DEFAULT);

	$sql = "INSERT INTO `users` (login, email, password, date, ip) VALUES (:login, :email, :password, :date, :ip)";
    $params  = [':login' => $login, ':email' => $email, ':password' => $pwd, 'date' => $date, ':ip'=> getIp()];
    $users = $pdo->prepare($sql);
    $users->execute($params);

    $_SESSION['reg_session'] ='Вы зарегистрированы! Пожалуйста, нажмите <a href="/login.php">сюда</a>, чтобы авторизоваться!';

		header('Location: /register.php');

}