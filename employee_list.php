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
								<p class="mb-2">Name</p>
								<?=$f->input("name",@$_GET["name"],"","form-control");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Year of Brithdate</p>
								<?=$f->input("year",@$_GET["year"],"type='number'","form-control");?>
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
								<p class="mb-2">Address</p>
								<?=$f->input("address",@$_GET["address"],"","form-control");?>
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
					<?=$f->input("add","Add","type='button' onclick=\"window.location='employee_add.php';\"", "btn btn-primary");?>
					<?=$f->input("filter","Filter","type='button' data-toggle='modal' data-target='#filter_box'", "btn btn-success");?>
			</div>
			
			<?php
				$whereclause = "";
				if(@$__group_id > 0)	$whereclause .= "hidden = '0' AND ";
				// if(@$_GET["name"]!="") $whereclause .= "name LIKE '"."%".str_replace(" ","%",$_GET["name"])."%"."' AND ";
				// if(@$_GET["year"]!="") $whereclause .= "birthdate LIKE '".str_replace(" ","%",$_GET["year"])."-%"."' AND ";
				// if(@$_GET["sex"]!="") $whereclause .= "sex = '".$_GET["sex"]."' AND ";
				// if(@$_GET["status_id"]!="") $whereclause .= "status_id = '".$_GET["sex"]."' AND ";
				// if(@$_GET["address"]!="") $whereclause .= "(address LIKE '"."%".str_replace(" ","%",$_GET["address"])."%"."' OR 
															// address_2 LIKE '"."%".str_replace(" ","%",$_GET["address"])."%"."' OR
															// address_3 LIKE '"."%".str_replace(" ","%",$_GET["address"])."%"."' OR
															// address_4 LIKE '"."%".str_replace(" ","%",$_GET["address"])."%"."'
															// ) AND ";

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
					<?php
						$arr_header = ["No"];
						if(!$_isexport) array_push($arr_header,"Action");
						array_push($arr_header,
							"<div onclick=\"sorting('name');\">Nama</div>",
							"<div onclick=\"sorting('code');\">NIP</div>",
							"<div onclick=\"sorting('birthdate');\">Tempat & Tgl. Lahir</div>",
							"Jabatan",
							"POH",
							"Status Rekrutmen",
							"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TMK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
							"Akhir Kontrak",
							"Lamanya Bekerja",
							"Cuti<br>Tahunan",
							"Status Pegawai",
							"No Rekening",
							"Jenis<br>Kelamin",
							"<div onclick=\"sorting('ktp');\">KTP</div>",
							"<div onclick=\"sorting('npwp');\">NPWP</div>",
							"<div onclick=\"sorting('address');\">Alamat</div>",
							"Status<br>Pernikahan",
							"Nama Suami/stri",
							"Tempat & tgl lahir Istri / Suami",
							"Nama Anak 1",
							"Tempat & tgl lahir Anak 1",
							"Jenis Kelamin",
							"Nama Anak 2",
							"Tempat & tgl lahir Anak 2",
							"Jenis Kelamin",
							"Nama Anak 3",
							"Tempat & tgl lahir Anak 3",
							"Jenis Kelamin",
							"No. Kontak Darurat I",
							"Nama Kontak I",
							"Hubungan dgn Karyawan",
							"No. Kontak Darurat II",
							"Nama Kontak II",
							"Hubungan dgn Karyawan");
						$arr_header_attr = ["rowspan='2' valign='middle' nowrap"];
						if(!$_isexport) array_push($arr_header_attr,"rowspan='2' valign='middle' nowrap");
						array_push($arr_header_attr,
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"colspan='2' align='center'",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap",
							"rowspan='2' valign='middle' nowrap");
					?>
					<?=$t->header($arr_header,$arr_header_attr);?>
					<?=$t->header(["Hitungan Bulan","Hitungan Tahun"]);?>
					
						<?php
							foreach($employees as $data_employee){
								$actions = 	"<a href=\"employee_view.php?".url_encode("employee_id")."=".url_encode($data_employee["id"])."\"><img src='images/view.png' style='width:20px; height:20px;' title='View'></a>";
								$actions .= "<img src='images/vertical.png' style='width:20px; height:20px;'>";
								$actions .= "<a href=\"employee_edit.php?".url_encode("employee_id")."=".url_encode($data_employee["id"])."\"><img src='images/edit.png' style='width:20px; height:20px;' title='Edit'></a>";
								if($data_employee["hidden"] == 0 && $__group_id == "0") {
									$actions .= "<img src='images/vertical.png' style='width:20px; height:20px;'>";
									$actions .= "<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?".url_encode("deleting")."=".url_encode($data_employee["id"])."';}\"><img src='images/cancel.png' style='width:20px; height:20px;' title='Deactive'></a>";
								}
								
								$poh = $db->fetch_single_data("employee_payroll_params","params_value",["param" => "Point Of Hire:LIKE", "employee_id" => $data_employee["id"]]);
			
								$datetime1 = date_create($data_employee["join_indohr_at"]);
								$datetime2 = date_create(date("Y-m-d"));
								$interval = date_diff($datetime1, $datetime2);
								$lamakerja_bln = ($interval->format('%Y Tahun') * 12 + $interval->format('%m'))." Bulan";
								$lamakerja_yrs = $interval->format('%Y Tahun')." ".$interval->format('%m Bulan');
								
								$spouse_birth = $db->fetch_single_data("employee_families","birthplace",["employee_id" => $data_employee["id"],"relation_id" => 2]);
								if($spouse_birth != "") $spouse_birth .= ", ".format_tanggal($db->fetch_single_data("employee_families","birthdate",["employee_id" => $data_employee["id"],"relation_id" => 2]));
								
								$child_birth_1s = $db->fetch_all_data("employee_families",[],"employee_id = '".$data_employee["id"]."' AND relation_id='4' ORDER BY birthdate")[0];
								$child_sex_1 = $child_birth_1s["sex"];
								$child_name_1 = $child_birth_1s["fullname"];
								$child_birth_1 = "";
								if($child_birth_1s["birthplace"] != "") $child_birth_1 = $child_birth_1s["birthplace"].", ".format_tanggal($child_birth_1s["birthdate"]);
								
								$child_birth_2s = $db->fetch_all_data("employee_families",[],"employee_id = '".$data_employee["id"]."' AND relation_id='4' ORDER BY birthdate")[1];
								$child_sex_2 = $child_birth_2s["sex"];
								$child_name_2 = $child_birth_2s["fullname"];
								$child_birth_2 = "";
								if($child_birth_2s["birthplace"] != "") $child_birth_2 = $child_birth_2s["birthplace"].", ".format_tanggal($child_birth_2s["birthdate"]);
								
								$child_birth_3s = $db->fetch_all_data("employee_families",[],"employee_id = '".$data_employee["id"]."' AND relation_id='4' ORDER BY birthdate")[2];
								$child_sex_3 = $child_birth_3s["sex"];
								$child_name_3 = $child_birth_3s["fullname"];
								$child_birth_3 = "";
								if($child_birth_3s["birthplace"] != "") $child_birth_3 = $child_birth_3s["birthplace"].", ".format_tanggal($child_birth_3s["birthdate"]);
								
								
								if($data_employee["employed_as_csr"] == "2") {$csr = "Yes";} else {$csr = "";}
								
								$address = $data_employee["address"];
								if($data_employee["address_2"] != "") $address .= ", ".$data_employee["address_2"];
								if($data_employee["address_3"] != "") $address .= ", ".$data_employee["address_3"];
								if($data_employee["address_4"] != "") $address .= ", ".$data_employee["address_4"];
								if($employee["employed_as_csr"] == "2") {$csr = "Yes";} else {$csr = "";}
									$arr_rows = [$start++];
									if(!$_isexport) array_push($arr_rows,$actions);
									array_push(
										$arr_rows,
										ucwords($data_employee["name"]),
										$data_employee["code"],
										$data_employee["birthplace"].", ".format_tanggal($data_employee["birthdate"],"d M Y"),
										$db->fetch_all_data("employee_payroll_params",[],"employee_id = '".$data_employee["id"]."' AND param LIKE 'Position' AND valid_at <= '".date("Y-m-d")."'","valid_at DESC,id DESC")[0]["params_value"],
										$poh,
										$db->fetch_all_data("employee_payroll_params",[],"employee_id = '".$data_employee["id"]."' AND param LIKE 'Recruitment Status' AND valid_at <= '".date("Y-m-d")."'","valid_at DESC,id DESC")[0]["params_value"],
										format_tanggal($data_employee["join_indohr_at"]),
										format_tanggal($db->fetch_all_data("employee_payroll_params",[],"employee_id = '".$data_employee["id"]."' AND param LIKE 'Resign/Termination Date' AND valid_at <= '".date("Y-m-d")."'","valid_at DESC,id DESC")[0]["params_value"]),
										$lamakerja_bln,
										$lamakerja_yrs,
										$cutitahunan,
										$db->fetch_all_data("employee_payroll_params",[],"employee_id = '".$data_employee["id"]."' AND param LIKE 'Contract Status' AND valid_at <= '".date("Y-m-d")."'","valid_at DESC,id DESC")[0]["params_value"],
										$data_employee["bank_account"],
										$data_employee["sex"],
										"&nbsp;".$data_employee["ktp"],
										"&nbsp;".$data_employee["npwp"],
										$data_employee["address"],
										$db->fetch_all_data("employee_payroll_params",[],"employee_id = '".$data_employee["id"]."' AND param LIKE 'Status' AND valid_at <= '".date("Y-m-d")."'","valid_at DESC,id DESC")[0]["params_value"],
										$db->fetch_single_data("employee_families","fullname",["employee_id" => $data_employee["id"],"relation_id" => 2]),
										$spouse_birth,
										$child_name_1,
										$child_birth_1,
										$child_sex_1,
										$child_name_2,
										$child_birth_2,
										$child_sex_2,
										$child_name_3,
										$child_birth_3,
										$child_sex_3,
										"&nbsp;".$data_employee["emergency_no1"],
										$data_employee["emergency_name1"],
										$data_employee["emergency_relation1"],
										"&nbsp;".$data_employee["emergency_no2"],
										$data_employee["emergency_name2"],
										$data_employee["emergency_relation2"]);
								echo $t->row($arr_rows,["align='right' valign='top'","nowrap"]);
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
?>
</body>
</html>