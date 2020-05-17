<?php
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
						
	$stmt = $pdo->prepare("SELECT MAX(`changed`) FROM `doctor_tbls`;");
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$latest = $row['MAX(`changed`)']; 
	
	$stmt = $pdo->query("SELECT * FROM `doctor_tbls` WHERE `member_kind` = '1';");
	$rows_npo_member1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$stmt = $pdo->query("SELECT * FROM `doctor_tbls` WHERE `member_kind` = '2';");
	$rows_npo_member2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$stmt = $pdo->query("SELECT * FROM `doctor_tbls` WHERE `member_kind` = '3' ORDER BY `english_sirname`;");
	$rows_foreign_faculty = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$stmt = $pdo->query("SELECT * FROM `doctor_tbls` WHERE `member_kind` = '4' ORDER BY `kana_sirname`;");
	$rows_domestic_faculty = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
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

  </head>

  <body>


    <!-- Main jumbotron for a primary marketing message or call to action -->
 <!--   <div class="jumbotron"> -->
 <div class="box">
 <style>
 .box {border:#040EF4 solid 4px; background-color:#DFFAD9;}
  td {color:black; text-align:left; font: 16px bold;}
 </style>
      <div class="container">
        <h2 class="alert-success">KAMAKURA Live Demonstration Course 2016</h2>
      </div>
<!--    </div> -->
</div>
    <div class="container">
      <p class="text-center text-primary small">Last Updated on <?=$latest; ?></p>
      <div class="row">
        <div class="col-md-12">
          <p class="text-center"><a class="btn btn-p btn-lg" role="button" href="../../index2015.html">Return Home　&raquo;</a></p>  
          
          <table class="table table-bordered table-striped table-responsive">
            <caption>International Faculty 2016</caption>
            <thead>
    				<tr>
      				<th class="col-md-3">Name</th><th class="col-md-6">Hospital</th><th class="col-md-3">Nation</th>
    				</tr>
  			</thead>
 			<tbody>
            <?php
				foreach ($rows_foreign_faculty as $row) {
					echo "<tr><td>"._Q($row['english_sirname'])." "._Q($row['english_firstname'])."</td><td>";
					echo _Q($row['hp_name_english'])."</td><td>"._Q($row['nation'])."</td></tr>";
				}
			?>                         
  			</tbody>
		</table>
        
        <h2><br></h2>
        <p class="text-center"><a class="btn btn-p btn-lg" role="button" href="../../index2015.html">Return Home　&raquo;</a></p>  
          
          <table class="table table-bordered table-striped table-responsive">
            <caption>2016年日本国内Faculty</caption>
            <thead>
    				<tr>
      				<th class="col-md-3">Name</th><th class="col-md-6">病院名</th><th class="col-md-3">かな氏名</th>
    				</tr>
  			</thead>
 			<tbody>
            <?php
				foreach ($rows_domestic_faculty as $row) {
					echo "<tr><td>"._Q($row['english_sirname'])." "._Q($row['english_firstname'])."</td><td>";
					echo _Q($row['hp_name_english'])."</td><td>"._Q($row['kana_sirname'])." "._Q($row['kana_firstname'])."</td></tr>";
				}
			?>                         
  			</tbody>
		</table>
		        
        <h2><br></h2>
        <p class="text-center"><a class="btn btn-p btn-lg" role="button" href="../../index2015.html">Return Home　&raquo;</a></p>  
          
          <table class="table table-bordered table-striped table-responsive">
            <caption>当NPO社員名簿</caption>
            <thead>
    				<tr>
      				<th class="col-md-3">Name</th><th class="col-md-6">病院名</th><th class="col-md-3">かな氏名</th>
    				</tr>
  			</thead>
 			<tbody>
            <?php
				foreach ($rows_npo_member1 as $row) {
					echo "<tr><td>"._Q($row['english_sirname'])." "._Q($row['english_firstname'])."</td><td>";
					echo _Q($row['hp_name_english'])."</td><td>"._Q($row['kana_sirname'])." "._Q($row['kana_firstname'])."</td></tr>";
				}
			?>                         
  			</tbody>
		</table>
            
        </div>   
	<p class="text-center"><a class="btn btn-p btn-lg" role="button" href="../../index2015.html">Return Home　&raquo;</a></p>  
      </div>

      <hr>

      <footer>
        <p>&copy;  2013 - 2016 by NPO International TRI Network & KAMAKURA LIVE</p>
      </footer>
    </div> <!-- /container -->


<script src = "https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
<script>
	if (!window.jQuery) {
		document.write('<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/../../bootstrap.min.js"><\/script>');
	}
</script>
<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
<script src="../../bootstrap/docs-assets/javascript/top.js"></script>
<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
  </body>
</html>
