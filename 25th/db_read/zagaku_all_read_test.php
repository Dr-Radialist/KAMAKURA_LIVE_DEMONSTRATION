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
$stmt = $pdo->prepare( "SELECT * FROM `session_tbls2018` WHERE `class` = '" . $class . "' AND `year` = '" . $this_year . "' ORDER BY `begin` ASC;" );
// session_noでのソートを辞めた　従って、classと時刻のみでソートされる
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );


if ( !$flag ) {
	$infor = $stmt->errorInfo();
	exit( $infor[ 2 ] );
}

$stmt_dr = $pdo->prepare( "SELECT MAX(`changed`) FROM `doctor_tbls`;" );
$stmt_dr->execute();
$row_dr = $stmt_dr->fetch( PDO::FETCH_ASSOC );
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2018`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
//$latest = mb_substr( $latest, 0, 10 );

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
	<link rel="stylesheet" type="text/css" href="../../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="zagaku.css">
	<style>
		li span {
			font-weight: bold;
			font-style: italic;
			color: purple;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">
					<ul class="list-inline">
						<li class="bold20">&nbsp;&nbsp;インターベンション座学 12/15 (SAT) @ 日石ホール
						</li>
						<li>最終更新日時:
							<?= $latest ?>
						</li>
					</ul>
				</div>
			</div>


			<?php
			for ( $sessionNo = 1; $sessionNo < 5; $sessionNo++ ) {
				echo '<div class="panel-group border-thick">';

				if ( mb_strpos( $rows[ $sessionNo - 1 ][ 'sessionTitle' ], "裏ライブ", 0, "UTF-8" ) !== false ) {
					echo '<div class="panel panel-primary">';
				} else {
					echo '<div class="panel panel-info">';
				}

				echo '<div class="panel-heading"><ul class="list-inline">';
				echo '<li><a data-toggle="collapse" href="#collapse ' . $sessionNo . '">';
				echo '<button type="submit" class="btn btn-sm btn-success">詳細</button>';
				echo '</a></li><li class="bold18">';
				echo _Q( mb_substr( $rows[ $sessionNo - 1 ][ 'begin' ], 0, 5 ) );
				echo '&nbsp;-&nbsp;';
				echo date( "H:i", strtotime( $rows[ $sessionNo - 1 ][ 'begin' ] ) + $rows[ $sessionNo - 1 ][ 'duration' ] * 60 );
				echo '</li><li class="bold18">&nbsp;&nbsp;';
				echo _Q( $rows[ $sessionNo - 1 ][ 'sessionTitle' ] );
				echo '--';
				echo _Q( $rows[ $sessionNo - 1 ][ 'lectureTitle' ] );
				echo '</li></ul></div><div class="panel-body"><ul class="list-inline">';
				if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 1, $class, $this_year ) ) != "" ) {
					echo '<li><span>&nbsp;Chair:&nbsp;</span>';
					echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 1, $class, $this_year ) );
					echo '</li>';
				}
				if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 3, $class, $this_year ) ) != "" ) {
					echo '<li><span>Speaker:&nbsp;</span>';
					echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 3, $class, $this_year ) );
					echo '</li>';
				}
				if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 2, $class, $this_year ) ) != "" ) {
					echo '<li><span>Discussants:&nbsp;</span>';
					echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 2, $class, $this_year ) );
					echo '</li>';
				}
				if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 4, $class, $this_year ) ) != "" ) {
					echo '<li><span>In-Cathlabo Commentators:&nbsp;</span>';
					echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 4, $class, $this_year ) );
					echo '</li>';
				}
				echo '</ul></div><div id="collapse' . $sessionNo . ' class=" panel-collapse collapse ">';
				echo '<div class="panel-footer "><ul class="list-inline "><li><span>Content:&nbsp;</span>';
				echo _Q( $rows[ $sessionNo - 1 ][ 'description' ] );
				echo '</li></ul></div><div class="panel-footer "><ul class="list-inline "><li><span>Co-sponsors:&nbsp;</span>';
				echo _Q( $rows[ $sessionNo - 1 ][ 'cosponsor' ] );
				echo '</li></ul></div></div></div>';
			}
			?>


			<?php $sessionNo = 5; ?>
			<div class="panel-group border-luncheon ">
				<div class="panel panel-warning ">
					<div class="panel-heading ">
						<ul class="list-inline ">
							<li>
								<a data-toggle="collapse " href="#<?='collapse' .$sessionNo ?>"><button type="submit" class="detail">詳細</button>
			</a>
							</li>
							<li class="bold18">
								<?= _Q(mb_substr($rows[$sessionNo - 1]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[$sessionNo - 1]['begin']) + $rows[$sessionNo - 1]['duration']*60); ?>
							</li>
							<li class="bold18">
								&nbsp;&nbsp;
								<?=_Q($rows[$sessionNo - 1]['sessionTitle']); ?>::&nbsp;
								<?= _Q($rows[$sessionNo - 1]['lectureTitle']); ?>
							</li>
						</ul>
					</div>
					<div class="panel-body">
						<ul class="list-inline">
							<?php
							if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 1, $class, $this_year ) ) != "" ) {
								echo "<li><span>&nbsp;Chair:&nbsp;</span>";
								echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 1, $class, $this_year ) );
								echo "</li>";
							}
							if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 3, $class, $this_year ) ) != "" ) {
								echo "<li><span>Speaker:&nbsp;</span>";
								echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 3, $class, $this_year ) );
								echo "</li>";
							}
							if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 2, $class, $this_year ) ) != "" ) {
								echo "<li><span>Discussants:&nbsp;</span>";
								echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 2, $class, $this_year ) );
								echo "</li>";
							}
							if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 4, $class, $this_year ) ) != "" ) {
								echo "<li><span>In-Cathlabo Commentators:&nbsp;</span>";
								echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 4, $class, $this_year ) );
								echo "</li>";
							}
							?>
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


			<?php
			for ( $sessionNo = 6; $sessionNo < 14; $sessionNo++ ) {
				echo '<div class="panel-group border-thick">';

				if ( mb_strpos( $rows[ $sessionNo - 1 ][ 'sessionTitle' ], "裏ライブ", 0, "UTF-8" ) !== false ) {
					echo '<div class="panel panel-primary">';
				} else {
					echo '<div class="panel panel-info">';
				}

				echo '<div class="panel-heading"><ul class="list-inline">';
				echo '<li><a data-toggle="collapse" href="#collapse ' . $sessionNo . '">';
				echo '<button type="submit" class="btn btn-sm btn-success">詳細</button>';
				echo '</a></li><li class="bold18">';
				echo _Q( mb_substr( $rows[ $sessionNo - 1 ][ 'begin' ], 0, 5 ) );
				echo '&nbsp;-&nbsp;';
				echo date( "H:i", strtotime( $rows[ $sessionNo - 1 ][ 'begin' ] ) + $rows[ $sessionNo - 1 ][ 'duration' ] * 60 );
				echo '</li><li class="bold18">&nbsp;&nbsp;';
				echo _Q( $rows[ $sessionNo - 1 ][ 'sessionTitle' ] );
				echo '--';
				echo _Q( $rows[ $sessionNo - 1 ][ 'lectureTitle' ] );
				echo '</li></ul></div><div class="panel-body"><ul class="list-inline">';
				if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 1, $class, $this_year ) ) != "" ) {
					echo '<li><span>&nbsp;Chair:&nbsp;</span>';
					echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 1, $class, $this_year ) );
					echo '</li>';
				}
				if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 3, $class, $this_year ) ) != "" ) {
					echo '<li><span>Speaker:&nbsp;</span>';
					echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 3, $class, $this_year ) );
					echo '</li>';
				}
				if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 2, $class, $this_year ) ) != "" ) {
					echo '<li><span>Discussants:&nbsp;</span>';
					echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 2, $class, $this_year ) );
					echo '</li>';
				}
				if ( _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 4, $class, $this_year ) ) != "" ) {
					echo '<li><span>In-Cathlabo Commentators:&nbsp;</span>';
					echo _Q( makeCommonSessionListTRIJ( $pdo, $sessionNo, 4, $class, $this_year ) );
					echo '</li>';
				}
				echo '</ul></div><div id="collapse' . $sessionNo . ' class=" panel-collapse collapse ">';
				echo '<div class="panel-footer "><ul class="list-inline "><li><span>Content:&nbsp;</span>';
				echo _Q( $rows[ $sessionNo - 1 ][ 'description' ] );
				echo '</li></ul></div><div class="panel-footer "><ul class="list-inline "><li><span>Co-sponsors:&nbsp;</span>';
				echo _Q( $rows[ $sessionNo - 1 ][ 'cosponsor' ] );
				echo '</li></ul></div></div></div>';
			}
			?>


			<hr>
			<footer>
				<p>&copy; 2013 - 2018 by NPO International TRI Network & KAMAKURA LIVE</p>
			</footer>
		</div>
		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
		<script>
			if ( !window.jQuery ) {
				document.write( '<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/bootstrap.min.js"><\/script>' );
			}
		</script>
</body>

</html>