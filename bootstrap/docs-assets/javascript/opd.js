// JavaScript Document
$(function() {
	$("td:contains('高橋')").addClass("text-danger");
	$("td:contains('松実')").addClass("text-warning");
	$("td:contains('村上')").addClass("text-success");
	$("tr td:first-child").css("width", "1em");
});

