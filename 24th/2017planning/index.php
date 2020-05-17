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

$stmt_dr = $pdo->prepare( "SELECT MAX(`changed`) FROM `doctor_tbls`;" );
$stmt_dr->execute();
$row_dr = $stmt_dr->fetch( PDO::FETCH_ASSOC );
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
$latest = mb_substr( $latest, 0, 10 );

?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../favicon.ico">
	<title>鎌倉ライブ2017</title>
	<link rel="stylesheet" type="text/css" href="../../bootstrap-3.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../2016top_main.css">
</head>

<body>
	<div class="container">
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="masthead">
				<ul class="nav nav-pills">
					<li class="dropdown"> <a href="#" class="dropdown-toggle li-white" data-toggle="dropdown" role="button" aria-expanded="false">Faculty Role割当<b class="caret"></b></a>
						<ul class="dropdown-menu" role="menu">
							<li role="presentation"><a href="index2017tri_mod-n.php">TRIライブRole割当</a>
							</li>
							<li role="presentation"><a href="index2017evt_mod-n.php">インタベ座学Role割当</a>
							</li>
							<li role="presentation"><a href="index2017come_mod-n.php">コメディカル・セッションRole割当</a>
							</li>
						</ul>
					</li>
					<li class="dropdown"> <a href="#" class="dropdown-toggle li-white" data-toggle="dropdown">管理者のコマンド<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="../dr_search.php">名前登録者検索</a>
							</li>
							<li><a href="dr_registration.php">Faculty追加・修正</a>
							</li>
							<li><a href="duplicated_roles.php">Faculty役割時間帯重複検出</a>
							</li>
						</ul>
					</li>
					<li class="dropdown"> <a href="#" class="dropdown-toggle li-white" data-toggle="dropdown">Faculty種別での検索<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="no_role_assigned.php?member_kind=1">NPO社員</a>
							</li>
							<li><a href="no_role_assigned.php?member_kind=1">Role割当数 = 1</a>
							</li>
							<li><a href="no_role_assigned.php?member_kind=2">Role割当数 = 2</a>
							</li>
							<li><a href="no_role_assigned.php?member_kind=3">Role割当数 = 3</a>
							</li>
							<li><a href="no_role_assigned.php?member_kind=4">Role割当数 = 4</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>

	</div>
	<br>
	<br>
	<div class="container">
		<div id="j-introduction">
			<h5 class="title">2017年12月<span class="red_bold_sm"> 最終更新:
    <?= $latest ?>
    </span></h5>
			<h4 class="title">鎌倉ライブ2017 </h4>
			<div class="row">
				<div class="col-lg-12"> <a class="btn btn-success" role="button" href="dr_registration.php">Faculty追加・修正</a> <a class="btn btn-danger" role="button" href="index2017tri_mod-n.php">TRIセッション修正</a> <a class="btn btn-warning" role="button" href="index2017evt_mod-n.php">インタベ座学修正</a> <a class="btn btn-primary" role="button" href="index2017come_mod-n.php">Comeセッション修正</a>
				</div>
				<div class="col-lg-10 back-sky-blue">
					<p> このページは鎌倉ライブデモンストレーションHome Page管理者用のものです:</p>
					<ol>
						<li>TRIセッション</li>
						<li>EVTセッション</li>
						<li>コメディカル・セッション</li>
					</ol>
					<p>このベージの属するDirectoryは BASIC認証で保護されています</p>
				</div>
				<div class="col-sm-12"><a class="btn btn-primary" role="button" href="../dr_role_find.php">お仕事 <i class="glyphicon glyphicon-search"></i></a> <a class="btn btn-success" role="button" href="../administration/tri_roles_overview1.php">Overview TRI-1</a> <a class="btn btn-success" role="button" href="../administration/tri_roles_overview2.php">Overview TRI-2</a> <a class="btn btn-warning" role="button" href="../administration/evt_roles_overview.php">Overview EVT</a> <a class="btn btn-primary" role="button" href="../administration/comedical_roles_overview.php">Overview ComeCome</a>
				</div>
			</div>
			<footer>
				<p>&copy; 2013 - 2017 by NPO International TRI Network & KAMAKURA LIVE</p>
			</footer>
		</div>
	</div>
		
	<script src="../../bootstrap/docs-assets/javascript/jquery-3.2.0.min.js"></script>
	
	<script src="../../js/jquery-2.2.4.min.js"></script> <!--  jqueryは二度呼びしないとdropdown menuが作動しない!! -->
	<script src="../../bootstrap-3.3.6/dist/js/bootstrap.min.js"></script> 
	<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="24th/index2017.js"></script>
</body>

</html>