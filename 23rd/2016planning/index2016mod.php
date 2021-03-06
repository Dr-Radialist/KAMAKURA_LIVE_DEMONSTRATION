﻿<?php
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
	
	$stmt_come = $pdo->prepare("SELECT MAX(`changed`) FROM `session_tbls`;");
	$stmt_come->execute();
	$row_come = $stmt_come->fetch(PDO::FETCH_ASSOC);
	$stmt_tri = $pdo->prepare("SELECT MAX(`changed`) FROM `tri_session_tbls`;");
	$stmt_tri->execute();
	$row_tri = $stmt_tri->fetch(PDO::FETCH_ASSOC);
	$stmt_evt = $pdo->prepare("SELECT MAX(`changed`) FROM `evt_session_tbls`;");
	$stmt_evt->execute();
	$row_evt = $stmt_evt->fetch(PDO::FETCH_ASSOC);
	$latest = max($row_evt['MAX(`changed`)'], $row_come['MAX(`changed`)'], $row_tri['MAX(`changed`)']); 
		
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
</head>
<!-- <body onLoad="init();"> -->
<body onLoad="init();">
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation"  style="padding-top:5px;">
  <div class="masthead">
    <ul class="nav nav-pills">
      <li class="dropdown"> <a href="#" class="dropdown-toggle white" data-toggle="dropdown">LIVE2016<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#pci1">TRIライブ一日目</a></li>
          <li><a href="#pci2">TRIライブ二日目</a></li>
          <li><a href="#evt">SFA-EVTビデオライブ</a></li>
          <li><a href="#come">コメディカル・セッション</a></li>
          <li><a href="#" id="self">Venue (開催場所)</a></li>
          <li><a href="#" id="">Session Schedule (開催スケジュール)</a></li>
          <li class="divider"></li>
          <li class="dropdown-header red bold">Detail</li>
          　
          <li><a href="../../22nd/introduction2015.html">Introduction</a></li>
          <li><a href="../../22nd/program_detail/interesting2015.html">What's interesting?</a></li>
          <li><a href="#" class="2015plan">Program at a glance</a></li>
          <li><a href="../dr_registration.php">Faculty</a></li>
          <li><a href="#" id="">???</a></li>
        </ul>
      </li>
      <li class="dropdown"> <a href="#" class="dropdown-toggle white" data-toggle="dropdown">Past Meetings<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="../../22nd/index.html">KAMAKURA LIVE 2015</a></li>
          <li><a href="../../21st/index21.php">KAMAKURA LIVE 2014</a></li>
          <li><a href="../../20th/index.html">KAMAKURA LIVE 2013</a></li>
          <li><a href="../../19th/index2012.pdf">KAMAKURA LIVE 2012</a></li>
          <li><a href="../../18th/18thTop.html">KAMAKURA LIVE 2011</a></li>
          <li><a href="../../17th/index.html">KAMAKURA LIVE 2010</a></li>
          <li><a href="../../16th/index.html">KAMAKURA LIVE 2009</a></li>
          <li><a href="../../15th/index2008.html">KAMAKURA LIVE 2008</a></li>
          <li><a href="../../14th/14th_index.html">KAMAKURA LIVE 2007</a></li>
          <li><a href="../../13th/13thmain.html">KAMAKURA LIVE 2006</a></li>
          <li><a href="../../12th/12thmain.html" id="12th">KAMAKURA LIVE 2005</a></li>
          <li><a href="../../TRC/Xian.html">City Wall in Xi'an</a></li>
        </ul>
      </li>
      <li class="dropdown"> <a href="#" class="dropdown-toggle white" data-toggle="dropdown">Our Activities<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="http://www.tri-international.org/" id="npo" target="_blank">特定非営利活動法人ティー・アール・アイ国際ネットワーク</a></li>
          <li><a href="http://www.kamakuralive.net/" id="live" target="_blank">鎌倉ライブデモンストレーション</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
  
  <!-- Modal -->
  <div class="modal fade" id="midokoroModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="閉じる"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title red">鎌倉ライブ2016: 見どころ</h3>
        </div>
        <div class="modal-body" style="background-color: #F9F279;">
          <p style="font-weight:bold; color:purple; font-size:large;"> 齋藤　滋の独り言<br>
          </p>
          <ol>
            <li>日本TRI 20周年</li>
            <p>どこまでTRIが進化したか?</p>
            <li>齋藤　滋がPCIを始めて 35年間経過</li>
            <p>老体のグルが何処までできるか?</p>
            <li>化石のような術者による化石のようなPCIにどれだけのファンが集まるか?</li>
            <p>まずい　これで最後か???</p>
            <li>とは言っても今年は力を振り絞り頑張りましょう</li>
            <p>皆さんご支援宜しくお願いします。</p>
          </ol>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> --> 
        </div>
      </div>
    </div>
  </div>
    <span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時: <?= $latest ?></span>


<div class="container"> 
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-4">
    <div style="height: 140px;">
      <h2 class="text-danger">HAMAGIN Hall</h2>
      <p class="text-info">ここでは経橈骨動脈的冠動脈インターベンション(TRI)のみ</p>
      <p class="text-danger">Here, live demonstration is held only focusing on transradial coronary intervention (TRI).</p>
     </div>
     <form name="session_id" method="post" action="db_entry/tri/tri01.php"> 
      <table id="pci1">
      <tr><td class="tt-time" style="height:120px;">7:00 - 8:30</td>
      <td class="tt-header" colspan="2" >12月17日(土)<br>
        YOKOHAMA BAYSIDE WALKING & RUN</td></tr>
      <tr><td class="tt-time" style="height:80px;">8:30 - 9:30</td><td class="tt-header" colspan="2">Registration</td></tr>
      <tr><td class="tt-time" style="height: 80px;">9:30 - 10:30</td>
      <td class="tt-content" rowspan="5">
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">12月17日(土)<br>
                <br>FFR/OCT<br><br>(BRS)</button></td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="02">Live1</button></td></tr>
      <tr><td style="height:20px"><br></td><td class="tt-content">
      <button type="submit" name="sessionNo" class="tt-contentc btn_mini solid" value="03">Lecture</button></td></tr>
      <tr><td class="tt-time" style="height: 80px;">10:45 - 11:45</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="04">Live2</button></td></tr>
      <tr><td style="height:20px;"><br></td><td class="tt-content">
      <button type="submit" name="sessionNo" class="tt-contentc btn_mini solid" value="05">Lecture</button></td></tr>
      <tr><td class="tt-time" style="height: 80px;">12:00 - 13:00</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="06">Live3</button></td></tr>
      <tr><td class="tt-time" style="height: 80px;">13:00 - 14:00</td><td class="tt-content" colspan="2">
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="07">Luncheon Seminar</button></td></tr>
      <tr><td class="tt-time" style="height: 80px;">14:00 - 15:00</td>
      <td class="tt-content" rowspan="5">
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="08">12月17日(土)<br>
                <br>Use of<br><br>Slender<br><br>System</button></td>
      <td class="tt-content">
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="09">Live4</button></td></tr>
      <tr><td style="height:20px;"><br></td>
      <td class="tt-content">
      <button type="submit" name="sessionNo" class="tt-contentc btn_mini solid" value="10">Lecture</button></td></tr>
      <tr><td class="tt-time" style="height: 80px;">15:15 - 16:15</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="11">Live5</button></td></tr>
      <tr><td style="height:20px;"></td>
      <td class="tt-content">
      <button type="submit" name="sessionNo" class="tt-contentc btn_mini solid" value="12">Lecture</button><br></td></tr>
      <tr><td class="tt-time" style="height: 80px;">16:30 - 17:30</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="13">Live6</button></td></tr>
      <tr><td class="tt-time" style="height:80px;">17:30 - 18:30</td><td colspan="2"><br></td></tr>
      <tr><td class="tt-time" style="height:160px;">18:30 - 20:30</td><td class="tt-header" colspan="2" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">Welcome Party</button></td></tr>
      </table>
      </form>
      <div style="height:2em;"><br></div>
      <form name="session_id" method="post" action="db_entry/tri/tri01.php">
      <table id="pci2">
      <tr><td class="tt-time" style="height:120px;">7:00 - 8:30</td>
      <td class="tt-header" colspan="2" >12月18日(日)<br>
        YOKOHAMA BAYSIDE WALKING & RUN</td></tr>
      <tr><td class="tt-time" style="height:40px;">8:30 - 9:00</td><td class="tt-header" colspan="2">Registration</td></tr>
      <tr>
        <td class="tt-time" style="height: 80px;">9:00 - 10:00</td>
      <td class="tt-content" rowspan="5">
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="14">12月18日(日)<br><br> CTO<br><br>by TRI</button></td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="15">Live7</button></td></tr>
      <tr><td style="height:20px;"><br></td><td class="tt-content">
      <button type="submit" name="sessionNo" class="tt-contentc full btn_mini solid" value="16">Lecture</button></td></tr>
      <tr>
        <td class="tt-time" style="height: 80px;">10:15 - 11:15</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="17">Live8</button></td></tr>
      <tr><td style="height:20px;"><br></td>
      <td class="tt-content">
      <button type="submit" name="sessionNo" class="tt-contentc full btn_mini solid" value="18">Lecture</button></td></tr>
      <tr>
        <td class="tt-time" style="height: 80px;">11:30 - 12:30</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="19">Live9</button></td></tr>
      <tr>
        <td class="tt-time" style="height: 80px;">12:30 - 13:30</td>
        <td class="tt-content" colspan="2">
        <button type="submit" name="sessionNo" class="tt-contentc btn solid" value="20">Luncheon Seminar</button></td></tr>
      <tr>
        <td class="tt-time" style="height: 80px;">13:30 - 14:30</td>
      <td class="tt-content" rowspan="5">
      <button type="submit" name="sessionNo" class="tt-contentc btn solid" value="21">12月18日(日)<br><br>
       Bifurcation<br><br>(and DCA)</button></td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc btn solid" value="22">Live10</button></td></tr>
      <tr><td style="height:20px;"><br></td>
      <td class="tt-content">
      <button type="submit" name="sessionNo" class="tt-contentc  btn_mini solid" value="23">Lecture</button></td></tr>
      <tr>
        <td class="tt-time" style="height: 80px;">14:45 - 15:45</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc btn solid" value="24">Live11</button></td></tr>
      <tr><td style="height:20px;"><br></td>
      <td class="tt-content">
      <button type="submit" name="sessionNo" class="tt-contentc btn_mini solid" value="25">Lecture</button></td></tr>
      <tr>
        <td class="tt-time" style="height: 80px;">16:00 - 17:00</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc btn solid" value="26">Live12</button></td></tr>
      <tr>
        <td class="tt-time" style="height:80px;">17:00 - 18:30</td>
        <td colspan="2">Adjourn</td></tr>
      </table>
      </form>
    </div>
    <div class="col-md-4">
    <div style="height: 140px;">
      <h2 class="text-danger">NISSEKI Hall</h2>
      <p class="text-muted">ここでは、血管内治療(EVT)ビデオライブと、日曜日コメディカル・セッション</p>
      <p class="text-warning">Here, EVT video live is held on Sunday, and Co-Medical session on Sunday.</p>
      </div>
      <form name="session_id" method="post" action="db_entry/evt/evt01.php">
      <table id="evt">
      <tr><td class="tt-timeb" style="height:120px;">7:00 - 8:30</td>
      <td class="tt-header" colspan="2" >12月17日(土)<br>
        YOKOHAMA BAYSIDE WALKING & RUN</td></tr>
      <tr><td class="tt-timeb" style="height:120px;">8:30 - 10:00</td><td class="tt-header" colspan="2">Registration</td></tr>
      <tr>
        <td class="tt-timeb" style="height: 80px;">10:00 - 11:00</td>
      <td class="tt-content" rowspan="3">
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">12月17日(土)<br>
      <br>EVT for <br><br>SFA-CTO</button></td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">Video<br>of EVT<br>for CTO<br>1</button></td></tr>
      <tr>
        <td class="tt-timeb" style="height: 80px;">11:00 - 12:00</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">Video<br>of EVT<br>for CTO<br>2</button></td></tr>
      <tr><td class="tt-timeb" style="height: 80px;">12:00 - 13:00</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">Video<br>of EVT<br>for CTO<br>3</button></td></tr>
      <tr><td class="tt-timeb" style="height: 80px;">13:00 - 14:00</td><td class="tt-content" colspan="2">
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">Luncheon Seminar</button></td></tr>
      <tr><td class="tt-timeb" style="height: 80px;">14:00 - 15:00</td>
      <td class="tt-content" rowspan="3">
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">12月17日(土)<br>
        <br>EVT for<br><br>SFA-CTO</button></td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">Video<br>of EVT<br>for CTO<br>4</button></td></tr>
      <tr>
        <td class="tt-timeb" style="height: 80px;">15:00 - 16:00</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">Video<br>of EVT<br>for CTO<br>5</button></td></tr>
      <tr>
        <td class="tt-timeb" style="height: 80px;">16:00- 17:00</td>
      <td class="tt-content" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">Video<br>of EVT<br>for CTO<br>6</button></td></tr>
      <tr>
        <td class="tt-timeb" style="height:120px;">17:00 - 18:30</td><td colspan="2"><br></td></tr>
      <tr><td class="tt-timeb" style="height:160px;">18:30 - 20:30</td><td class="tt-header" colspan="2" >
      <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">Welcome Party</button></td></tr>
      </table>
      </form>
      
      <div style="height:2em;"><br></div>
      <form name="session_id" method="post" action="db_entry/comedical_sessions/comedical01.php"> 
      <table id="come">
      <tr><td class="tt-timeb" style="height:120px;">7:00 - 8:30</td>
      <td class="tt-header" colspan="2" >12月18日(日)<br>
        YOKOHAMA BAYSIDE WALKING & RUN</td></tr>
      <tr><td class="tt-timeb" style="height:4em;">8:30 - 9:00</td><td class="tt-header" colspan="2">Registration</td></tr>
      <tr>
            <td class="tt-timeb" style="height: 80px;">09:00 - 10:00</td>
            <td class="tt-contentc">
            <button type="submit" name="sessionNo" class="tt-contentc full btn solid" value="01">教育講演<br>座長: 挽地、時津</button></td>
            <td class="tt-contenttopic" >
            <button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="02">ここまで分かった<br>TRIの真実(吉町)</button><br>
            <button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="03">プロジェクト<br>TAVI(蒔田)</button></td>
        </tr> 
      <tr>
       <td class="tt-timeb" style="height: 160px;">10:00 - 12:00</td>
            <td class="tt-contentc"><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="04">
            Battle Talk<br>Youは何しに横浜に?<br>座長: 島袋、遠山、<br>竹下、羽田</button></td>
            <td class="tt-contenttopic" ><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="05">誰がするの?<br>生活習慣指導</button>
            <br><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="06">ゆとりですが何?</button>
            <br><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="07">緊急時における<br>スタッフの役割</button></td></tr>
        <tr><td class="tt-timeb" style="height: 80px;">12:00 - 13:00</td>
        <td class="tt-content" colspan="2"><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="08">
        Luncheon Seminar<br>「ツーリスト心電図セミナー」<br>座長:泉川、講師:高橋</button></td></tr>
      <tr>
        <td class="tt-timeb" style="height: 120px;">13:00 - 14:30</td>
      <td class="tt-contentc"><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="09">
      一枚の写真<br>座長: 舛谷、進、山本</button></td>
            <td class="tt-contenttopic" ><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="10">公募<br>(発表時間3分)</button></td></tr>
      <tr>
        <td class="tt-timeb" style="height: 40px;">14:30 - 15:00</td>
      <td class="tt-contentc"><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="11">ポスター<br>進行: 高川、泉川</button></td>
        <td class="tt-contenttopic" ><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="12">公募</button></td></tr>
        <tr>
        <td class="tt-timeb" style="height: 40px;">15:00 - 16:00</td>
      <td class="tt-contentc"><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="13">
      腕自慢-あなたの<br>施設のTRI<br>座長: 松陰、道下、竹谷</button></td>
        <td class="tt-contenttopic" ><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="14">
        5題公募<br>(発表時間各8分 )</button></td></tr>
      <tr>
        <td class="tt-timeb" style="height:80px;">16:00 - 16:30</td>
        <td class="tt-header" colspan="2"><button type="submit" name="sessionNo" class="tt-contenttopic btn solid" value="15">優秀ポスター発表<br>遠山、中津</button></td></tr>
        </table>
      </form>
     </div>
    <div class="col-md-4">
    <p></p>
      <p class="text-info"><a class="btn btn-success" role="button" id="openMidokoro">今年の見どころ　見てね! &raquo;<br>12月17日(土)/18日((日)</a></p>
      <p class="text-danger">クリスマス直前の横浜港は、美しいイルミネーションで飾られます。是非ご参加下さい! </p>
   <p align="left"><a class="btn btn-p btn-lg" role="button" href="#f">各セミナーご案内　&raquo; <br>
   <span class="small">EVT Session、ランチョン・セミナー</span>、<br><span class="small">イブニング・セミナーのご案内です</span></a> </p>
      <p><a class="btn btn-primary btn-lg" href="#">Program  at a glance　&raquo;</a></p>
      <p><a class="btn btn-p btn-lg 2015komekome" role="button" href="../comecome2016/2016comecome.pdf">コメコメ演題募集中!!　&raquo;</a></p>
      <p><a class="btn btn-re" role="button" href="../comecome2016/2016comecome.pdf">コメコメ皆さんに配布を!!　&raquo;</a></p>
      <p><a class="btn btn-success" role="button" href="http://www.yokohama-viamare.or.jp/access.html">開催場所（はまぎんホール） &raquo;</a></p>
      <p><a class="btn btn-info 2015placeNisseki" href="http://www.nybldg.jp/access/index.html" role="button">開催場所（日石横浜ホール） &raquo;</a></p>
      <h2 class="text-danger">LIVE 2017 (Next Year)</h2>
      <p class="text-danger">Next year in 2017, KAMAKURA Live Demonstration Course will be held on December 16th (Saturday) and 17h (Sunday) in YOKOHAMA. </p>
      <h2 class="text-danger">ライブ2017 (来年)</h2>
      <p class="text-danger">2017年の鎌倉ライブデモンストレーションは12月16日(土)そして17日(日)に横浜で開催されます。</p>
    </div>
  </div>
  <hr>
  <footer>
    <p>&copy;  2013 - 2016 by NPO International TRI Network & KAMAKURA LIVE</p><p><a class="btn btn-p btn-sm" role="button" href="../../index2015.html">&raquo; <br></a> </p>
  </footer>
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

</body>
</html>
