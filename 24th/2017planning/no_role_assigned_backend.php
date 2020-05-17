<?php
	
	if (!is_numeric($_POST['member_kind'])||!is_numeric($_POST['role_times'])) exit;
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
		
	$sql_0 = "SELECT * FROM `doctor_tbls` WHERE `doctor_tbls`.`member_kind` =:member_kind AND 
		`id` NOT IN (select `role_tbls`.`dr_tbl_id` from `role_tbls` WHERE `role_tbls`.`year` = ".$this_year.");";

	$sql_n = "SELECT *, count(`dr_tbl_id`) as `role_times` FROM `role_tbls` INNER JOIN `doctor_tbls` 
		ON `role_tbls`.`dr_tbl_id` = `doctor_tbls`.`id` WHERE `doctor_tbls`.`member_kind` = :member_kind AND `role_tbls`.`year` = ".$this_year.
		" group by `role_tbls`.`dr_tbl_id` HAVING `role_times` =:role_times;";
		
	if ($_POST['role_times'] == 0) {
		$stmt = $pdo->prepare($sql_0);
		$stmt->bindValue(":member_kind", $_POST['member_kind'], PDO::PARAM_INT);
	} else {
		$stmt = $pdo->prepare($sql_n);
		$stmt->bindValue("member_kind", $_POST['member_kind'], PDO::PARAM_INT);
		$stmt->bindValue("role_times", $_POST['role_times'], PDO::PARAM_INT);
	}
	$flag = $stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if (!$flag) {
    		$infor = $stmt->errorInfo();
			exit($infor[2]);
	}
	
	$i = 1;
	$search_results = '';
  	foreach ($rows as $row) {	
		$search_results .= '<tr><td class="smf">';
		$search_results .= '<form method="post" action="../each_dr_roles_list-J.php">';
		$search_results .= '<input type="hidden" name="dr_id" value="'._Q($row['id']).'" id="dr_id" />';
		$search_results .= '<input type="submit" value="お仕事検索 !" />';
		$search_results .= '</form></td>';
		$search_results .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['english_sirname'])).' '._Q(trimBothEndSpace($row['english_firstname'])).'</td>';
		$search_results .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['kanji_sirname'])).' '._Q(trimBothEndSpace($row['kanji_firstname'])).'</td>';
		$search_results .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['hp_name_japanese'])).'</td>';
		$search_results .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['hp_name_english'])).'</td>';
		$search_results .= '</tr>';
		$i++; 
	}
	
	
	echo $search_results;
	exit;
	
?>
