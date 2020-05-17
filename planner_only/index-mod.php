<?php
session_start();
session_regenerate_id( true );
require_once( '../utilities/config.php' );
require_once( '../utilities/lib.php' );
charSetUTF8();
//header('Location: ../26th/index_basic.php');	//何故かこれでコピーページに飛ばさないと javascriptや cssが働かない
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
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2019`;" );
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
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../favicon.ico">
	<title>鎌倉ライブ2019</title>

	<link rel="stylesheet" type="text/css" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../26th/2018top_main.css">
	<style>
a.pay {
			-webkit-animation: blink 1.0s ease-in-out infinite alternate;
			-moz-animation: blink 1.0s ease-in-out infinite alternate;
			animation: blink 1.0s ease-in-out infinite alternate;
			color: white;
			font-weight: bold;
		}
		/*
		@-webkit-keyframes blink {
			0% {
				opacity: 0;
			}
			100% {
				opacity: 1;
			}
		}
		
		@-moz-keyframes blink {
			0% {
				opacity: 0;
			}
			100% {
				opacity: 1;
			}
		}
		
		@keyframes blink {
			0% {
				opacity: 0;
			}
			100% {
				opacity: 1;
			}
		}
		*/
		
		@-webkit-keyframes blink {
			0% {
				background-color: #039E07;
			}
			10% {
				background-color: #FDE8A1;
			}
			100% {
				background-color: red;
			}
		}
	}
	@-moz-keyframes blink {
		0% {
			background-color: #039E07;
		}
		
		10% {
			background-color: #FDE8A1;
		}
		
		100% {
			background-color: red;
		}
	}
	@keyframes blink {
		0% {
			background-color: #039E07;
		}
		
		10% {
			background-color: #FDE8A1;
		}
		
		100% {
			background-color: red;
		}
	}
}
	</style>
</head>

<body>
	<div class="container">
		<div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
			<div class="masthead">
				<ul class="nav nav-pills">
					<li class="dropdown col-xs-2 text-center"> <a href="#" class="dropdown-toggle li-white" data-toggle="dropdown"><span class="glyphicon glyphicon-home navigation_icon"></span></a>

						<ul class="dropdown-menu">
							<!--
							<li><a href="26th/db_read/tri_session_all_read.php">TRIライブ一日目</a>
							</li>
							<li><a href="26th/2019FinalPDFProgram/2019welcome_party.pdf">Welcome Party</a>
							</li>
							<li><a href="26th/db_read/tri_session_all_read.php#day2">TRIライブ二日目</a>
							</li>
							<li><a href="26th/db_read/zagaku_all_read.php">インタベ座学</a>
							</li>
							<li><a href="26th/db_read/come_session_all_read.php">コメディカル・セッション</a>
							</li>
							-->
							<li><a href="#">TRIライブ一日目</a>
							</li>
							<li><a href="#">Welcome Party</a>
							</li>
							<li><a href="#">TRIライブ二日目</a>
							</li>
							<li><a href="#">インタベ座学</a>
							</li>
							<li><a href="../26th/db_read/com_session_all_read_renewed.php">コメディカル・セッション</a>
							</li>
							<li class="divider"></li>
							<p class="dropdown-header">詳細</p>
							<li class="divider"></li>
							<li><a href="../26th/2019planning/introduction2019.html">Introduction</a>
							</li>
							<li><a href="../26th/dr_role_find.php">Find My Role <i class="glyphicon glyphicon-search"></i></a>
							</li>
							<li><a href="../26th/comecome2019/2019comecome .pdf">コメコメ演題募集</a>
							</li>
							<li><a class="btn btn-primary" role="button" id="openProgram">このページ</a>
							</li>
						</ul>
					</li>
					<li class="dropdown col-xs-2 text-center"><a href="#" class="dropdown-toggle li-white" data-toggle="dropdown"><span class="glyphicon glyphicon-calendar navigation_icon"></span></a>
						<ul class="dropdown-menu">
							<li><a href="../26th/dr_registration.php?member_kind=4">日本国内招聘Faculty</a>
							</li>
							<li><a href="../26th/dr_registration.php?member_kind=3">Foreign Invited Faculty</a>
							</li>
							<li><a href="../26th/dr_registration.php?member_kind=6">Sd Faculty</a>
							</li>
							<li><a href="../26th/dr_registration.php?member_kind=5">親善参加</a>
							</li>
							<li><a href="../26th/dr_registration.php?member_kind=1">NPO社員</a>
							</li>
						</ul>
					</li>
					<li class="dropdown col-xs-2 text-center"><a href="#" class="dropdown-toggle li-white" data-toggle="dropdown"><span class="glyphicon glyphicon-exclamation-sign navigation_icon"></span></a>
						<ul class="dropdown-menu">
							<p>&nbsp;Information</p>
							<li class="divider"></li>
							<li><a href="#">TRI Session-1 Overview</a>
							</li>
							<li><a href="#">TRI Session-2 Overview</a>
							</li>
							<li><a href="#">ZAGAKU Overview</a>
							</li>
							<li><a href="#">Comedical Session Overview</a>
							</li>
						</ul>
					</li>
					<li class="dropdown col-xs-2 text-center"><a href="#" class="dropdown-toggle li-white" data-toggle="dropdown"><span class="glyphicon glyphicon-search navigation_icon"></span></a>
						<ul class="dropdown-menu dropdown-menu-right">
							<p>&nbsp;Find your role!</p>
							<li><a class="btn-warning btn-lg" role="button" href="../26th/dr_role_find.php">Find My Role! <i class="glyphicon glyphicon-search"></i></a>
							</li>
						</ul>
					</li>
					<li class="dropdown col-xs-2 text-center"><a href="#" class="dropdown-toggle li-white" data-toggle="dropdown"><span class="glyphicon glyphicon-user navigation_icon"></span></a>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="http://www.yokohama-viamare.or.jp/access.html">はまぎんホール</a>
							</li>
							<li><a href="http://www.nybldg.jp/access/index.html">日石ホール</a>
							</li>
							<li><a href="file:///Macintosh HD/Users/transradial/サイト/TRC/Xian.html">City Wall in Xi'an</a>
							</li>
							<li><a class="btn btn-danger openProgram" role="button">このホームページについて</a>
								<li><a class="btn btn-danger openProgramE" role="button">This Page</a>
								</li>
						</ul>
						</li>
						<li class="dropdown col-xs-1 text-center"><a href="https://conv.toptour.co.jp/shop/evt/KamakuraLive_2019/" class="li-white"><span class="glyphicon glyphicon-yen navigation_icon"></span></a>
						</li>
				</ul>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="midokoroModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="閉じる"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title red">鎌倉ライブ2019: 見どころ</h3>
				</div>
				<div class="modal-body" style="background-color: #DBD584;">
					<p style="font-weight:bold; color:purple; font-size:large;"> 齋藤　滋の独り言<br>
					</p>
					<ol>
						<li>日本でTRIが開始されたのは、1996年のことでした。従って日本にTRIが開花してから 既に22年が経過しました</li>
						<p>この間にどこまでTRIが進化したか?</p>
						<li>齋藤　滋がPCIを始めて 36年間経過</li>
						<p>老体のグルが何処までできるか?</p>
						<li>化石のような術者による化石のようなPCIにどれだけのファンが集まるか?</li>
						<p>まずい　これで最後か???</p>
						<li>とは言っても今年もTAVIやその他のSHDインターションに対しても、現役で前に進んでいます。今回もTRIについて力を振り絞り頑張りましょう</li>
						<li>また、今年はTRIの新しい潮流である、PPAアプローチも皆様方は知ることになると思います。</li>
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
	<!-- Modal -->
	<div class="modal fade" id="progrmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="閉じる"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title red">このホームページについて</h3>
				</div>
				<div class="modal-body" style="background-color: #71F764;">
					<p style="font-weight:bold; color:purple; font-size:large;">齋藤　滋がNPO社員の協力を得て、ゼロから書き上げた壮大なプログラミングの結果がこのページです　ここに至る出だしは、2015年11月12日にCVIT九州沖縄地方会で私が行った講演「私は今、JSに燃えています」にあります　この時私はJS (= JavaScript)を用いたプログラミングの楽しさ、重要性を皆に説いたつもりです<br>
					</p>
					<ol>
						<li>プログラム骨子</li>
						<p>このページは <a href="http://e-words.jp/w/Web.html">Web</a>を支える主要技術要素である<a href="http://www.html5.jp/"> HTML5</a>、<a href="http://www.htmq.com/css3/">CSS3</a>、<a href="https://ja.wikipedia.org/wiki/JavaScript">JavaScript</a>、<a href="https://ja.wikipedia.org/wiki/SQL">SQL</a>を用いて書かれています</p>
						<li>プログラミングを効率化するためのフレームワーク</li>
						<p><a href="https://ja.wikipedia.org/wiki/%E3%83%AC%E3%82%B9%E3%83%9D%E3%83%B3%E3%82%B7%E3%83%96%E3%82%A6%E3%82%A7%E3%83%96%E3%83%87%E3%82%B6%E3%82%A4%E3%83%B3">Responsive Web Design</a>を実現するためには定番である Twitter社が開発し、無償で公開している<a href="http://getbootstrap.com/">Twitter Bootstrap</a>および、<a href="https://ja.wikipedia.org/wiki/Document_Object_Model">DOM</a>を動的に書き換えることにより、動きのあるベージを作成するには不可欠な定番ライブラリーである <a href="https://jquery.com/">jQuery</a>を用いています</p>
						<li>サーバー側の技術要素</li>
						<p>サーバーは <a href="https://httpd.apache.org/">Apache Webserver</a>が用いられ、SQLエンジンとしては<a href="https://www-jp.mysql.com/">MySQL</a>、そしてスクリプト・エンジンとしては <a href="https://secure.php.net/">PHP</a>を用いています　いわゆる <a href="http://e-words.jp/w/LAMP.html">LAMP </a>(Linux + Apache + MySQL + PHP)とも称される組み合わせです</p>
						<li>開発環境</li>
						<p>MacBook Proの中に、<a href="https://www.apachefriends.org/jp/index.html">XAMPP</a>を用いて用いて仮想インターネット環境を作成し、この上で、<a href="http://www.adobe.com/jp/products/dreamweaver.html">Dreamweaver</a>を用いてゼロから書き上げています　そのプログラム・ステップ数は優に数万行に達しています　テストはこの仮想環境の中で各種Browserを用いて行い、あらかたテストに通れば実際の <a href="https://ja.wikipedia.org/wiki/Web%E3%82%B5%E3%83%BC%E3%83%90">Web Server</a>に uploadしています</p>
						<p>実は MacOSが high Sierraに upgradeされてから、security設定が厳しくなり、これまで動作していた XAMPPによる仮想インターネットサーバーを作動させることが困難となりました。これに伴い、XAMPPの使用を停止し、MacBook Proの中に、<a href="https://www.mamp.info/en/">MAMP</a>を用いて用いて仮想インターネットサーバーを用いるように変更しました。</p>
						<li>開発コスト</li>
						<p>このようなプログラムをプロに依頼すれば、恐らく1,000万円単位の請求が発生すると思いますが、私にとっては、プログラミングは過去40年来の趣味であり、知的好奇心と達成感を満足させる自分自身の人生にとって非常に重要なものです　用いている各種ツールやソフトウェアは、インターネット上に無償で公開されているものをダウンロードして使わせて頂いています　これはいわゆる<a href="https://ja.wikipedia.org/wiki/%E3%82%AA%E3%83%BC%E3%83%97%E3%83%B3%E3%82%BD%E3%83%BC%E3%82%B9%E3%82%BD%E3%83%95%E3%83%88%E3%82%A6%E3%82%A7%E3%82%A2">オープンソース</a>を用いているのです　従いまして、Dreamweaverや MacBook Proを別とすれば　実際のコストはゼロです</p>
						<li>開発で困難であった点</li>
						<p>開発を開始したのは、2016年8月10日頃でした　もちろんPCIやTAVIを行いながら、また国内外の出張を行いながら、そしてこれらの間に外来診療を行いながら、空いた時間に行う作業です、そしてしばしば飛行機の中で移動しながらの作業も多く、その結果途中で作業が中断すると共に、自分の思考も中断すること、これが辛いものでした　そして技術的に困難であったのは、やはり <a href="https://ja.wikipedia.org/wiki/Ajax">Ajax通信</a>を用いた部分です　これはデバッグも困難で、ようやく動作するものを書けた時は流石に嬉しかったのです</p>
						<li>プログラム修正履歴管理</li>
						<p>プログラムはバグの存在や、改良・改善のためにどんどん変化していきます。特に Webのためのプログラムは皆の目に触れますので日々変化をしていきます。しかしながら、その変更も時にもとに戻したり、試しに大きく変更したり　そんな行程を繰り返します。これらの変更履歴を管理することはとても大変です。しかし、ここに <a href="https://ja.wikipedia.org/wiki/Git">Git</a>という有名なツールがあります。もちろんこのツールもオープンソースで開発が続けられているのです。このGitを用いて履歴を管理します。そして、僕の場合には 、<a href="https://bitbucket.org/">Bitbucket</a>という無料のサイトでその変更履歴を保存しています。この作業により、万が一僕のマシンが全く破壊されたとしても、cloudより変更履歴を含めて最新のプログラムを回復することが可能となるのです。</p>
						<li>開発していて学んだこと</li>
						<p>実は開発の途中でData Structureを何回か大幅に変更してきました　これはデータに対する要求に自動的に応じることができるように、<a href="https://ja.wikipedia.org/wiki/%E9%96%A2%E4%BF%82%E3%83%87%E3%83%BC%E3%82%BF%E3%83%99%E3%83%BC%E3%82%B9">関係データベース</a>の構造を最適化してきたからです　もちろん未だ完全には最適化できていませんが、まずまずでしょうか　データベース構造を変化させれば、既に入力されたデータを失わないようにデータを安全に移行する必要がありますし、データベースに対する問い合わせ SQL文も変化させねばなりません　この作業を開発中に行うのには細心の注意が必要でした　これらの過程を通じて学んだことは、(1)目標を定めれば実現できる (2)多くの場合問題点は、目標が不明であるということだ (3)従ってまずは目標を明確化せねばならない (4)自分自身常に外部からの要求やデータ構造の変更に柔軟に対応できる姿勢が必要だ などなどの人生の教訓でしょうか　そして今回も開発を通じて Webの最新技術習得に一歩進むことが出来ました</p>
					</ol>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="progrmModalE" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="閉じる"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title red">About This Home Page</h3>
				</div>
				<div class="modal-body" style="background-color: #CCEAF8;">
					<p style="font-weight:bold; color:purple; font-size:large;">This home page is a great creature, which Shigeru SAITO, by himself, has been writing from zero under the cooperation with NPO members. I did a lecture on November 12<sup>th</sup>, 2015 during CVIT (Cardio-Vascular Interventional Therapeutics) meeting. The title of the lecture was "I am now devoting myself to JS.". In that lecture, I showed the significance and fun for JS (= JavaScript) programming.<br>
					</p>
					<ol>
						<li>Main Structure of the program of this page.</li>
						<p>This page is written by using the main elementary technologies in <a href="http://e-words.jp/w/Web.html">Web</a> development. They includes <a href="http://www.html5.jp/"> HTML5</a>, <a href="http://www.htmq.com/css3/">CSS3</a>, <a href="https://ja.wikipedia.org/wiki/JavaScript">JavaScript</a>, and <a href="https://ja.wikipedia.org/wiki/SQL">SQL</a>. </p>
						<li>Frameworks fascilitating programming.</li>
						<p><a href="http://getbootstrap.com/">Twitter Bootstrap</a>, which are being developped by Twitter Corporation and opened for the public, is used to realize <a href="https://ja.wikipedia.org/wiki/%E3%83%AC%E3%82%B9%E3%83%9D%E3%83%B3%E3%82%B7%E3%83%96%E3%82%A6%E3%82%A7%E3%83%96%E3%83%87%E3%82%B6%E3%82%A4%E3%83%B3">Responsive Web Design</a>, and <a href="https://jquery.com/">jQuery</a> is used to introduce a fascinating and moving page through dynamic rewriting <a href="https://ja.wikipedia.org/wiki/Document_Object_Model">DOM.</p>
          <li>Server-side technological elements</li>
          <p>For the web server, <a href="https://httpd.apache.org/">Apache Webserver</a>, for the SQL engine, <a href="https://www-jp.mysql.com/">MySQL</a> and, for the script engine, <a href="https://secure.php.net/">PHP</a> is used. This combination is called <a href="http://e-words.jp/w/LAMP.html">LAMP </a>(Linux + Apache + MySQL + PHP).</p>
						<li>Development environment</li>
						<p><a href="https://www.apachefriends.org/jp/index.html">XAMPP</a> is installed in MacBook Pro to simulate virtual Internet environment. All of the programs are written from zero by using <a href="http://www.adobe.com/jp/products/dreamweaver.html">Dreamweaver</a>. Total program size is exceeding several 10 thousands steps. After passing tests using several types of browsers in this virtual Internet environments, the programs are uploaded to <a href="https://ja.wikipedia.org/wiki/Web%E3%82%B5%E3%83%BC%E3%83%90">Web Server</a>.</p>
						<li>Cost for development</li>
						<p>More than 10 million Japanese yen will be claimed, if we ask for this kind of software. However, computer programming is my hoby, which I have been continueing for the past 40 years. This activity is most important in my life to fulfill my inteligence interests and achievement. I am downloading and using many tools or softwares, which are open to the publin in Internet. This is so called <a href="https://ja.wikipedia.org/wiki/%E3%82%AA%E3%83%BC%E3%83%97%E3%83%B3%E3%82%BD%E3%83%BC%E3%82%B9%E3%82%BD%E3%83%95%E3%83%88%E3%82%A6%E3%82%A7%E3%82%A2">Open Source</a>. Thus, actual cost is zero except Dreamweaver or MacBook Pro.</p>
						<li>Difficulties in development</li>
						<p>I started the development of this home page around August 10<sup>th</sup>, 2016. I continued the development while doing PCI/TAVI, visiting domestic or foreign hospitals, and keeping outpatient clinic. Development has been performed frequently in the airplane. This means the development as well as my logical thinking are stopped frequently. Thsese cessations are painful for me. The most difficult programming was the part using <a href="https://ja.wikipedia.org/wiki/Ajax">Ajax communication</a>. This part was difficult to overcome for myself, since debugging was so difficult. It was really happy time for me, when I finished that part successfully.</p>
						<li>What I have learnt during the development</li>
						<p>I have been changing the Data Sturcutre several times during the develoment to accommodate the several requirements to data automatically. I have changed and optimized the sturucture of <a href="https://ja.wikipedia.org/wiki/%E9%96%A2%E4%BF%82%E3%83%87%E3%83%BC%E3%82%BF%E3%83%99%E3%83%BC%E3%82%B9">Relational Database</a>. Of course its optimization is not yet perfect but acceptable. When we change the data structure, we need very careful attention. We have to transfer the data safely to new database. We have to rewrite SQL command sentences. During this modification process, I have learnt; (1) We can do everything if we see the goal. (2) The difficulty is we cannot see the goal. (3) The most important is we have to clarify the goal. (4) We have to be flexible to accommodate the requirements or modification of data structure issued from the outside environments, and so on. Theses are the principle in my life. ANyway, I could make a forward step to the most advanced technology in Web development.</p>
					</ol>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>


	<div class="container">
		<div id="j-introduction">
			<h5 class="title">2019年12月14日と15日開催<span class="red_bold_sm"> 最終更新:&nbsp;
      <?= $latest ?>
      </span></h5>
			<h3 class="title">鎌倉ライブ2019　プログラム組み立て用管理者ページ</h3>
			<div class="row">
				<div class="col-lg-12">
					<div class="input-group">

						<a class="btn btn-info btn-sm" role="button" href="../26th/2019planning/db_entry/tri/tri_db_input.php">TRI時間割決定</a>
						<a class="btn btn-success btn-sm" role="button" href="../26th/db_read/tri_session_all_read1.php#day1">TRIライブ(14日)</a>
						<a class="btn btn-default btn-sm" href="../26th/db_read/zagaku_all_read.php">インタベ座学確認</a>
						<a class="btn btn-default btn-sm" href="../26th/2019planning/index2019evt_mod-n.php">!!インタベ座学修正!!</a>
						<!-- <a class="btn btn-primary btn-sm" role="button" href="#">Welcome Party</a> -->
						<a class="btn btn-warning btn-sm" role="button" href="../26th/db_read/tri_session_all_read1.php#day2">TRIライブ(15日)</a>
						<a class="btn btn-info btn-sm" role="button" href="../26th/db_read/com_session_all_read_renewed.php">コメコメ確認</a>
						<a class="btn btn-success btn-sm" role="button" href="../26th/2019planning/index2019com_mod-n.php">!!コメコメ修正!!</a>
						<a class="btn btn-danger btn-sm" role="button" href="../26th/2019planning/dr_registration.php">医師・コメ新規登録・修正</a>
						<a class="btn btn-primary btn-sm" role="button" href="../26th/dr_role_find.php">医師・コメ検索</a>
					</div>
				</div>
				<div class="col-lg-10 back-sky-blue">
					<p> このページはBASIC認証により保護されているページであり、会期中の人員配置などを決定するものです:					<img src="../26th/Logo/Logo2018_200.png" width="84" height="71" class="right_float"/>
					</p>
				  <p><button class="btn btn-sm btn-warning right_float" onClick="location.href = '../index.php'">一般に戻る</button></p>
					<ol>

						<li>TRIセッション&nbsp;&nbsp;<a class="btn btn-success btn-sm" role="button" href="../26th/2019planning/index2019tri_mod-n.php">TRI Live座長・演者等割当</a> &nbsp;
						</li>
						<li>インターベンション座学&nbsp;&nbsp;<a class="btn btn-default btn-sm" role="button" href="../26th/db_read/zagaku_all_read.php">インターベンション座学確認(15日)</a>
						</li>
						<li>コメディカル・セッション&nbsp;&nbsp;<a class="btn btn-info btn-sm" role="button" href="../26th/db_read/com_session_all_read_renewed.php">コメディカル・セッション(15日)</a> &nbsp;&nbsp;
							<a class="btn btn-danger btn-lg pay" role="button" href="#">最終プログラム</a>
						</li>
						<li>OCT/FFRトレーニングセンター&nbsp;&nbsp;<a class="btn btn-danger btn-sm" role="button" href="#">OCT/FFRトレーニング・センター (14日、15日)</a>&nbsp;&nbsp;<a class="btn btn-default btn-lg" role="button" href="../26th/db_read/faculty_list.php">登場人物一覧</a>
						</li>
					</ol>
					<p>本HomePageは齋藤　滋自らがプログラミング知識 (HTML, CSS, JavaScript, jQuery, PHP, SQL)を駆使して作り上げているものです</p>
					<p>鎌倉ライブ実行委員会メンバー皆が構想を練り、それを Web上のデータベースに自ら反映してもらい、同時にそれが Web上に公開される、そのようなプログラミングを行っています　不具合がありますればご容赦の上、ご指摘下さい</p>
				</div>
				<div class="col-sm-12">
					<div class="input-group"></div><a class="btn btn-default btn-sm" role="button" href="#">事前登録締切</a> 
					<a class="btn btn-primary btn-sm" role="button" href="../26th/dr_role_find.php">私のお仕事</a> 
					<a class="btn btn-success  btn-sm openMidokoro" role="button">今年の見どころ　見てね! &raquo;</a> 
					<a class="btn btn-danger btn-sm pay" role="button" href="../26th/2019FinalPDFProgram/2019FinalProgram.pdf">最終プログラムPDF</a>
					<a class="btn btn-info btn-sm" role="button" href="../26th/comecome2019/2019comecome.pdf">コメコメ演題受付中</a>
					<a class="btn btn-warning btn-sm" role="button" href="../26th/comecome2019/2019surveillance.pdf">Battle Talkアンケートのお願い</a>
					<a class="btn btn-danger btn-md" role="button" href="faculty_marking.php">お仕事がある方にFacultyの称号授与 (時々押してね) </a>
				</div>
			</div>
		</div>


		<footer>
			<p>&copy; 2013 - 2019 by NPO International TRI Network & KAMAKURA LIVE</p>
		</footer>
	</div>

	<script src="../bootstrap-4.3.1-dist/js/jquery-3.4.1.min.js"></script>
	<script src="../bootstrap-4.3.1-dist/js/popper.min.js"></script>
	<script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
	<script src="../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../26th/index2019.js"></script>		
</body>

</html>