<?php
/* БЭКЕНД АВТОРИЗАЦИИ */

require_once "../classes/database.php";
require_once "../lib/func.php";

// ini_set('display_errors', 1);
// echo "<pre>";
// error_reporting(E_ALL);

$data = $_POST;

$email = $data['email'];
$pwd = $data['password'];

//$remember = $data['remember'];

	$error = false;

if(isset($data['go_auth'])) {

	if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		$_SESSION['auth_session'] = 'Некорректный Email!';

			header('Location: /login.php');

			$error = true;

	}

	if(trim($email) == "") {

		$_SESSION['auth_session'] = 'Введите Email!';

		header('Location: /login.php');

		$error = true;
	}

	if(trim($pwd) == "") {

		$_SESSION['auth_session'] = 'Введите Email!';

		header('Location: /login.php');

		$error = true;
	}

	$user = "SELECT * FROM `users` WHERE email = :email ";
	$params = [':email' => $email];
	$stmt = $pdo->prepare($user);
	$stmt->execute($params);

	$users = $stmt->fetch(PDO::FETCH_ASSOC);
	$hash = $users['password'];

	$sql = $pdo->prepare("UPDATE users SET ip = ? WHERE email = ?")->execute([getIp(), $email]);

	$updateIp = $stmt->fetch(PDO::FETCH_ASSOC);

		if($updateIp) {

			header('Location: /');
		}

	if(!checkBan($pdo, $users['id'], 2)) {

	if($users) {

		if(password_verify($pwd, $hash)) {

			$_SESSION['user_logs'] = $users;

			header('Location: /');

			$error = true;


		} else {

		$_SESSION['auth_session'] = 'Некорректно введенные данные!';

			header('Location: /login.php');

			$error = true;

		}

		} else
	{
		$_SESSION['auth_session'] = 'Нет такого аккаунта в базе!';

			header('Location: /login.php');

			$error = true;
	}
} else {

	$_SESSION['auth_session'] = 'Ваш аккаунт заблокирован!';

		header('Location: /login.php');

		$error = true;
}

	if(!empty( $error )) {


	echo '<div style ="color: #ffffff;">' .array_shift( $_SESSION['auth_session'] ).'</div>';

	header('Location: /login.php');

}

}
?>
