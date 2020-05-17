// JavaScript Document
$(function() {
	$("#rtn_home").click(function() {
		location.href = "../index.php";
	});
	$("a.btn-primary").click(function() {
		$("li").removeClass("active");
		$("#all").css("display", "block");
		$("div.col-lg-6").css("display", "block");
	});
	$("#to_all").click(function() {
		$("li").removeClass("active");
		$("li:has(#to_all)").addClass("active");
		$("#all").css("display", "block");
		$("#pci").css("display", "block");
		$("#evt").css("display", "block");
		$("#ca").css("display", "block");
		$("#tavi").css("display", "block");
		$("#pm").css("display", "block");
		$("#ct").css("display", "block");
	});
	$("#to_pci").click(function() {
		$("li").removeClass("active");
		$("li:has(#to_pci)").addClass("active");
		$("#all").css("display", "none");
		$("#pci").css("display", "block");
		$("#evt").css("display", "none");
		$("#ca").css("display", "none");
		$("#tavi").css("display", "none");
		$("#pm").css("display", "none");
		$("#ct").css("display", "none");
	});
	$("#to_evt").click(function() {
		$("li").removeClass("active");
		$("li:has(#to_evt)").addClass("active");
		$("#all").css("display", "none");
		$("#pci").css("display", "none");
		$("#evt").css("display", "block");
		$("#ca").css("display", "none");
		$("#tavi").css("display", "none");
		$("#pm").css("display", "none");
		$("#ct").css("display", "none");
	});
	$("#to_ca").click(function() {
		$("li").removeClass("active");
		$("li:has(#to_ca)").addClass("active");
		$("#all").css("display", "none");
		$("#pci").css("display", "none");
		$("#evt").css("display", "none");
		$("#ca").css("display", "block");
		$("#tavi").css("display", "none");
		$("#pm").css("display", "none");
		$("#ct").css("display", "none");
	});
	$("#to_tavi").click(function() {
		$("li").removeClass("active");
		$("li:has(#to_tavi)").addClass("active");
		$("#all").css("display", "none");
		$("#pci").css("display", "none");
		$("#evt").css("display", "none");
		$("#ca").css("display", "none");
		$("#tavi").css("display", "block");
		$("#pm").css("display", "none");
		$("#ct").css("display", "none");
	});
	$("#to_pm").click(function() {
		$("li").removeClass("active");
		$("li:has(#to_pm)").addClass("active");
		$("#all").css("display", "none");
		$("#pci").css("display", "none");
		$("#evt").css("display", "none");
		$("#ca").css("display", "none");
		$("#tavi").css("display", "none");
		$("#pm").css("display", "block");
		$("#ct").css("display", "none");
	});
	$("#to_ct").click(function() {
		$("li").removeClass("active");
		$("li:has(#to_ct)").addClass("active");
		$("#all").css("display", "none");
		$("#pci").css("display", "none");
		$("#evt").css("display", "none");
		$("#ca").css("display", "none");
		$("#tavi").css("display", "none");
		$("#pm").css("display", "none");
		$("#ct").css("display", "block");
	});
});

