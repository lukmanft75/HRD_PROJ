<?php include_once "wb_head.php" ;?>
<body>			
	<?php
		$_title = "Payroll Parameter History";
		$_tablename = "employee_payroll_params";
		$employee_id 	= $db->fetch_single_data($_tablename,"employee_id",["id" => $_GET["id"]]);
		$param_name 	= $db->fetch_single_data($_tablename,"param",["id" => $_GET["id"]]);
		if(isset($_GET["save_id"])){
			$db->addtable($_tablename);		$db->where("id",$_GET["save_id"]);
			$db->addfield("params_value");	$db->addvalue($_GET["params_value"]);
			$updating = $db->update();
			if($updating["affected_rows"] > 0) $_SESSION["alert_success"] = "Data updated successfully!";
		}
		if(isset($_GET["remove_id"])){$db->addtable($_tablename); $db->where("id",$_GET["remove_id"]); $db->delete_();}
	?>

	<div class="modal-body" id="List">
		<div class="login mx-auto mw-100">
			<h5 class="text-center"><?=$_title;?><br>(<?=$param_name;?>)</h5>
			<?php include_once "../a_notification.php"; ?>
			<div class="table_list">
				<div style="overflow-x:auto;">
					<?=$t->start("","data_content");?>
						<?=$t->header(["No","Tanggal Berlaku","Nilai Parameter","Action"]);?>
						<?php
							$params = $db->fetch_all_data("employee_payroll_params",[],"employee_id = '".$employee_id."' AND param LIKE '".$param_name."'","valid_at DESC, id desc");
							foreach($params as $no => $param){
								$id = $param["id"];
								$txt_params_value = $f->input("params_value[".$id."]",$param["params_value"],"","form-control");
								if($param["param"] == "Status") $txt_params_value = $f->select("params_value[".$id."]",["TK"=>"TK","M0"=>"M0","M1"=>"M1","M2"=>"M2","M3"=>"M3"],$param["params_value"],"","select_form_tb");
								if($param["param"] == "NPWP") $txt_params_value = $f->select("params_value[".$id."]",["Yes"=>"Yes","No"=>"No"],$param["params_value"],"","select_form_tb");
								if($param["param"] == "Project") $txt_params_value = $f->select("params_value[".$id."]",$db->fetch_select_data("projects","id","name",[],["id"]),$param["params_value"],"","select_form_tb");
								if($param["param"] == "Contract Status") $txt_params_value = $f->select("params_value[".$id."]",["" => "", "Uji Coba"=>"Uji Coba","PKWT"=>"PKWT","Pegawai Tetap" => "Pegawai Tetap"],$param["params_value"],"","select_form_tb");
								if($param["param"] == "Resign/Termination Date") $txt_params_value = $f->input("params_value[".$id."]",$param["params_value"],"type='date'","form-control");
								if($param["param"] == "Recruitment Status") $txt_params_value = $f->select("params_value[".$id."]",["" => "", "Local Desa"=>"Local Desa","Local Reguler"=>"Local Reguler","Nasional" => "Nasional"],$param["params_value"],"","select_form_tb");
								$action = $f->input("save","Save","type='button' onclick=\"window.location='?id=".$_GET["id"]."&save_id=".$id."&params_value='+document.getElementById('params_value[".$id."]').value;\"","btn btn-primary");
								$action .= "&nbsp;".$f->input("remove","Remove","type='button' onclick=\"window.location='?id=".$_GET["id"]."&remove_id=".$id."';\"","btn btn-danger");
								echo $t->row([$no+1,format_tanggal($param["valid_at"]),$txt_params_value,$action],["align='right' valign='top'","valign='top'"]);
							}
						?>
					<?=$t->end();?>
					<?=$f->input("close","Close","type='button' onclick=\"parent.window.location = parent.window.location;\"","btn btn-secondary");?>
				</div>
			</div>
		</div>
	</div>
</body>			
