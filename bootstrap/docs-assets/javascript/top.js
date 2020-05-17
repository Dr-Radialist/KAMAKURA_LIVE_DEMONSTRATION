// JavaScript Document
$(function() {
	"use strict";
	$("#2014fee").click(function() {
		location.href = "./21th/Registration-fee-JPN.pdf";
	});
	$("#openMidokoro").click(function() {
		$("#midokoroModal").modal({
        		show: true
    		});
	});
	$("#2015placeHamagin").click(function() {
		location.href = "http://www.yokohama-viamare.or.jp/access.html";
	});
	$(".2015placeNisseki").click(function() {
		location.href = "http://www.nybldg.jp/access/index.html";
	});
	$(".2015plan").click(function() {
		location.href = "22nd/plan2015/plan2015_11_19.pdf";
	});
	$(".home").click(function() {
		location.href = "../index.html";
	});
	$(".home_index").click(function() {
		location.href = "../../index.html";
	});
	$(".plogram_detail").click(function() {
		location.href = "#";
	});
	$(".program_detail_back").click(function() {
		location.href = "../program_detail.html";
	});
	$("#hamagin_program").click(function() {
		location.href = "program_detail/hamagin.html";
	});
	$("#nisseki_program").click(function() {
		location.href = "program_detail/nisseki.html";
	});
	$("#nisseki_program").click(function() {
		location.href = "program_detail/nisseki.html";
	});
	$(".2015komekome").click(function() {
	//	location.href = "22nd/plan2015_08-1comedical.pdf";
		location.href = "22nd/program_detail/by_venue_nisseki/nisseki.html#comedical_session";
	});
	$("#blog").click(function() {
		location.href = "http://www.kamakuraheart.org/wordpress/";
	});
	$("#dicom").click(function() {
		location.href = "./DICOM-XA/DICOM-XA00.html";
	});
	$("#view_pm").click(function() {
		window.alert("ただいま工事中です　暫くお待ち下さい\n素晴らしい画面をすぐに見ることができますよ!!");
	});
	$("#about").click(function() {
		window.alert("このホームページは Web最新テクノロジーである Responsive WEB Designで作られています。優れた Open Source Softwareである jQueryと Twitter Bootstrapを用いて HTML5 + CSS3で作るように努力しています。");
	});
	$("#machine").click(function() {
		window.alert("あまりにもたくさんの高度最先端の診療機器を備えていますので、紹介しきれません。あしからず!");
	});
	$('#extension_english').jTruncate({
        length: 200,            // 表示する文字数
        minTrail: 0,            // 省略文字の最低文字数
        moreText: "[Continue...]",       // 省略部分を表示するリンクの文字
        lessText: "[Hide...]",       // 省略部分を非表示にするリンクの文字
        ellipsisText: "...",    // 省略部分をあらわす文字
        moreAni: "fast",        // 折り広げるスピード
        lessAni: "fast"         // 折り畳むスピード
    });  
	$('#extension_japanese').jTruncate({
        length: 220,            // 表示する文字数
        minTrail: 0,            // 省略文字の最低文字数
        moreText: "[続きを読む...]",       // 省略部分を表示するリンクの文字
        lessText: "[隠す...]",       // 省略部分を非表示にするリンクの文字
        ellipsisText: "...",    // 省略部分をあらわす文字
        moreAni: "fast",        // 折り広げるスピード
        lessAni: "fast"         // 折り畳むスピード
    });  
});