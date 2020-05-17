<?php
/*
これは非公開用
Rolが重複していないかチェックする
*/

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
	
	$sql = "SELECT `ST`.`sessionNo`,  `DT`.`english_sirname`,  `DT`.`english_firstname`, `ST`.`class`,`ST`.`begin`, `ST`.`duration`";
	$sql .= "  FROM `doctor_tbls` AS `DT` INNER JOIN (`role_tbls` AS `RT` INNER JOIN  `session_tbls` AS `ST` ON `RT`.`sessionNo` = ";
	$sql .= "`ST`.`sessionNo` AND `RT`.`class` = `ST`.`class`) ON  `DT`.`id` = `RT`.`dr_tbl_id` WHERE `ST`.`begin` <> '00:00:00'   AND ";
	$sql .= "`ST`.`sessionNo` > '0' AND `ST`.`year` = '".$this_year."' ORDER BY `DT`.`english_sirname` ASC, `DT`.`english_firstname` ASC,  ";
	$sql .= "`ST`.`sessionNo` ASC, `ST`.`begin` ASC, `ST`.`duration` DESC;";
	
	echo $sql; echo "<br>";
	echo "I am very sorry. This function is not yet implemented."; exit;

	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	
	$search_results = '';
	$search_results .= '<table class="table table-striped">';
	$search_results .= '<thead>';
	$search_results .= '<tr>';
	$search_results .= '<th class="smf sm">#</th>';
	$search_results .= '<th class="smf">DATE/種別</th>';
	$search_results .= '<th class="smf">TIME</th>';
	$search_results .= ' <th class="smf">Sessioin Title</th>';
	$search_results .= '<th class="smf">Role</th>';
	$search_results .= '</tr>';
	$search_results .= '</thead>';
	$search_results .= '<tbody>';
	
	$i = 1;
  	foreach ($rows as $row) {
          /*
		  ここで <form></form>を <td></td>の間に挟まないとイベントが発生しない!!
		  */		
		$search_results .= '<tr><td class="smf">';
		$search_results .= $i;
		$search_results .= '</td>';
		$search_results .= '<td class="small_left_align">';
		if ($row['class'] == 'evt') {
			$search_results .= '12/07 EVT Video';
		} else if ($row['class'] == 'com') {
			$search_results .= '12/08 Comedical';
		} else if (($row['sessionNo'] > 13)&&($row['class'] == 'tri')) {
			$search_results .= '12/18 TRI';
		}  else {
			$search_results .= '12/17 TRI';
		}
		$search_results .= '</td>';
		$search_results .= '<td class="small_left_align">'. _Q(mb_substr($row['begin'], 0, 5)).' - '.date("H:i" , strtotime($row['begin']) +$row['duration']*60).'</td>';
		$search_results .= '<td class="small_left_align">'._Q(trimBothEndSpace($row['sessionTitle'])).'</td>';
		$search_results .= '<td class="small_left_align">';
		if ($row['role_kind'] == '1') {
			$search_results .= 'Chair';
		} else if ($row['role_kind'] == '2') {
			$search_results .=  'Moderator';
		} else if ($row['role_kind'] == '3') {
			$search_results .= 'Lecturer';
		} else if ($row['role_kine'] == 4) {
			$search_results .= 'In Cathlabo Commentator';
		}
		$search_results .= '</td>';
		$search_results .= '</tr>';
		$i++; 
	}

	$search_results .= ' </tbody>';
	$search_results .= '</table>';
	
	$stmt_latest = $pdo->prepare("SELECT MAX(`changed`) FROM `doctor_tbls` WHERE '1' = '1';");
	$stmt_latest->execute();
	$row_latest = $stmt_latest->fetch(PDO::FETCH_ASSOC);
	$latest = $row_latest['MAX(`changed`)']; 
	
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../favicon.ico">
<title>KAMAKURA LIVE Faculty Roles</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="../../bootstrap/jumbotron/jumbotron.css">
<link rel="stylesheet" type="text/css" href="../2016top.css">
<link rel="stylesheet" type="text/css" href="../db_read/tri_session_table.css">
</head>

<body>
<div class="container">
<div class="row">

<h3 class="text-center text-danger">Role割当済み検索画面<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
  <?= $latest ?>
  </span></h3>
  <h4 class="text-primary">この画面において、それぞれの Faculty種別毎に、役割分担回数により割り当てられている方々のリストを検索することができます<br></h4>

  <form class="form-horizontal" method="post">
    <div class="form-group">
      <label for="member_kind" class="control-label col-xs-2">Faculty種別</label>
      <div class="col-xs-5">
        <select class="form-control" id="memberKind">
          <option value="1">NPO社員</option>
          <option value="2">NPO年次社員</option>
          <option value="3">海外招聘</option>
          <option value="4">国内招聘</option>
          <option value="5">親善参加</option>
          <option value="6">Sd Faculty</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="role_times" class="control-label col-xs-2">Role回数</label>
      <div class="col-xs-5">
        <select class="form-control" id="role_times">
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>
    </div>
  </form>
</div>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-11">
      <div class="small"> <br>
        <table class="table table-striped">
          <thead>
            <tr>
              <form method="post">
                <th class="small">#</th>
                <th class="smf"><button type="button" class="red_back" name="name" id="name" value="ASC" style="width:20px;text-align: center;"><span style="color:white;"><i class="glyphicon glyphicon-sort"></i></span></button></th>
                <th class="smf"><button type="button" class="red_back" name="kana_name" id="kana_name" value="ASC" style="width:20px;text-align: center;"><span style="color:white;"><i class="glyphicon glyphicon-sort"></i></span></button></th>
                <th class="smf">名</th>
                <th class="smf">病院名</th>
              </form>
            </tr>
          </thead>
          <tbody id="search_results">
          </tbody>
        </table>
      </div>
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
<script src="../../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="../index2016.js"></script> 
<script src="dr_registration.js"></script> 
<script>
	$(document).ready(function() {
		$("#memberKind").change(function(e) {
			e.preventDefault();
			ajax_search();
		});
		$("#role_times").change(function(e) {
			e.preventDefault();
			ajax_search();
		});
		function ajax_search() {		
			var member_kind = $("#memberKind option:selected").val();
			var role_times = $("#role_times option:selected").val();
			$.post("no_role_assigned_backend.php", {member_kind: member_kind, role_times: role_times}, function(data) {
				if (data.length > 0) {
					$("#search_results").html(data);
				}
				if (data.length === 0) {
					$("#search_results").html('');
				}
			});
		}
	});
</script>
</body>
</html>
