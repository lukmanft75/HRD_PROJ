<?php
	$_isexport = false;
	if(@$_GET["export"]){
		$_exportname = "Candidate_List.xls";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=".$_exportname);
		header("Pragma: no-cache");
		header("Expires: 0");
		$_GET["do_filter"]="Load";
		$_isexport = true;
	}
	include_once "head.php";
	if(GET_url_decode("deleting") > 1 && $__group_id == "0"){
		$db->addtable("candidates");			$db->where("id",GET_url_decode("deleting"));
		$db->addfield("hidden");		$db->addvalue("1");
		$update = $db->update();
		$_SESSION["alert_success"] = "Data deleted successfully!";
		?>
			<script type="text/JavaScript">setTimeout("location.href = 'candidate_list.php';",1500);</script>
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
				<h4>Employee Payrolls</h4>
					<?=$f->input("add","Add","type='button' onclick=\"window.location='candidate_add.php';\"", "btn btn-primary");?>
					<?=$f->input("filter","Filter","type='button' data-toggle='modal' data-target='#filter_box'", "btn btn-success");?>
			</div>
			
			<?php
				$whereclause = "";
				if(@$_GET["code"]!="") $whereclause .= "(employee_id IN (SELECT id FROM employees WHERE code LIKE'%".$_GET["code"]."%')) AND ";
				if(@$_GET["name"]!="") $whereclause .= "(employee_id IN (SELECT id FROM employees WHERE name LIKE '%".$_GET["name"]."%')) AND ";
				if(@$_GET["periode"]!="") $whereclause .= "(periode ='".$_GET["periode"]."') AND ";
				if(@$_GET["project"]!="") $whereclause .= "(employee_id IN (SELECT employee_id FROM employee_payroll_params WHERE param LIKE 'Project' AND params_value = '".$_GET["project"]."')) AND ";

				$db->addtable("employee_payrolls");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
				$maxrow = count($db->fetch_data(true));

				$db->addtable("employee_payrolls");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
				if(@$_GET["sort"] != "") {
					if(@$_GET["desc"]) {$desc = "DESC";} else {$desc = "";}
					$db->order($_GET["sort"]." ".$desc);
				} else {$db->order("created_at DESC");}
				$db->limit($_limit);
				$employee_payrolls = $db->fetch_data(true);

				$count_data =count($db->fetch_all_data("employee_payrolls",["id"],substr($whereclause,0,-4)));
			?>
			
			
			<?php  
			if($_GET["periode"]!="" && $_GET["project"]!=""){
				if(!$_isexport){ include "a_pagination.php"; }?>
					<div class="bd-example mb-4">
						<div style="overflow-x:auto; position: relative; height: 60%; overflow: auto; display: block;">
							<?=$t->start($border_tbl,"","data_content");?>
								<?php 
								$arr_header = [];
								array_push($arr_header,"No");
								if(!$_isexport) array_push($arr_header,"");
								array_push($arr_header,"Code");
								array_push($arr_header,"Name");
								if(!$_export_bank) array_push($arr_header,"Fixed Income");
								if(!$_export_bank) array_push($arr_header,"Variable Income");
								if(!$_export_bank) array_push($arr_header,"Tax");
								if(!$_export_bank) array_push($arr_header,"Deduction");
								if($_export_bank) array_push($arr_header,"Bank Name");
								if($_export_bank) array_push($arr_header,"Bank Account");
								array_push($arr_header,"THP");
								if(!$_isexport) array_push($arr_header,"<div onclick=\"sorting('created_at');\">Created At</div>");
								if(!$_isexport) array_push($arr_header,"<div onclick=\"sorting('created_by');\">Created By</div>");
								echo $t->header($arr_header);

								foreach($employee_payrolls as $no => $employee_payroll){
									$actions = "<a href=\"employee_payrolls_add.php?regenerate=1&employee_id=".$employee_payroll["employee_id"]."&periode=".$employee_payroll["periode"]."\">ReGenerate</a> | 
												<a href='#' onclick=\"if(confirm('Are You sure want to delete this employee payroll?')){window.location='?deleting=".$employee_payroll["employee_id"]."&periode=".$employee_payroll["periode"]."&project=".$_GET["project"]."';}\">Delete</a> | 
												<a target='_BLANK' href=\"employee_payrolls_view.php?employee_id=".$employee_payroll["employee_id"]."&periode=".$employee_payroll["periode"]."\">View</a>";
									$employee = $db->fetch_all_data("employees",[],"id = '".$employee_payroll["employee_id"]."'")[0];
									$fixed = $db->fetch_single_data("employee_payrolls","concat(sum(amount))",["employee_id" => $employee_payroll["employee_id"],"periode" => $_GET["periode"],"payroll_type_id" => "1"]);
									$variable = $db->fetch_single_data("employee_payrolls","concat(sum(amount))",["employee_id" => $employee_payroll["employee_id"],"periode" => $_GET["periode"],"payroll_type_id" => "2"]);
									$tax = $db->fetch_single_data("employee_payrolls","amount",["employee_id" => $employee_payroll["employee_id"],"periode" => $_GET["periode"],"payroll_type_id" => "4","payroll_item_id" => "59"]);
									$deduction = $db->fetch_single_data("employee_payrolls","concat(sum(amount))",["employee_id" => $employee_payroll["employee_id"],"periode" => $_GET["periode"],"payroll_type_id" => "4"]);
									$bank_name = $db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_payroll["employee_id"], "param" => "Bank Name:LIKE", "valid_at" => $_GET["periode"].":<="],["valid_at DESC, id DESC"]);
									$bank_account = $db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_payroll["employee_id"], "param" => "Bank Account:LIKE", "valid_at" => $_GET["periode"].":<="],["valid_at DESC, id DESC"]);
									$thp = $fixed + $variable - $deduction;
									$arr_row = [];
									$arr_row_attr = [];
									array_push($arr_row,$no+$start+1);
									if(!$_isexport) array_push($arr_row,$actions);
									array_push($arr_row,$employee["code"]);
									array_push($arr_row,$employee["name"]);
									if(!$_export_bank) array_push($arr_row,format_amount($fixed));
									if(!$_export_bank) array_push($arr_row,format_amount($variable));
									if(!$_export_bank) array_push($arr_row,format_amount($tax));
									if(!$_export_bank) array_push($arr_row,format_amount($deduction));
									if($_export_bank) array_push($arr_row,$bank_name);
									if($_export_bank) array_push($arr_row,$bank_account."&nbsp;");
									array_push($arr_row,"<b>".format_amount($thp)."</b>");
									if(!$_isexport) array_push($arr_row,format_tanggal($employee_payroll["created_at"]));
									if(!$_isexport) array_push($arr_row,$employee_payroll["created_by"]);

									array_push($arr_row_attr,"align='right' valign='top'");
									if(!$_isexport) array_push($arr_row_attr,"");
									array_push($arr_row_attr,"");
									array_push($arr_row_attr,"");
									if(!$_export_bank) array_push($arr_row_attr,"align='right' valign='top'");
									if(!$_export_bank) array_push($arr_row_attr,"align='right' valign='top'");
									if(!$_export_bank) array_push($arr_row_attr,"align='right' valign='top'");
									if(!$_export_bank) array_push($arr_row_attr,"align='right' valign='top'");
									if($_export_bank) array_push($arr_row_attr,"");
									if($_export_bank) array_push($arr_row_attr,"");
									array_push($arr_row_attr,"align='right' valign='top'");
									if(!$_isexport) array_push($arr_row_attr,"");
									echo $t->row($arr_row,$arr_row_attr);
								}
								?>
							<?=$t->end();?>
						</div>
					</div>
			<?php } ?>
		</div>
	</section>
	<!--//Table-->

<?php
	include_once "footer.php";
	include_once "a_pop_up_js.php";
?>
</body>
</html>