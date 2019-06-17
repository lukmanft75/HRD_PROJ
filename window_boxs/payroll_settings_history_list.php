<?php include_once "wb_head.php" ;?>
<body>			
	<?php
		$_title = "Payroll Setting History";
		$_tablename = "employee_payroll_setting";
		$employee_id = $db->fetch_single_data($_tablename,"employee_id",["id" => $_GET["id"]]);
		$payroll_type_id = $db->fetch_single_data($_tablename,"payroll_type_id",["id" => $_GET["id"]]);
		$payroll_item_id = $db->fetch_single_data($_tablename,"payroll_item_id",["id" => $_GET["id"]]);
		$name = $db->fetch_single_data($_tablename,"name",["id" => $_GET["id"]]);
		if(isset($_GET["save_id"])){
			$taxable = ($_GET["taxable"] == "true")?"1":"0";
			if(stripos(" ".$name, "reimb") > 0) $taxable = 0;
			$excluding_thp = ($_GET["excluding_thp"] == "true")?"1":"0";
			$db->addtable($_tablename);		$db->where("id",$_GET["save_id"]);
			$db->addfield("percentage");	$db->addvalue($_GET["percentage"]);
			$db->addfield("nominal");		$db->addvalue($_GET["nominal"]);
			$db->addfield("taxable");		$db->addvalue($taxable);
			$db->addfield("excluding_thp");	$db->addvalue($excluding_thp);
			$updating = $db->update();
			if($updating["affected_rows"] > 0) echo "<font color='blue'>Data Updated Succesfully</font>";
		}
		if(isset($_GET["remove_id"])){$db->addtable($_tablename); $db->where("id",$_GET["remove_id"]); $db->delete_();}
	?>

	<div class="modal-body" id="List">
		<div class="login mx-auto mw-100">
			<h5 class="text-center"><?=$_title;?><br>(<?=$name;?>)</h5>
			<?php include_once "../a_notification.php"; ?>
			<div class="table_list">
				<div style="overflow-x:auto;">
					<?=$t->start("","data_content");?>
					<?=$t->header(["No","Tgl Berlaku","%","Nominal","Taxable","Exc. Thp","Action"]);?>
					<?php
						$where = "employee_id = '".$employee_id."' AND payroll_type_id = '".$payroll_type_id."'";
						if($payroll_item_id > 0) $where .= " AND payroll_item_id = '".$payroll_item_id."'";
						else if($name != "") $where .= " AND name LIKE '%".$name."%'";
						$settings = $db->fetch_all_data($_tablename,[],$where,"valid_at DESC, id desc");
						foreach($settings as $no => $setting){
							$id = $setting["id"];
							$txt_percentage 	= $f->input("percentage[".$id."]",$setting["percentage"],"type='number' style='text-align:right;'","form-control");
							$txt_nominal 		= $f->input("nominal[".$id."]",$setting["nominal"],"type='number' pattern='([0-9]{1,3}).([0-9]{1,3})' style='text-align:right;'","form-control");
							$checked 			= ($setting["taxable"]=="1")?"checked":"";
							$chk_taxable 		= $f->input("taxable[".$id."]","1","type='checkbox' style='width:20px; height:20px;' ".$checked);
							$checked 			= ($setting["excluding_thp"]=="1")?"checked":"";
							$chk_excluding_thp 	= $f->input("excluding_thp[".$id."]","1","type='checkbox' style='width:20px; height:20px;' ".$checked);
							$action 			= $f->input("save","Save","type='button' onclick=\"window.location='?id=".$_GET["id"]."&save_id=".$id."&percentage='+document.getElementById('percentage[".$id."]').value+'&nominal='+document.getElementById('nominal[".$id."]').value+'&taxable='+document.getElementById('taxable[".$id."]').checked+'&excluding_thp='+document.getElementById('excluding_thp[".$id."]').checked;\"","btn btn-primary");
							$action 			.= "&nbsp;".$f->input("remove","Remove","type='button' onclick=\"window.location='?id=".$_GET["id"]."&remove_id=".$id."';\"","btn btn-warning");
							echo $t->row([$no+1,format_tanggal($setting["valid_at"]),$txt_percentage,$txt_nominal,$chk_taxable,$chk_excluding_thp,$action],["align='right' valign='top'","valign='top'","style='width:13%;'","style='width:15%;'"]);
						}
					?>
					<?=$t->end();?>
				
					<?=$f->input("close","Close","type='button' onclick=\"parent.window.location = parent.window.location;\"","btn btn-secondary");?>
				</div>
			</div>
		</div>
	</div>
</body>			
