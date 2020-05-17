<?php
/*
これは非公開用Faculty Listデータベース維持プログラムである
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
	$_SESSION['sessionNo'] = $_POST['sessionNo'];
	$_session['role_kind'] = $_POST['role_kind'];
	$stmt_latest = $pdo->prepare("SELECT MAX(`changed`) FROM `doctor_tbls` WHERE '1' = '1';");
	$stmt_latest->execute();
	$row_latest = $stmt_latest->fetch(PDO::FETCH_ASSOC);
	
	$stmt = $pdo->prepare("SELECT MAX(`created`) FROM `role_tbls`");
	$stmt->execute();
	$row_role = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$latest = max($row_latest['MAX(`changed`)'], $row_role['MAX(`created`)']);
	
	$stmt = $pdo->prepare("SELECT * FROM `doctor_tbls` WHERE '1' = '1' ORDER BY `kana_sirname` ASC;");
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
		$data .= '<tr><td class="small_left_align">';
			$data .= '<form method="post"  action="chair_mod_add02.php" >'; /* action="chair_mod_add02.php" */
			$data .= '<input type="hidden" name="id" value="'._Q($row['id']).'" />';
			$data .= '<input type="hidden" name="sessionNo" value="'._Q($_SESSION['sessionNo']).'" />';
			$data .= '<input type="hidden" name="role_kind" value="'._Q($_SESSION['role_kind']).'" />';
			$data .= '<button><i class="glyphicon glyphicon-plus-sign"></i></button>';
			$data .= '</td></form>';
			$data .= '<td class="small_left_align">'._Q($row['english_sirname']).' '._Q($row['english_firstname']).'</td>';
			$data .= '<td class="small_left_align">'._Q($row['kana_sirname']).' '._Q($row['kana_firstname']).'</td>';
			$data .= '<td class="small_left_align">'._Q($row['kanji_sirname']).' '._Q($row['kanji_firstname']).'</td>';
			$data .= '<td class="small_left_align">'._Q($row['hp_name_japanese']).'</td>';
			$data .= '<td class="small_left_align">'._Q($row['nation']).'</td>';
			$data .= '<td class="small_left_align">';;
				if ($row['member_kind'] == 1) $data .= "NPO社員";
				if ($row['member_kind'] == 2) $data .= "NPO年次社員";
				if ($row['member_kind'] == 3) $data .= "海外招聘";
				if ($row['member_kind'] == 4) $data .= "国内招聘";
				if ($row['member_kind'] == 5) $data .= "親善参加";
			$data .= '</td>';
			$data .= '<td class="small_left_align">'._Q($row['email']).'</td>';
		$data .= '</tr>';
		$i++; 
		$_SESSION['sessionNo'] = $_POST['sessionNo'];
		$_SESSION['role_kind'] = $_POST['role_kind'];
	}
         
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../../../favicon.ico">
<title>KAMAKURA LIVE Faculty Registration</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="../../../../bootstrap/css/bootstrap.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="../../../../bootstrap/jumbotron/jumbotron.css">
<link rel="stylesheet" type="text/css" href="../../../2016top.css">
<link rel="stylesheet" type="text/css" href="../../../db_read/tri_session_table.css">
</head>

<body>

<h1 class="text-center text-danger">Faculty Member Registration<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
  <?= $latest ?>
  </span></h1>

<div class="row">
  <div class="col-lg-11">
  	<div class="small">
      <table class="table table-striped">
        <thead>
          <tr>
          <form name="chair_mod_list" method="post">
            <th class="small">#</th>
            <th class="smf"><button type="button" class="red_back" name="name" id="name" value="ASC" style="width:20px;text-align: center;"><span style="color:white;"><i class="glyphicon glyphicon-sort"></i></span></button></th>
            <th class="smf"><button type="button" class="red_back" name="kana_name" id="kana_name" value="ASC" style="width:20px;text-align: center;"><span style="color:white;"><i class="glyphicon glyphicon-sort"></i></span></button></th>
            <th class="smf">名前</th>
            <th class="smf">病院名</th>         
            <th class="smf"><button type="button" class="red_back" name="nation" id="nation" value="ASC" style="width:20px;text-align: center;"><span style="color:white;"><i class="glyphicon glyphicon-sort"></i></span></button></th>
            <th class="smf"><button type="button" class="red_back" name="member_kind" id="member_kind" value="ASC" style="width:20px;text-align: center;"><span style="color:white;"><i class="glyphicon glyphicon-sort"></i></span></button></th>
            <th class="smf">email</th>
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
<script src="../../../../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="../../../index2016.js"></script> 
<script src="../chair_mod_add_list.js"></script>
</body>
</html>
