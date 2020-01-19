<?php
/* БЭКЕНД ФУНКЦИЙ НА САЙТЕ */
/*
namespace lib;

class func {

	public function SiteTime() {

		$hour = (int)strftime ('%H');
		$welcome = '';
		if($hour>0 and $hour<6){
		  $welcome = "Доброй ночи";
		}elseif ($hour>=6 and $hour<12){
			$welcome = "Доброе утро";
		}elseif ($hour>=12 and $hour<18){
			$welcome = "Добрый день";
		}elseif($hour>=18 and $hour<23){
		    $welcome =  "Доброй вечер";
		}else{
			$welcome = "Доброй ночи";
		}
		echo $welcome;

	}
}
*/

function siteTime() {

	$hour = (int)strftime ('%H');
	$welcome = '';
	if($hour>0 and $hour<6){
		$welcome = "Доброй ночи";
	}elseif ($hour>=6 and $hour<12){
		$welcome = "Доброе утро";
	}elseif ($hour>=12 and $hour<18){
		$welcome = "Добрый день";
	}elseif($hour>=18 and $hour<23){
			$welcome =  "Доброй вечер";
	}else{
		$welcome = "Доброй ночи";
	}
	echo $welcome;
}

function checkBan($pdo, $userid, $type) {

	$sql = "SELECT * FROM ban_list WHERE user_id = :id AND type = :type";
	$params = [':id' => $userid, ':type' => $type];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($params);

	$checkBan = $stmt->fetch(PDO::FETCH_ASSOC);

	return $checkBan;
}

function getIp() {

	return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
}

 ?>
