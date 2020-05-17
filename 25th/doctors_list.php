<?php
/*
これは公開用のFaculty listである
*/
	session_start();
	session_regenerate_id(true);
	require_once('../utilities/config.php');
	require_once('../utilities/lib.php');	
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
	
	$stmt = $pdo->prepare("SELECT * FROM `doctor_tbls` WHERE `member_kind` = :member_kind AND `on2018` = '1' ORDER BY ".$order.";");
	$stmt->bindValue(":member_kind", $_SESSION['member_kind'], PDO::PARAM_INT);
	
	$flag = $stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if (!$flag) {
    		$infor = $stmt->errorInfo();
			exit($infor[2]);
	}
	
	$data = '';	
	$i = 1;
	
  	  	foreach ($rows as $row) {
          /*
		  ここで <form></form>を <td></td>の間に挟まないとイベントが発生しない!!
		  */		
		$data .= '<tr><td class="small">';
			$data .= '<input type="submit" value='.$i.' name="id" />';
			$data .= '</td>';
			if ($_SESSION['member_kind'] == 3) {
				$data .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['english_sirname'])).' '._Q(trimBothEndSpace($row['english_firstname'])).'</td>';
			}
			if ($_SESSION['member_kind'] != 3) {
				$data .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['kana_sirname'])).' '._Q(trimBothEndSpace($row['kana_firstname'])).'</td>';
				$data .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['kanji_sirname'])).' '._Q(trimBothEndSpace($row['kanji_firstname'])).'</td>';
			}
			$data .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['hp_name_japanese'])).'</td>';
			if ($_SESSION['member_kind'] == 3) {
				$data .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['nation'])).'</td>';
			}
		$data .= '</tr>';
		$i++; 
	}
	
          /*
		  ここで <form></form>を <td></td>の間に挟まないとイベントが発生しない!!
		  */
		  
	
	  echo $data;
	 exit;
	 
?>
