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

$stmt = $pdo->prepare( "SELECT * FROM `session_tbls2018`WHERE `class` = 'tri' AND `sessionNo` >= '0' AND `year` = '" . $this_year . "' ORDER BY `sessionNo` ASC;" );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

if ( !$flag ) {
	$infor = $stmt->errorInfo();
	exit( $infor[ 2 ] );
}

$stmt = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2018`;" );
$stmt->execute();
$row1 = $stmt->fetch( PDO::FETCH_ASSOC );
$stmt = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt->execute();
$row2 = $stmt->fetch( PDO::FETCH_ASSOC );
$latest = max( $row1[ 'MAX(`changed`)' ], $row2[ 'MAX(`created`)' ] );
$class = 'tri';

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
	<link rel="stylesheet" type="text/css" href="../db_read/tri_session_table.css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="container" id="day1">
				<h1 class="text-center text-danger">KAMAKURA TRI (12/15 SAT)
				<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?>&nbsp;&nbsp;<a class="btn btn-lg btn-danger" href="../../planner_only/index-mod.php">Top Pageに戻る</a>
</span></h1>
				<div class="row">

					<?php
					for ( $sessionNo = 1; $sessionNo < 10; $sessionNo++ ) {
						?>
					<!-- 土曜日の Session -->
					<div class="panel-group border-thick">
						<form method="post" action="../2018planning/db_entry/tri/tri01n.php">
							<button type="submit" class="subsession_button" name="sessionNo" value="<?=$sessionNo; ?>" </button>Modify</button>
						</form>

						<!-- <div class="panel panel-info"> -->
						<div class="panel-heading">
							<ul class="list-inline">
								<li>
									<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
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
								<li>Chair:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
								</li>
								<li>Speaker:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
									<li>Commentators:
										<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 2, $class, $this_year)); ?>
									</li>
							</ul>
						</div>
						<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Content:
										<?= _Q($rows[$sessionNo - 1]['description']); ?>
									</li>
								</ul>
							</div>
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Co-sponsors:
										<?= _Q($rows[$sessionNo - 1]['cosponsor']); ?>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php
					}
					?>
					<?php $sessionNo = 17; ?>
					<!-- 土曜日の Session -->
					<div class="panel-group border-thick">
						<form method="post" action="../2018planning/db_entry/tri/tri01n.php">
							<button type="submit" class="subsession_button" name="sessionNo" value="<?=$sessionNo; ?>" </button>Modify</button>
						</form>

						<!-- <div class="panel panel-info"> -->
						<div class="panel-heading">
							<ul class="list-inline">
								<li>
									<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
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
								<li>Chair:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
								</li>
								<li>Speaker:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
									<li>Commentators:
										<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 2, $class, $this_year)); ?>
									</li>
							</ul>
						</div>
						<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Content:
										<?= _Q($rows[$sessionNo - 1]['description']); ?>
									</li>
								</ul>
							</div>
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Co-sponsors:
										<?= _Q($rows[$sessionNo - 1]['cosponsor']); ?>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<h1><br></h1>
			<hr>

			<div class="container" id="day1">
				<h1 class="text-center text-danger">KAMAKURA TRI (12/16 SUN)</h1>
				<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?><a href="../../planner_only/index-mod.php"><button class="btn btn-sm btn-danger">Top Pageに戻る</button></a>
</span>
				<div class="row">

					<?php
					for ( $sessionNo = 10; $sessionNo < 13; $sessionNo++ ) {
						?>
					<!-- 日曜日の Session -->
					<div class="panel-group border-thick">
						<form method="post" action="../2018planning/db_entry/tri/tri01n.php">
							<button type="submit" class="subsession_button" name="sessionNo" value="<?=$sessionNo; ?>" </button>Modify</button>
						</form>
						<!-- <div class="panel panel-info"> -->
						<div class="panel-heading">
							<ul class="list-inline">
								<li>
									<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
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
								<li>Chair:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
								</li>
								<li>Speaker:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
								</li>
								<li>Commentators:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 2, $class, $this_year)); ?>
								</li>
							</ul>
						</div>
						<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Content:
										<?= _Q($rows[$sessionNo - 1]['description']); ?>
									</li>
								</ul>
							</div>
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Co-sponsors:
										<?= _Q($rows[$sessionNo - 1]['cosponsor']); ?>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php
					}
					?>
				
				<?php
					for ( $sessionNo = 18; $sessionNo < 20; $sessionNo++ ) {
						?>
					<!-- 日曜日の Session -->
					<div class="panel-group border-thick">
						<form method="post" action="../2018planning/db_entry/tri/tri01n.php">
							<button type="submit" class="subsession_button" name="sessionNo" value="<?=$sessionNo; ?>" </button>Modify</button>
						</form>
						<!-- <div class="panel panel-info"> -->
						<div class="panel-heading">
							<ul class="list-inline">
								<li>
									<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
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
								<li>Chair:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
								</li>
								<li>Speaker:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
								</li>
								<li>Commentators:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 2, $class, $this_year)); ?>
								</li>
							</ul>
						</div>
						<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Content:
										<?= _Q($rows[$sessionNo - 1]['description']); ?>
									</li>
								</ul>
							</div>
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Co-sponsors:
										<?= _Q($rows[$sessionNo - 1]['cosponsor']); ?>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php
					}
					?>
	
	<?php
					for ( $sessionNo = 13; $sessionNo < 17; $sessionNo++ ) {
						?>
					<!-- 日曜日の Session -->
					<div class="panel-group border-thick">
						<form method="post" action="../2018planning/db_entry/tri/tri01n.php">
							<button type="submit" class="subsession_button" name="sessionNo" value="<?=$sessionNo; ?>" </button>Modify</button>
						</form>
						<!-- <div class="panel panel-info"> -->
						<div class="panel-heading">
							<ul class="list-inline">
								<li>
									<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
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
								<li>Chair:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
								</li>
								<li>Speaker:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
								</li>
								<li>Commentators:
									<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 2, $class, $this_year)); ?>
								</li>
							</ul>
						</div>
						<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Content:
										<?= _Q($rows[$sessionNo - 1]['description']); ?>
									</li>
								</ul>
							</div>
							<div class="panel-footer">
								<ul class="list-inline">
									<li>Co-sponsors:
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


			<hr>
			<footer>
				<p>&copy; 2013 - 2018 by NPO International TRI Network & KAMAKURA LIVE</p>
			</footer>

		</div>
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