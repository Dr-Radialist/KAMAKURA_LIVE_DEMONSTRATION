<?php
	session_start();
	session_regenerate_id(true);
	require_once('../../utilities/config.php');
	require_once('../../utilities/lib.php');
	charSetUTF8();
	
?>	

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>鎌倉ライブ2018</title>
	<link rel="stylesheet" type="text/css" href="../../bootstrap-3.3.6/dist/css/bootstrap.min.css">
    <title>KAMAKURA Live</title>

</head>

<body>
	<div class="container">
		<div class="row col-md-10 text-center">
			<div style="font: 12px bold; padding: 1px; color: red;">
				<?php
				foreach ( $rows as $row ) {
					echo "doctor ID:" . $row[ 'dr_tbl_id' ] . "処理済み　";
					$stmt = $pdo->prepare( "UPDATE `doctor_tbls` SET `on2018` = '1' WHERE `id` = :id;" );
					$stmt->bindValue( ":id", $row[ 'dr_tbl_id' ], PDO::PARAM_INT );
					$stmt->execute();
				}

				echo "  Done!";
				?>
			</div><br>
			<button class="btn btn-lg btn-primary" onClick="location.href='../index-mod.php'">戻る</button>

			<footer>
				<p>&copy; 2013 - 2018 by NPO International TRI Network & KAMAKURA LIVE</p>
			</footer>
		</div>
	</div>

	<script src="../../bootstrap/docs-assets/javascript/jquery-3.2.0.min.js"></script>

	<script src="../../js/jquery-2.2.4.min.js"></script>
	<!--  jqueryは二度呼びしないとdropdown menuが作動しない!! -->
	<script src="../../bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../../25th/index2018.js"></script>
</body>

</html>