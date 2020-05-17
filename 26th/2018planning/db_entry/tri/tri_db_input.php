<?php
/*
これは非公開用Faculty Listデータベース維持プログラムである
*/

session_start();
session_regenerate_id( true );
require_once( '../../../../utilities/config.php' );
require_once( '../../../../utilities/lib.php' );

charSetUTF8();
//接続
try {
	// MySQLサーバへ接続
	$pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}

$stmt_latest = $pdo->prepare( "SELECT MAX(`changed`) FROM `doctor_tbls` WHERE '1' = '1';" );
$stmt_latest->execute();
$row_latest = $stmt_latest->fetch( PDO::FETCH_ASSOC );
$latest = $row_latest[ 'MAX(`changed`)' ];

$stmt = $pdo->prepare( "SELECT * FROM `session_tbls2018` WHERE `year` = ".$this_year." AND `class` = 'tri' ORDER BY `beginDate` ASC;" );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

if ( !$flag ) {
	$infor = $stmt->errorInfo();
	exit( $infor[ 2 ] );
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
<h3 class="text-center text-danger">KAMAKURA LIVE <?= _Q($this_year); ?> TRI Session時間割り決定<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
  <?= $latest ?>
  </span></h3>
	<div class="row">
		<div class="col-lg-12">
			<div class="small">
				<button type="submit" class="btn btn-warning" onClick="location.href='../../../../planner_only/index-mod.php'">Top Pageに戻る</button>
				<form method="post" action="tri_db_input00.php">
					<button type="submit" class="btn btn-success">新規時間割追加</button>
				</form>
				<br>
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="small">戻る</th>
							<th class="small">sessionNo</th>
							<th class="small">beginDate</th>
							<th class="small">duration</th>
							<th class="small">sessionTitle</th>
							<th class="small">cosponsor</th>
							<th class="small">lectureTitle</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ( $rows as $row ) {
							?>
						<tr>
							<td class="small">
							<button class="btn btn-warning" onClick="location.href='../../../../planner_only/index-mod.php'"><span class="glyphicon glyphicon-backward"</span></button>
							</td>
							<td class="small">
								<form method="post" action="tri_db_mod00.php">
									<button type="submit" class="btn btn-sm btn-danger" name="id" value="<?= _Q($row['id']); ?>">修正</button>
								</form>
							</td>
							<td class="small">
								<?= _Q($row['beginDate']); ?>
							</td>
							<td class="small">
								<?= _Q($row['duration']); ?>
							</td>
							<td class="small">
								<?= _Q($row['sessionTitle']); ?>
							</td>
							<td class="small">
								<?= _Q($row['cosponsor']); ?>
							</td>
							<td class="small">
								<?= _Q($row['lectureTitle']); ?>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>

			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../../../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../../../index2016.js"></script>
	<script src="../../../2018planning/dr_registration.js"></script>
</body>
</html>