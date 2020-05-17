<?php
/*
これは公開用のdoctor role findingである
まずフロントエンドとして alphabetical nameにより候補を検索する
これにより候補doctorのリスト表示すれるので　それを選択すれば
role一覧出力する
*/

	session_start();
	session_regenerate_id(true);
	require_once('../../../../utilities/config.php');
	require_once('../../../../utilities/lib.php');	
	charSetUTF8();
	//接続
 	try {
    // MySQLサーバへ接続
   	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
    		die($e->getMessage());
	}
	
	$sirname = strip_tags(trimBothEndSpace(mb_substr($_POST['search_term'], 0, 100)));	// 前後のspaceなど削除し、文字数を100文字に制限する
	$sirname = strtoupper(mb_convert_kana($sirname, 'ash'));		// 半角英字大文字に変換する

	$stmt = $pdo->prepare("SELECT * FROM `doctor_tbls` WHERE `english_sirname` LIKE :english_sirname ORDER BY `english_sirname` ASC;");
	$stmt->bindValue(":english_sirname", $sirname.'%', PDO::PARAM_STR);
	$flag = $stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if (!$flag) {
    		$infor = $stmt->errorInfo();
			exit($infor[2]);
	}
		
	$search_results = '';
	$search_results .= '<table class="table table-striped">';
	$search_results .= '<caption>下記の候補者より選択して下さい</caption>';
	$search_results .= '<thead>';
	$search_results .= '<tr>';
	$search_results .= '<th class="smf sm">#</th>';
	$search_results .= '<th class="smf">Sirname</th>';
	$search_results .= '<th class="smf">姓</th>';
	$search_results .= ' <th class="smf">病院</th>';
	$search_results .= '<th class="smf">Hospital</th>';
	$search_results .= '</tr>';
	$search_results .= '</thead>';
	$search_results .= '<tbody>';
	
	$i = 1;
  	foreach ($rows as $row) {
          /*
		  ここで <form></form>を <td></td>の間に挟まないとイベントが発生しない!!
		  */		
		$search_results .= '<tr><td class="smf">';
		$search_results .= '<form method="post" action="chair_mod_add02m.php">';
		$search_results .= '<input type="hidden" name="dr_id" value="'._Q($row['id']).'" id="dr_id" />';
		$search_results .= '<input type="hidden" name="sessionNo" value="'._Q($_POST['sessionNo']).'" />';
		$search_results .= '<input type="hidden" name="role_kind" value="'._Q($_POST['role_kind']).'" />';
		$search_results .= '<input type="submit" value="追加する" />';
		$search_results .= '</form></td>';
		$search_results .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['english_sirname'])).' '._Q(trimBothEndSpace($row['english_firstname'])).'</td>';
		$search_results .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['kanji_sirname'])).' '._Q(trimBothEndSpace($row['kanji_firstname'])).'</td>';
		$search_results .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['hp_name_japanese'])).'</td>';
		$search_results .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['hp_name_english'])).'</td>';
		$search_results .= '</tr>';
		$i++; 
	}
	
	$search_results .= ' </tbody>';
	$search_results .= '</table>';
	
	echo $search_results;
	exit;
	
?>
