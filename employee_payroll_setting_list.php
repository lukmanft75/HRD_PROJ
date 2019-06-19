<?php
	$_isexport = false;
	if(@$_GET["export"]){
		$_exportname = "Employee_List.xls";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=".$_exportname);
		header("Pragma: no-cache");
		header("Expires: 0");
		$_GET["do_filter"]="Load";
		$_isexport = true;
	}
	include_once "head.php";
	if(GET_url_decode("deleting") && $__group_id == "0"){
		$db->addtable("employees");			$db->where("id",GET_url_decode("deleting"));
		$db->addfield("hidden");			$db->addvalue("1");
		$update = $db->update();
		$_SESSION["alert_success"] = "Data deleted successfully!";
		?>
			<script type="text/JavaScript">setTimeout("location.href = 'employee_list.php';",1500);</script>
		<?php
	}
	if(!$_isexport){
	?>
	<!--Filter-->
	<div class="modal fade" id="filter_box" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					<div class="login mx-auto mw-100">
						<h5 class="text-center">Filter Box</h5>
						<?=$f->start("filter","GET");?>
							<div class="form-group ">
								<p class="mb-2">Code</p>
								<?=$f->input("code",@$_GET["code"],"","form-control");?>
							</div>
							<div class="form-group ">
								<p class="mb-2">Name</p>
								<?=$f->input("name",@$_GET["name"],"","form-control");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Sex</p>
								<?=$f->select("sex",[""=>"","M"=>"M","F"=>"F"],@$_GET["sex"],"","select_filter");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Marital Status</p>
								<?=$f->select("status_id",$db->fetch_select_data("statuses","id","name",[],[],"",true),@$_GET["status_id"],"","select_filter");?>
							</div>
							<div class="form-group">
								<p class="mb-2">As CSR</p>
								<?=$f->select("employed_as_csr",[""=>"","1"=>"No","2"=>"Yes"],@$_GET["employed_as_csr"],"","select_filter");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Training</p>
								<?=$f->input("training",@$_GET["training"],"","form-control");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Position</p>
								<?=$f->input("position",@$_GET["position"],"","form-control");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Contract Status</p>
								<?=$f->select("contract_status",["" => "", "Uji Coba"=>"Uji Coba","PKWT"=>"PKWT","Pegawai Tetap" => "Pegawai Tetap"],@$_GET["contract_status"],"","select_filter");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Recruitment Status</p>
								<?=$f->select("status_recruitment",["" => "", "Local Desa"=>"Local Desa","Local Reguler"=>"Local Reguler","Nasional" => "Nasional"],@$_GET["status_recruitment"],"","select_filter");?>
							</div>
							<?=$f->input("page","1","type='hidden'");?>
							<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
							<?=$f->input("do_filter","Load","type='submit' style='width:140px;'", "btn btn-primary");?>
							<?=$f->input("reset","Reset","type='button' style='width:140px;' onclick=\"window.location='?';\"", "btn btn-warning");?>
							<?=$f->input("export","Export to Excel","type='submit' style='width:170px;'","btn btn-success");?>
						<?=$f->end();?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--//Filter-->
	<?php } ?>
	
	<!--Table-->
	<section class="typography py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="table_list">
			<div class="sub-head mb-3 ">
			<?php include_once "a_notification.php"; ?>
				<h4>Employee List</h4>
					<?=$f->input("filter","Filter","type='button' data-toggle='modal' data-target='#filter_box'", "btn btn-success");?>
			</div>
			
			<?php
				$whereclause = "";
				if(@$__group_id > 0)	$whereclause .= "hidden = '0' AND ";
				if(@$_GET["code"]!="") $whereclause .= "(code LIKE'%".$_GET["code"]."%') AND ";
				if(@$_GET["name"]!="") $whereclause .= "(name LIKE '%".$_GET["name"]."%') AND ";
				if(@$_GET["sex"]!="") $whereclause .= "(sex ='".$_GET["sex"]."') AND ";
				if(@$_GET["status_id"]!="") $whereclause .= "(status_id ='".$_GET["status_id"]."') AND ";

				if(@$_GET["employed_as_csr"] > 0) $whereclause .= "(employed_as_csr = '".$_GET["employed_as_csr"]."') AND ";
				if(@$_GET["training"]!= "" || @$_GET["position"]!= ""){
					$whereclause .= "(";
					if(@$_GET["training"]!= "") $whereclause .= "id IN (SELECT employee_id FROM employee_trainings WHERE name LIKE '%".$_GET["training"]."%' group by employee_id) OR ";
					if(@$_GET["position"]!= "") $whereclause .= "id IN (SELECT employee_id FROM employee_payroll_params WHERE param = 'Position' AND params_value LIKE '%".$_GET["position"]."%' group by employee_id) OR ";
					$whereclause = substr($whereclause,0,-3);
					$whereclause .= ") AND ";
				}
				if(@$_GET["contract_status"] != "") $whereclause .= "id IN (SELECT employee_id FROM employee_payroll_params WHERE param = 'Contract Status' AND valid_at <= '".date("Y-m-d")."' AND params_value = '".$_GET["contract_status"]."' group by employee_id) AND ";
				if(@$_GET["status_recruitment"] != "") $whereclause .= "id IN (SELECT employee_id FROM employee_payroll_params WHERE param = 'Recruitment Status' AND valid_at <= '".date("Y-m-d")."' AND params_value = '".$_GET["status_recruitment"]."' group by employee_id) AND ";
   	
				$db->addtable("employees");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
				$maxrow = count($db->fetch_data(true));

				$db->addtable("employees");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
				if(@$_GET["sort"] != "") {
					if(@$_GET["desc"]) {$desc = "DESC";} else {$desc = "";}
					$db->order($_GET["sort"]." ".$desc);
				} else {$db->order("created_at DESC");}
				$db->limit($_limit);
				$employees = $db->fetch_data(true);

				$count_data =count($db->fetch_all_data("employees",["id"],substr($whereclause,0,-4)));
			?>
			
			<?php  if(!$_isexport){ include "a_pagination.php"; }?>
			<div class="bd-example mb-4">
				<div style="overflow-x:auto; position: relative; height: 60%; overflow: auto; display: block;">
					<?=$t->start($border_tbl,"","data_content");?>
					<?=$t->header(array("No",
						"Actions",
						"<div onclick=\"sorting('id');\">ID</div>",
						"<div onclick=\"sorting('code');\">Code</div>",
						"<div onclick=\"sorting('name');\">Name</div>",
						"<div onclick=\"sorting('birthdate');\">Birthdate</div>",
						"<div onclick=\"sorting('sex');\">Sex</div>",
						"<div onclick=\"sorting('status_id');\">Status</div>",
						"<div onclick=\"sorting('address');\">Address</div>",
						"<div onclick=\"sorting('phone');\">Phone</div>",
						"<div onclick=\"sorting('bank');\">Bank</div>",
						"<div onclick=\"sorting('bank_account');\">Bank Account</div>",
						"<div onclick=\"sorting('ktp');\">NIK</div>",
						"<div onclick=\"sorting('npwp');\">NPWP</div>",
						"<div onclick=\"sorting('bpjs_kesehatan');\">BPJS kesehatan</div>",
						"<div onclick=\"sorting('bpjs_ketenagakerjaan');\">BPJS ketenagakerjaan</div>",
                        "<div onclick=\"sorting('email');\">Email</div>",
                        "<div onclick=\"sorting('attendance_id');\">Attendance Id</div>",
                        "<div onclick=\"sorting('join_indohr_at');\">Join IndoHR At</div>",
                        "<div onclick=\"sorting('employed_as_csr');\">CSR</div>",
						"<div onclick=\"sorting('created_at');\">Created At</div>",
						"<div onclick=\"sorting('created_by');\">Created By</div>"));?>
					
						<?php
							foreach($employees as $data_employee){
								$generate = $f->input("code_generate","","type='hidden' style='width: 1px !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_generator_code.php?employee_id=".$data_employee["id"]."&updating_table=true\")'", "");
								$actions = 	"<a href=\"employee_payroll_setting_view.php?".url_encode("employee_id")."=".url_encode($data_employee["id"])."\"><img src='images/view.png' style='width:20px; height:20px;' title='View'></a>";
								$actions .= "<img src='images/vertical.png' style='width:20px; height:20px;'>";
								$actions .= "<a href=\"employee_payroll_setting_edit.php?".url_encode("employee_id")."=".url_encode($data_employee["id"])."\"><img src='images/edit.png' style='width:20px; height:20px;' title='Edit'></a>";
								
								$status = $db->fetch_single_data("statuses","name",array("id"=>$data_employee["status_id"]));
								$bpjskesehatan = $db->fetch_single_data("bpjs","bpjs_id",array("employee_id"=>$data_employee["id"],"bpjs_type" => '1',"pisa" => "peserta"));
								$bpjskesehatan .= "<img src='images/folder.png' style='width:30px; height:30px; float:right;' title='Open Window' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/bpjs_kesehatan_list.php?employee_id=".$data_employee["id"]."&pisa=peserta\")'>";
								$bpjsketenagakerjaan = $db->fetch_single_data("bpjs","bpjs_id",array("employee_id"=>$data_employee["id"],"bpjs_type" => '2',"pisa" => "peserta"));
								$bpjsketenagakerjaan .= "<img src='images/folder.png' style='width:30px; height:30px; float:right;' title='Open Window' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/bpjs_ketenagakerjaan_list.php?employee_id=".$data_employee["id"]."&pisa=peserta\")'>";
								if($data_employee["code"] == ""){
									
									$data_employee["code"] = $generate."<div id='employee_code_".$data_employee["id"]."'>".$f->input("btn_generate_code","Generate","type='button' onclick=\"generate_code('".$data_employee["id"]."','employee_code_".$data_employee["id"]."');\"","btn btn-info")."</div>";
								} else {
									$data_employee["code"] = "<a href=\"employee_payroll_setting_view.php?".url_encode("employee_id")."=".url_encode($data_employee["id"])."\" style='color:black; font-weight:bolder; font-style:italic;'>".$data_employee["code"]."</a>";
								}
								if($data_employee["employed_as_csr"] == "2") {$csr = "Yes";} else {$csr = "";}
								?>
								<?=$t->row(
											array($start++,
												$actions,
												"<a href=\"employee_payroll_setting_view.php?".url_encode("employee_id")."=".url_encode($data_employee["id"])."\" style='color:black; font-weight:bolder; font-style:italic;'>".$data_employee["id"]."</a>",
												$data_employee["code"],
												"<a href=\"employee_payroll_setting_view.php?".url_encode("employee_id")."=".url_encode($data_employee["id"])."\" style='color:black; font-weight:bolder; font-style:italic;'>".$data_employee["name"]."</a>",
												format_tanggal($data_employee["birthdate"],"d-M-Y"),
												$data_employee["sex"],
												$status,
												$data_employee["address"],
												$data_employee["phone"],
												$data_employee["bank_name"],
												$data_employee["bank_account"],
												$data_employee["ktp"],
												$data_employee["npwp"],
												$bpjskesehatan,
												$bpjsketenagakerjaan,
												$data_employee["email"],
												$data_employee["attendance_id"],
												format_tanggal($data_employee["join_indohr_at"],"d-M-Y"),
												$csr,
												format_tanggal($data_employee["created_at"],"d-M-Y"),
												$data_employee["created_by"]),
											array("align='right' valign='top'","")
										);?>
							<?php
							}
						?>
					<?=$t->end();?>
				</div>
			</div>
		</div>
	</section>
	<!--//Table-->

<?php
	include_once "footer.php";
	include_once "a_pop_up_js.php";
	include_once "ajax/employees_js.php";
	include_once "window_boxs/wb_default.php";
?>
</body>
</html>