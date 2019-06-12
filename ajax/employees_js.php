<script>
	function generate_code(employee_id,elm_return,updating_table,function_after,with_join_date){
		employee_id = employee_id || '';
		updating_table = updating_table || 'true';
		function_after = function_after || '';
		with_join_date = with_join_date || '0';
		document.getElementById("code_generate").click();
		// $.fancybox.open({ href: "employee_generator_code.php?employee_id="+employee_id+"&elm_return="+elm_return+"&updating_table="+updating_table+"&function_after="+function_after+"&with_join_date="+with_join_date, width: "350",height: "80%", type: "iframe" });
	}
	// function process_to_employee(elm_return){
		// var candidate_id = "<?=$_GET["id"];?>";
		// $.fancybox.open({ href: "candidate_generator_code.php?candidate_id="+candidate_id+"&elm_return="+elm_return, width: "350",height: "80%", type: "iframe" });
	// }
	// function subwindow_payroll_params_history(id){
		// $.fancybox.open({ href: "sub_window/win_payroll_params_history_list.php?id="+id, height: "80%", type: "iframe" });
	// }
	// function subwindow_payroll_settings_history(id){
		// $.fancybox.open({ href: "sub_window/win_payroll_settings_history_list.php?id="+id, height: "80%", type: "iframe" });
	// }
</script>