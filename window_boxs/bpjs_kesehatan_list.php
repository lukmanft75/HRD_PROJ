<?php include_once "wb_head.php" ;?>
<body>			
	<?php
		$db->addtable("bpjs");
		if($_GET["employee_id"] > 0) {
			$employee_id	= $_GET["employee_id"];
			$db->awhere("employee_id = '".$employee_id."' AND bpjs_type = '1'");
		}
		if($_GET["candidate_id"] > 0) {
			$candidate_id 	= $_GET["candidate_id"];
			$db->awhere("candidate_id = '".$candidate_id."' AND bpjs_type = '1'");
		}
		$databpjs = $db->fetch_data(true);
		
		if($_GET["deleting"]){
			$db->addtable("bpjs");	$db->where("id",$_GET["deleting"]);
			$deleting = $db->delete_();
			$_SESSION["alert_success"] = "Data deleted successfully!";
			?>
				<script type="text/JavaScript">setTimeout("location.href = '?candidate_id=<?=$candidate_id;?>&employee_id=<?=$employee_id;?>';",1500);</script>
			<?php
		}
	?>
	
	<div class="modal-body" id="List">
		<div class="login mx-auto mw-100">
			<h5 class="text-center">BPJS Kesehatan</h5>
			<?php include_once "../a_notification.php"; ?>
			<div class="table_list">
				<div style="overflow-x:auto;">
					<?=$t->start("","","data_content");?>
						<?=$t->header(["No",
										"Action",
										"Name",
										"Date of Birth",
										"PISA",
										"Sex",
										"NIK",
										"No BPJS",
										"Remarks",
										"Files"]);?>
						<?php 
							$i=0;
							foreach($databpjs as $no => $data){
								$i++;
								echo $f->input("key_id_".$data["id"],$data["id"],"type='hidden'");
								$actions = 	"<img src='../images/edit.png' style='width:20px; height:20px;' title='Edit' onclick=\"window.location='".str_replace("_list","_edit",$_SERVER["PHP_SELF"])."?bpjs_id=".$data["id"]."&candidate_id=".$candidate_id."&employee_id=".$employee_id."';\" '>";
								$actions .= "<img src='../images/vertical.png' style='width:20px; height:20px;'>";
								$actions .= "<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$data["id"]."&candidate_id=".$candidate_id."&employee_id=".$employee_id."';}\"><img src='../images/cancel.png' style='width:20px; height:20px;' title='Delete'></a>";
								$files	= "";
								if($data["softcopy"] != "") $files	.= "<a href=\"../files_bpjs/".$data["softcopy"]."\" target=\"_BLANK\" style='color:blue;'>BPJS</a> | ";
								if($data["file_ktp"] != "")	$files	.= "<a href=\"../files_bpjs/".$data["file_ktp"]."\" target=\"_BLANK\" style='color:blue;'>KTP</a> | ";
								if($data["file_kk"] != "") 	$files	.= "<a href=\"../files_bpjs/".$data["file_kk"]."\" target=\"_BLANK\" style='color:blue;'>KK</a> | ";
								if($data["file_pernyataan"] != "")	$files	.= "<a href=\"../files_bpjs/".$data["file_pernyataan"]."\" target=\"_BLANK\" style='color:blue;'>SP</a> | ";
								if($data["file_kjpensiun"] != "")	$files	.= "<a href=\"../files_bpjs/".$data["file_kjpensiun"]."\" target=\"_BLANK\" style='color:blue;'>KJP</a> | ";
								$files = substr($files,0,-3);
								
								echo $t->row([$i,
											$actions,
											$data["name"],
											format_tanggal($data["birthdate"],"d M Y"),
											$data["pisa"],
											$data["sex"],
											$data["ktp"],
											$data["bpjs_id"],
											$data["remarks"],
											$files],
											["align='right'",
											"",
											"",
											"align='right'",
											"",
											"align='center'",
											"align='right'",
											"align='right'",
											"",
											""]);
							}
						?>
					<?=$t->end();?>
				</div>
			</div>
				<?=$f->input("add","Add","type='button' onclick=\"window.location='".str_replace("_list","_add",$_SERVER["PHP_SELF"])."?candidate_id=".$candidate_id."&employee_id=".$employee_id."';\"","btn btn-info");?>
				<?=$f->input("close","Close","type='button' onclick=\"parent.window.location = parent.window.location;\"","btn btn-secondary");?>
		</div>
	</div>
</body>			
