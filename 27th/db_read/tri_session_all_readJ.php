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

$stmt = $pdo->prepare( "SELECT * FROM `session_tbls2019`WHERE `class` = 'tri' AND `year` = '2019' ORDER BY `sessionNo` ASC;" );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );
if ( !$flag ) {
	$infor = $stmt->errorInfo();
	exit( $infor[ 2 ] );
}

$stmt_dr = $pdo->prepare( "SELECT MAX(`changed`) FROM `doctor_tbls`;" );
$stmt_dr->execute();
$row_dr = $stmt_dr->fetch( PDO::FETCH_ASSOC );
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2019`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
//$latest = mb_substr( $latest, 0, 10 );

$class = 'tri';
//print_r($rows); exit;
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
	<style>
		li span {
			font-weight: bold;
			color: red;
		}
	</style>
	<style>
		.inline-form {
			display: inline;
		}
		.btn-name {
			border: 0.1em dashed white;
			color: blue;
			background-color: white;
			border-radius: 0.5em;
			margin-right: 0.2em;
		}
		.btn-name:hover {
			background-color: red;
			font-weight: bold;
			color: yellow;
			border: 0.1cm solid black;
		}
	</style>
</head>
<!-- <body onLoad="init();"> -->

<body>

	<div class="container" id="day1">
		<h1 class="text-center text-danger">KAMAKURA TRI (12/14 SAT)</h1>
		<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?>
</span>
		<div class="row">

			<?php
			for ( $sessionNo = 1; $sessionNo < 10; $sessionNo++ ) {
				?>
			<!-- 土曜日の Session -->
			<div class="panel-group border-thick">
				<?php
				if ( mb_strpos( $rows[ $sessionNo - 1 ][ 'sessionTitle' ], "裏ライブ", 0, "UTF-8" ) !== false ) {
					echo '<div class="panel panel-primary">';
				} else {
					echo '<div class="panel panel-info">';
				}
				?>
				<!-- <div class="panel panel-info"> -->
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="btn btn-sm btn-success" >詳細</button></a>
						</li>
						<li class="bold18">
							<?= _Q(mb_substr($rows[$sessionNo - 1]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo - 1]['begin']) + $rows[$sessionNo - 1]['duration']*60); ?>
						</li>
						<li class="bold18">
							&nbsp;&nbsp;
							<?= _Q($rows[$sessionNo - 1]['sessionTitle']); ?>--
							<?= _Q($rows[$sessionNo - 1]['lectureTitle']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<?php
						if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year ) != "" ) {
							echo "<li><span>&nbsp;Chair:&nbsp;</span>";
							echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year );
							echo "</li>";
						}
						if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year ) != "" ) {
							echo "<li><span>Speaker:&nbsp;</span>";
							echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year );
							echo "</li>";
						}
						if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year ) != "" ) {
							echo "<li><span>Commentators:&nbsp;</span>";
							echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year );
							echo "</li>";
						}
						if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year ) != "" ) {
							echo "<li><span>In-Cathlabo Commentators:&nbsp;</span>";
							echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year );
							echo "</li>";
						}
						?>
					</ul>
				</div>
				<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
					<div class="panel-footer">
						<ul class="list-inline">
							<li><span>Content:&nbsp;</span>
								<?= _Q($rows[$sessionNo - 1]['description']); ?>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<ul class="list-inline">
							<li><span>Co-sponsors:&nbsp;</span>
								<?= _Q($rows[$sessionNo - 1]['cosponsor']); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php
			}
			?>



	<h1><br></h1>
	<hr>
	<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?>
</span>
	<div class="container" id="day2">
		<h1 class="text-center text-primary">KAMAKURA TRI (12/15 SUN)</h1>
		<div class="row">

			<!-- 日曜日のセッション -->
			<?php
			for ( $sessionNo = 10; $sessionNo < 19; $sessionNo++ ) {
				?>
			<div class="panel-group border-thick">
				<?php
				if ( mb_strpos( $rows[ $sessionNo - 1 ][ 'sessionTitle' ], "裏ライブ", 0, "UTF-8" ) !== false ) {
					echo '<div class="panel panel-primary">';
				} else {
					echo '<div class="panel panel-info">';
				}
				?>
				<!-- <div class="panel panel-info"> -->
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="btn btn-sm btn-danger" >詳細</button></a>
						</li>
						<li class="bold18">
							<?= _Q(mb_substr($rows[$sessionNo - 1]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo - 1]['begin']) + $rows[$sessionNo - 1]['duration']*60); ?>
						</li>
						<li class="bold18">
							&nbsp;&nbsp;
							<?= _Q($rows[$sessionNo - 1]['sessionTitle']); ?>--
							<?= _Q($rows[$sessionNo - 1]['lectureTitle']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<?php
						if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year ) != "" ) {
							echo "<li><span>&nbsp;Chair:&nbsp;</span>";
							echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year );
							echo "</li>";
						}
						if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year ) != "" ) {
							echo "<li><span>Speaker:&nbsp;</span>";
							echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year );
							echo "</li>";
						}
						if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year ) != "" ) {
							echo "<li><span>Commentators:&nbsp;</span>";
							echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year );
							echo "</li>";
						}
						if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year ) != "" ) {
							echo "<li><span>In-Cathlabo Commentators:&nbsp;</span>";
							echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year );
							echo "</li>";
						}
						?>
					</ul>
				</div>
				<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
					<div class="panel-footer">
						<ul class="list-inline">
							<li><span>Content:&nbsp;</span>
								<?= _Q($rows[$sessionNo - 1]['description']); ?>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<ul class="list-inline">
							<li><span>Co-sponsors:&nbsp;</span>
								<?= _Q($rows[$sessionNo - 1]['cosponsor']); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php
			}
			?>					
		</div>
	</div>

	<div class="container">
		<hr>
		<footer>
			<p>&copy; 2013 - 2019 by NPO International TRI Network & KAMAKURA LIVE</p>
		</footer>
	</div>

	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../index2016.js"></script>
</body>

</html>