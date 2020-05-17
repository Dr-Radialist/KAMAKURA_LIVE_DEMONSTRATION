// JavaScript Document

	$(document).ready(function() {
		"use strict";
		$("#name").click(function() {
			if ($(this).val() === 'ASC') {
				$(this).val('DESC');
				$.post("chair_mod_add_list.php", {'name': 'DESC'}, function(data) {
					$("#dataarea").html(data);
				});
			} else {
				$(this).val('ASC');
				$.post("chair_mod_add_list.php", {'name': 'ASC'}, function(data) {
					$("#dataarea").html(data);
				});
			}
		});
		$("#kana_name").click(function() {
			if ($(this).val() === 'ASC') {
				$(this).val('DESC');
				$.post("chair_mod_add_list.php", {'kana_name': 'DESC'}, function(data) {
					$("#dataarea").html(data);
				});
			} else {
				$(this).val('ASC');
				$.post("chair_mod_add_list.php", {'kana_name': 'ASC'}, function(data) {
					$("#dataarea").html(data);
				});
			}
		});	
		$("#member_kind").click(function() {
			if ($(this).val() === 'ASC') {
				$(this).val('DESC');
				$.post("chair_mod_add_list.php", {'member_kind': 'DESC'}, function(data) {
					$("#dataarea").html(data);
				});
			} else {
				$(this).val('ASC');
				$.post("chair_mod_add_list.php", {'member_kind': 'ASC'}, function(data) {
					$("#dataarea").html(data);
				});
			}
		});	
		$("#nation").click(function() {
			if ($(this).val() === 'ASC') {
				$(this).val('DESC');
				$.post("chair_mod_add_list.php", {'nation': 'DESC'}, function(data) {
					$("#dataarea").html(data);
				});
			} else {
				$(this).val('ASC');
				$.post("chair_mod_add_list.php", {'nation': 'ASC'}, function(data) {
					$("#dataarea").html(data);
				});
			}
		});	
	});
