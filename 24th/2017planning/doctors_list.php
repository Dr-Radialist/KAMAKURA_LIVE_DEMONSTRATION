<?php
	session_start();
	session_regenerate_id(true);
	require_once('../../utilities/config.php');
	require_once('../../utilities/lib.php');	
	charSetUTF8();
	//接続
 	try {
    // MySQLサーバへ接続
   	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
    	die($e->getMessage());
	}
	
	$stmt_latest = $pdo->prepare("SELECT MAX(`changed`) FROM `doctor_tbls` WHERE '1' = '1';");
	$stmt_latest->execute();
	$row_latest = $stmt_latest->fetch(PDO::FETCH_ASSOC);
	$latest = $row_latest['MAX(`changed`)']; 
	if (isset($_POST['name'])) {
		$order ="`english_sirname` ".$_POST['name'];
	}
	if (isset($_POST['kana_name'])) {
		$order = "`kana_sirname` ".$_POST['kana_name'];
	}
	if (isset($_POST['member_kind'])) {
		$order = "`member_kind` ".$_POST['member_kind'];
	}
	if (isset($_POST['nation'])) {
		$order = "`nation` ".$_POST['nation'];
	}
	
	$stmt = $pdo->prepare("SELECT *FROM `doctor_tbls` WHERE '1' = '1' ORDER BY ".$order.";");
	
	$flag = $stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if (!$flag) {
    		$infor = $stmt->errorInfo();
			exit($infor[2]);
	}
	
	$data = '';
	
		  $i = 1;
  	foreach ($rows as $row) {
		$data .= '<tr><td class="small">';
			$data .= '<form method="post" action="db_entry/doctor_registration/dr01.php">';
			$data .= '<input type="hidden" value='._Q($row['id']).' name="id"/>';
			$data .= '<input type="hidden" name="new_old" value="old" />';
			$data .= '<input type="submit" value="'.$i.'" class="btn-sm" />';
			$data .= '</form></td>';
			$data .= '<td class="small_left_align">'._Q($row['english_sirname']).' '._Q($row['english_firstname']).'</td>';
			$data .= '<td class="small_left_align">'._Q($row['kana_sirname']).' '._Q($row['kana_firstname']).'</td>';
			$data .= '<td class="small_left_align">'._Q($row['kanji_sirname']).' '._Q($row['kanji_firstname']).'</td>';
			$data .= '<td class="small_left_align">'._Q($row['hp_name_japanese']).'</td>';
			$data .= '<td class="small_left_align">';;
				if ($row['member_kind'] == 1) $data .= "NPO社員";
				if ($row['member_kind'] == 2) $data .= "NPO年次社員";
				if ($row['member_kind'] == 3) $data .= "海外招聘";
				if ($row['member_kind'] == 4) $data .= "国内招聘";
				if ($row['member_kind'] == 5) $data .= "親善参加";
				if ($row['member_kind'] == 6) $data .= "Sd Faculty";
			$data .= '<td class="small_left_align">'._Q($row['nation']).'</td>';
			$data .= '</td>';
			$data .= '<td class="small_left_align">'._Q($row['email']).'</td>';
		$data .= '</tr>';
		$i++; 
	}	
	echo $data;
	exit;
	 
?>
