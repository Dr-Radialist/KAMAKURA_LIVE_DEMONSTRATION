<?php
session_start();
session_regenerate_id( true );
require_once( '../../utilities/config.php' );
require_once( '../../utilities/lib.php' );
charSetUTF8();
//接続
try {
	// MySQLサーバへ接続
	$pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}

$class = 'zagaku';
$stmt = $pdo->prepare( "SELECT * FROM `session_tbls` WHERE `class` = '" . $class . "' AND `year` = '" . $this_year . "' ORDER BY `begin` ASC;" );

$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );
if ( !$flag ) {
	$infor = $stmt->errorInfo();
	exit( $infor[ 2 ] );
}

$stmt = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls`;" );
$stmt->execute();
$row_come = $stmt->fetch( PDO::FETCH_ASSOC );

$stmt = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`" );
$stmt->execute();
$row_role = $stmt->fetch( PDO::FETCH_ASSOC );

$latest = max( $row_come[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );

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
	<title>KAMAKURA LIVE</title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="../2016top.css">
	<link rel="stylesheet" type="text/css" href="../db_read/style.css">
</head>


<body>
	<div class="container">
		<div class="row">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<ul class="list-inline">
						<li>最終更新日時:
							<?= $latest ?>
						</li>
						<li><span style="font-weight: bold; font-size: 20px;">&nbsp;&nbsp;インターベンション座学 12/09 (SAT) @ 日石ホール</span>
						</li>
					</ul>
				</div>
			</div>
			<?php
			for ( $sessionNo = 0; $sessionNo < 6; $sessionNo++ ) {
				?>
			<?php
				if (mb_strpos($rows[$sessionNo]['sessionTitle'], "裏ライブ", 0, "UTF-8") !== false) {
					echo '<div class="panel panel-success">'; 
				} else {
					echo '<div class="panel panel-primary">';
				}
			?>
			<!-- <div class="panel panel-primary"> -->
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<form method="post" action="db_entry/evt/evt01n.php">
								<button type="submit" class="detail" name="sessionNo" value="<?= $sessionNo ?>">修正</button>
						</li>
						<li>
							<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
						</li>
						<li>
							&nbsp;&nbsp;
							<?=_Q($rows[$sessionNo]['sessionTitle']); ?>::&nbsp;
							<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
							</form>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li>Chair:
							<?= _Q(makeCommonSessionList($pdo, $sessionNo, 1, $class, $this_year)); ?>
						</li>
						<li>Speaker:
							<?= _Q(makeCommonSessionList($pdo, $sessionNo, 3, $class, $this_year)); ?>
						</li>
					</ul>
					<ul class="list-inline">
						<li>Content:
							<?= _Q($rows[$sessionNo]['description']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-footer">
					Co-sponsors:
					<?= _Q($rows[$sessionNo]['cosponsor']); ?>
					</h2>
				</div>
			</div>
			<?php
			}
			?>


			<?php $sessionNo = 6; ?>
			<div class="panel panel-warning">
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<form method="post" action="db_entry/evt/evt01n.php">
								<button type="submit" class="detail" name="sessionNo" value="<?= $sessionNo ?>">修正</button>
						</li>
						<li>
							<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
						</li>
						<li>
							&nbsp;&nbsp;
							<?=_Q($rows[$sessionNo]['sessionTitle']); ?>::&nbsp;
							<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
							</form>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li>Chair:
							<?= _Q(makeCommonSessionList($pdo, $sessionNo, 1, $class, $this_year)); ?>
						</li>
						<li>Speaker:
							<?= _Q(makeCommonSessionList($pdo, $sessionNo, 3, $class, $this_year)); ?>
						</li>
					</ul>
					<ul class="list-inline">
						<li>Content:
							<?= _Q($rows[$sessionNo]['description']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-footer">
					Co-sponsors:
					<?= _Q($rows[$sessionNo]['cosponsor']); ?>
					</h2>
				</div>
			</div>

			<?php
			for ( $sessionNo = 7; $sessionNo < 15; $sessionNo++ ) {
				?>
			<?php
				if (mb_strpos($rows[$sessionNo]['sessionTitle'], "裏ライブ", 0, "UTF-8") !== false) {
					echo '<div class="panel panel-success">'; 
				} else {
					echo '<div class="panel panel-primary">';
				}
			?>
			<!-- <div class="panel panel-success"> -->
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<form method="post" action="db_entry/evt/evt01n.php">
								<button type="submit" class="detail" name="sessionNo" value="<?= $sessionNo ?>">修正</button>
						</li>
						<li>
							<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
						</li>
						<li>
							&nbsp;&nbsp;
							<?=_Q($rows[$sessionNo]['sessionTitle']); ?>::&nbsp;
							<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
							</form>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li>Chair:
							<?= _Q(makeCommonSessionList($pdo, $sessionNo, 1, $class, $this_year)); ?>
						</li>
						<li>Speaker:
							<?= _Q(makeCommonSessionList($pdo, $sessionNo, 3, $class, $this_year)); ?>
						</li>
					</ul>
					<ul class="list-inline">
						<li>Content:
							<?= _Q($rows[$sessionNo]['description']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-footer">
					Co-sponsors:
					<?= _Q($rows[$sessionNo]['cosponsor']); ?>
					</h2>
				</div>
			</div>
			<?php
			}
			?>


		</div>
		<hr>
		<footer>
			<p>&copy; 2013 - 2017 by NPO International TRI Network & KAMAKURA LIVE</p>
		</footer>
	</div>

	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../index2016.js"></script>
</body>

</html>