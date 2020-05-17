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

	 if (!isset($_GET['member_kind'])) {
		$stmt = $pdo->prepare("SELECT * FROM `doctor_tbls` WHERE '1' = '1' ORDER BY `member_kind` DESC;");
	 } else {
		 if (!is_numeric($_GET['member_kind'])) {
			echo "Error!";
			exit;
		} else {
			if ($_GET['member_kind'] < 0 || $_GET['member_kind'] > 6) {
				echo "Error!";
				exit;
			}
			$_SESSION['member_kind'] = $_GET['member_kind'];
			$stmt = $pdo->prepare("SELECT * FROM `doctor_tbls` WHERE `on2017` = '1' AND `member_kind` = :member_kind ORDER BY `member_kind` DESC;");
			$stmt->bindValue(":member_kind", $_GET['member_kind'], PDO::PARAM_INT);
		}
	 }
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
		if ($_SESSION['member_kind'] == 3) {
			$data .= '<form method="post" action="each_dr_roles_list.php">';
		} else {
			$data .= '<form method="post" action="each_dr_roles_list-J.php">';
		}
		$data .= '<input type="hidden" name="dr_id" value="'._Q($row['id']).'">';
		$data .= '<input type="submit" value='.$i.' name="id" />';
		$data .= '</form>';
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
	$title = "KAMAKURA LIVE 2017 Faculty List";
	if ($_SESSION['member_kind'] == 1) $title = "NPO社員 2017";
	if ($_SESSION['member_kind'] == 2) $title = "NPO年次社員2017";
	if ($_SESSION['member_kind'] == 3) $title = "Foreign Faculty 2017";
	if ($_SESSION['member_kind'] == 4) $title = "国内招聘Faculty 2017";
	if ($_SESSION['member_kind'] == 5) $title = "親善参加";
	if ($_SESSION['member_kind'] == 6) $title = "Sd Faculty 2017";

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../favicon.ico">
<title>KAMAKURA LIVE Faculty Registration</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="../bootstrap/jumbotron/jumbotron.css">
<link rel="stylesheet" type="text/css" href="2017top.css">
<link rel="stylesheet" type="text/css" href="db_read/tri_session_table.css">
</head>

<body>
<h3 class="text-center text-danger">
  <?= $title ?>
  <span class="red_bold_sm">最終更新:
  <?= mb_substr($latest, 0, 10) ?>
  </span></h3>
<div class="row">
  <div class="col-lg-11">
    <div class="small">
      <table class="table table-striped small_left_align">
        <thead>
          <tr>
            <form name="doctors_list" method="post" action="#">
              <th class="small"><i class="glyphicon glyphicon-eye-open"></i></th>
              <?php
			  	if ($_SESSION['member_kind'] == 3) {
			 ?>
              <th class="smf"><button type="button" class="red_back" name="name" id="name" value="ASC" style="width:20px;text-align: center;"><span style="color:white;"><i class="glyphicon glyphicon-sort"></i></span></button></th>
              <?php
				}
			 ?>
              <?php
			  	if ($_SESSION['member_kind'] != 3) {
			  ?>
              <th class="smf"><button type="button" class="red_back" name="name" id="name" value="ASC" style="width:20px;text-align: center;"><span style="color:white;"><i class="glyphicon glyphicon-sort"></i></span></button></th>
              <th class="smf">名前</th>
              <?php
				}
			  ?>
              <th class="smf">病院名</th>
              <?php
			  	if ($_SESSION['member_kind'] == 3) {
			 ?>
              <th class="smf"><button type="button" class="red_back" name="nation" id="nation" value="ASC" style="width:20px;text-align: center;"><span style="color:white;"><i class="glyphicon glyphicon-sort"></i></span></button></th>
              <?php
				}
			  ?>
            </form>
          </tr>
        </thead>
        <tbody id="dataarea">
          <?= $data ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src = "https://code.jquery.com/jquery-2.1.4.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script> 
<script>
	if (!window.jQuery) {
		document.write('<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script> 
<script src="../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="index2016.js"></script> 
<script src="2017planning/dr_registration.js"></script>
</body>
</html>
