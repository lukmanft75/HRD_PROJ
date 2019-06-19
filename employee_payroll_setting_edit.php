<?php
	include_once "head.php";
	include_once "employee_func.php";
	$id = GET_url_decode("employee_id");
	$_DATA = $db->fetch_all_DATA("employees",[],"id='".$id."'")[0];
	
	if(isset($_POST["save"])){
		$code = get_valid_code($_POST["code_employee"]);
		$_POST["phone"] = msisdn_format($_POST["phone"]);
		
		$db->addtable("employees");				$db->where("id",$id);
		$db->addfield("code");					$db->addvalue($code);
		$db->addfield("name");					$db->addvalue($_POST["name"]);
		$db->addfield("birthplace");			$db->addvalue($_POST["birthplace"]);
		$db->addfield("birthdate");				$db->addvalue($_POST["birthdate"]);
		$db->addfield("sex");					$db->addvalue($_POST["sex"]);
		$db->addfield("status_id");				$db->addvalue($_POST["status_id"]);
		$db->addfield("address");				$db->addvalue($_POST["address"]);
		$db->addfield("address_2");				$db->addvalue($_POST["address_2"]);
		$db->addfield("address_3");				$db->addvalue($_POST["address_3"]);
		$db->addfield("phone");					$db->addvalue($_POST["phone"]);
		$db->addfield("phone_2");				$db->addvalue($_POST["phone_2"]);
		$db->addfield("bank_name");				$db->addvalue($_POST["bank_name"]);
		$db->addfield("bank_account");			$db->addvalue($_POST["bank_account"]);
		$db->addfield("bank_holder_name");		$db->addvalue($_POST["bank_holder_name"]);
		$db->addfield("ktp");					$db->addvalue($_POST["ktp"]);
		$db->addfield("npwp");					$db->addvalue($_POST["npwp"]);
		$db->addfield("email");					$db->addvalue($_POST["email"]);
		$db->addfield("join_indohr_at");		$db->addvalue($_POST["join_indohr_at"]);
		$db->addfield("employed_as_csr");		$db->addvalue($_POST["employed_as_csr"]);
		$db->addfield("emergency_no1");			$db->addvalue($_POST["emergency_no1"]);
		$db->addfield("emergency_name1");		$db->addvalue($_POST["emergency_name1"]);
		$db->addfield("emergency_relation1");	$db->addvalue($_POST["emergency_relation1"]);
		$db->addfield("emergency_no2");			$db->addvalue($_POST["emergency_no2"]);
		$db->addfield("emergency_name2");		$db->addvalue($_POST["emergency_name2"]);
		$db->addfield("emergency_relation2");	$db->addvalue($_POST["emergency_relation2"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			$_SESSION["alert_success"] = "Data updated successfully!";
			 ?><script type="text/JavaScript">setTimeout("location.href = '<?=$__base_url;?>';",1500);</script><?php
		} else {
			$_SESSION["alert_danger"] = "Failed to saved!";
		}
	}
	
	if(isset($_POST["save_parameters"])){
		foreach($_POST["param"] as $key => $param_name){
			$param = $db->fetch_all_data("employee_payroll_params",[],"employee_id = '".$id."' AND param LIKE '".$param_name."'","valid_at DESC,id DESC")[0];

			if($param["valid_at"] == $_POST["valid_at"][$key]) $is_editing = true;
			else $is_editing = false;

			$db->addtable("employee_payroll_params");
			if($is_editing){
				$db->where("id",$param["id"]);
			} else {
				$db->addfield("employee_id");	$db->addvalue($id);
				$db->addfield("valid_at");		$db->addvalue($_POST["valid_at"][$key]);
			}
			$db->addfield("param");			$db->addvalue($param_name);
			$db->addfield("params_value");	$db->addvalue($_POST["params_value"][$key]);

			if($is_editing){
				$inserting = $db->update();
			} else {
				$inserting = $db->insert();
			}
		}
		$_SESSION["alert_success"] = "Params updated successfully!";
	}
	
	if(isset($_POST["save_fixed"])){
		$db->addtable("employee_payroll_setting");	
		$db->addfield("employee_id");		$db->addvalue($id);
		$db->addfield("payroll_type_id");	$db->addvalue(1);
		$db->addfield("valid_at");			$db->addvalue($_POST["valid_at"]);
		$db->addfield("name");				$db->addvalue($_POST["payroll_item_name"]);
		$db->addfield("percentage");		$db->addvalue($_POST["percentage"]);
		$db->addfield("nominal");			$db->addvalue($_POST["nominal"]);
		$db->addfield("taxable");			$db->addvalue($_POST["taxable"]);
		$db->addfield("excluding_thp");		$db->addvalue($_POST["excluding_thp"]);
		$inserting = $db->insert();
		$_SESSION["alert_success"] = "Others updated successfully!";
	}
	
	if(isset($_POST["edit_fixed"])){
		$employee_payroll_setting_id = $_POST["employee_payroll_setting_id"];
		$valid_at = $db->fetch_single_data("employee_payroll_setting","valid_at",["id" => $employee_payroll_setting_id]);

		if($valid_at == $_POST["valid_at"]) $is_editing = true;
		else $is_editing = false;

		$db->addtable("employee_payroll_setting");	
		if($is_editing){
			$db->where("id",$employee_payroll_setting_id);
		} else {
			$db->addfield("employee_id");		$db->addvalue($id);
			$db->addfield("payroll_type_id");	$db->addvalue(1);
			$db->addfield("valid_at");			$db->addvalue($_POST["valid_at"]);
		}
		$db->addfield("name");				$db->addvalue($_POST["payroll_item_name"]);
		$db->addfield("percentage");		$db->addvalue($_POST["percentage"]);
		$db->addfield("nominal");			$db->addvalue($_POST["nominal"]);
		$db->addfield("taxable");			$db->addvalue($_POST["taxable"]);
		$db->addfield("excluding_thp");		$db->addvalue($_POST["excluding_thp"]);
		if($is_editing){
			$inserting = $db->update();
		} else {
			$inserting = $db->insert();
		}
	}
	
	if(isset($_POST["save_variable"]) || isset($_POST["save_tax"]) || isset($_POST["save_deduction"])){
		if(isset($_POST["save_variable"])) $payroll_type_id = 2;
		if(isset($_POST["save_tax"])) $payroll_type_id = 3;
		if(isset($_POST["save_deduction"])) $payroll_type_id = 4;
	    if($_POST["payroll_item_id"] > 0) $payroll_item_name = $db->fetch_single_data("payroll_items","name",["id" => $_POST["payroll_item_id"]]);
	    if($payroll_item_name != "") $_POST["payroll_item_name"] = $payroll_item_name;
	    if(!$_POST["payroll_item_id"] && $_POST["payroll_item_name"]){//new payroll_items
	    	$payroll_item_id = $db->fetch_single_data("payroll_items","id",["name" => $_POST["payroll_item_name"].":LIKE"]);
	    	if($payroll_item_id <= 0){
				$db->addtable("payroll_items");	
				$db->addfield("payroll_type_id");	$db->addvalue($payroll_type_id);
				$db->addfield("name");				$db->addvalue($_POST["payroll_item_name"]);
				$inserting = $db->insert();
				$_POST["payroll_item_id"] = $inserting["insert_id"];
			} else {
				$_POST["payroll_item_id"] = $payroll_item_id;
			}
	    }
	    if(stripos(" ".$_POST["payroll_item_name"], "reimb") > 0) $_POST["taxable"] = 0;
		$db->addtable("employee_payroll_setting");	
		$db->addfield("employee_id");		$db->addvalue($id);
		$db->addfield("payroll_type_id");	$db->addvalue($payroll_type_id);
		$db->addfield("payroll_item_id");	$db->addvalue($_POST["payroll_item_id"]);
		$db->addfield("valid_at");			$db->addvalue($_POST["valid_at"]);
		$db->addfield("name");				$db->addvalue($_POST["payroll_item_name"]);
		$db->addfield("percentage");		$db->addvalue($_POST["percentage"]);
		$db->addfield("nominal");			$db->addvalue($_POST["nominal"]);
		$db->addfield("taxable");			$db->addvalue($_POST["taxable"]);
		$db->addfield("excluding_thp");		$db->addvalue($_POST["excluding_thp"]);
		$inserting = $db->insert();
	}
	
	if(isset($_POST["edit_variable"]) || isset($_POST["edit_tax"]) || isset($_POST["edit_deduction"])){
		if(isset($_POST["edit_variable"])) $payroll_type_id = 2;
		if(isset($_POST["edit_tax"])) $payroll_type_id = 3;
		if(isset($_POST["edit_deduction"])) $payroll_type_id = 4;
		$employee_payroll_setting_id = $_POST["employee_payroll_setting_id"];
		$valid_at = $db->fetch_single_data("employee_payroll_setting","valid_at",["id" => $employee_payroll_setting_id]);
		if($_POST["payroll_item_id"] > 0) $payroll_item_name = $db->fetch_single_data("payroll_items","name",["id" => $_POST["payroll_item_id"]]);
	    if($payroll_item_name != "") $_POST["payroll_item_name"] = $payroll_item_name;
	    if(!$_POST["payroll_item_id"] && $_POST["payroll_item_name"]){//new payroll_items
	    	$payroll_item_id = $db->fetch_single_data("payroll_items","id",["name" => $_POST["payroll_item_name"].":LIKE"]);
	    	if($payroll_item_id <= 0){
				$db->addtable("payroll_items");	
				$db->addfield("payroll_type_id");	$db->addvalue($payroll_type_id);
				$db->addfield("name");				$db->addvalue($_POST["payroll_item_name"]);
				$inserting = $db->insert();
				$_POST["payroll_item_id"] = $inserting["insert_id"];
			} else {
				$_POST["payroll_item_id"] = $payroll_item_id;
			}
	    }

		if($valid_at == $_POST["valid_at"]) $is_editing = true;
		else $is_editing = false;
		if(stripos(" ".$_POST["payroll_item_name"], "reimb") > 0) $_POST["taxable"] = 0;
		$db->addtable("employee_payroll_setting");	
		if($is_editing){
			$db->where("id",$employee_payroll_setting_id);
		} else {
			$db->addfield("employee_id");		$db->addvalue($id);
			$db->addfield("payroll_type_id");	$db->addvalue($payroll_type_id);
			$db->addfield("valid_at");			$db->addvalue($_POST["valid_at"]);
		}
		$db->addfield("payroll_item_id");	$db->addvalue($_POST["payroll_item_id"]);
		$db->addfield("name");				$db->addvalue($_POST["payroll_item_name"]);
		$db->addfield("percentage");		$db->addvalue($_POST["percentage"]);
		$db->addfield("nominal");			$db->addvalue($_POST["nominal"]);
		$db->addfield("taxable");			$db->addvalue($_POST["taxable"]);
		$db->addfield("excluding_thp");		$db->addvalue($_POST["excluding_thp"]);
		if($is_editing){
			$inserting = $db->update();
		} else {
			$inserting = $db->insert();
		}
	}
?>
	<!--form -->
	<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="container">
			<?php include_once "a_notification.php"; ?>
			<div class="sub-head mb-3 ">
				<h4>Employee Edit</h4>
				<?=$f->input("","Courses","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_course_list.php?employee_id=".$id."\")'", "btn btn-info");?>
				<?=$f->input("","Educations","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_education_list.php?employee_id=".$id."\")'", "btn btn-info");?>
				<?=$f->input("","Families","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_family_list.php?employee_id=".$id."\")'", "btn btn-info");?>
				<?=$f->input("","Info","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_info_list.php?employee_id=".$id."\")'", "btn btn-info");?>
				<?=$f->input("","Last Benefits","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_last_benefit_list.php?employee_id=".$id."\")'", "btn btn-info");?>
				<?=$f->input("","Relations","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_relation_list.php?employee_id=".$id."\")'", "btn btn-info");?>
				<?=$f->input("","Work Experiences","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_work_exp_list.php?employee_id=".$id."\")'", "btn btn-info");?>
				<br>
				<div style="padding: 5 0 5 0;">
					<?=$f->input("details","Employee Details","type='button' onclick='employee_details()'", "btn btn-warning");?>
					<?=$f->input("params","Employee Params","type='button' onclick='employee_params()'", "btn btn-warning");?>
					<?=$f->input("others","Employee Payrolls","type='button' onclick='employee_others()'", "btn btn-warning");?>
				</div>
			</div>
			
			<div class="info-para">
				<?=$f->input("code_generate","","type='hidden' style='width: 1px !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_generator_code.php?employee_id=".$id."&updating_table=false\")'", "");?>
				<div  id="employee_details">
					<?=$f->start();?>
					<font style="font-size:18px; font-weight:bolder; color:#013fa5;"><u>Employee Details</u></font>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Code</font>
							<?=$f->input("code_employee",@$_DATA["code"],"placeholder='Please Generate Here!' onclick='generate_code();' readonly","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Name</font>
							<?=$f->input("name",@$_DATA["name"],"placeholder='' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Birthplace</font>
							<?=$f->input("birthplace",@$_DATA["birthplace"],"placeholder='' required","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Birthdate</font>
							<?=$f->input("birthdate",@$_DATA["birthdate"],"placeholder='' type='date' style='height:43px;'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Sex</font>
							<?=$f->select("sex",[""=>"","M"=>"M","F"=>"F"],@$_DATA["sex"],"required","select_form");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Marital Status</font>
							<?=$f->select("status_id",$db->fetch_select_data("statuses","id","name",[],[],"",true),@$_DATA["status_id"],"required","select_form");?>						</div>
					</div>
					<div class="form-group contact-forms">
						<font style="color:#1a75ff;font-style:italic;">Address</font>
						<?=$f->textarea("address",@$_DATA["address"],"placeholder='' rows='3'","form-control");?>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Additional Address 1</font>
							<?=$f->textarea("address_2",@$_DATA["address_2"],"placeholder='' rows='3'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Additional Address 2</font>
							<?=$f->textarea("address_3",@$_DATA["address_3"],"placeholder='' rows='3'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Handphone</font>
							<?=$f->input("phone",@$_DATA["phone"],"placeholder='' type='number'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Emergency Phone</font>
							<?=$f->input("phone_2",@$_DATA["phone_2"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Name</font>
							<?=$f->input("bank_name",@$_DATA["bank_name"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Account</font>
							<?=$f->input("bank_account",@$_DATA["bank_account"],"placeholder='' type='number'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Holder Name</font>
							<?=$f->input("bank_holder_name",@$_DATA["bank_holder_name"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">NIK</font>
							<?=$f->input("ktp",@$_DATA["ktp"],"placeholder='' type='number' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">NPWP</font>
							<?=$f->input("npwp",@$_DATA["npwp"],"placeholder='' type='number'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Email</font>
							<?=$f->input("email",@$_DATA["email"],"placeholder='' type='email'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Join Date</font>
							<?=$f->input("join_indohr_at",@$_DATA["join_indohr_at"],"placeholder='' type='date'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Employee As CSR</font>
							<?=$f->select("employed_as_csr",array("1"=>"No","2"=>"Yes"),@$_DATA["employed_as_csr"],"required","select_form");?>
						</div>
					</div>
					<br>
					Emergency Contact 1
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Phone Number</font>
							<?=$f->input("emergency_no1",@$_DATA["emergency_no1"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Name</font>
							<?=$f->input("emergency_name1",@$_DATA["emergency_name1"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Relationship</font>
							<?=$f->input("emergency_relation1",@$_DATA["emergency_relation1"],"placeholder=''","form-control");?>
						</div>
					</div>
					<br>
					Emergency Contact 2
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Phone Number</font>
							<?=$f->input("emergency_no2",@$_DATA["emergency_no2"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Name</font>
							<?=$f->input("emergency_name2",@$_DATA["emergency_name2"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Relationship</font>
							<?=$f->input("emergency_relation2",@$_DATA["emergency_relation2"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="text-left click-subscribe">
						<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
						<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-secondary");?>
					</div>
					<?=$f->end();?>
				</div>
				<!-- ==================== -->
				<!-- ==================== -->
				<!-- ==================== -->
				<div id="employee_params" style="display:none;">
					<div style="overflow-x:auto;">
						<div class="table_list" style="margin: 0 !important;">
							<?=$f->start();?>
								<?php
									if(substr($_DATA["join_indohr_at"],0,4) < date("Y")) $bulanjoin = 1;
									else $bulanjoin = substr($_DATA["join_indohr_at"],5,2) * 1;
									$ResignDate = $db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $id, "param" => "Resign Date:LIKE", "valid_at" => date("Y")."%:LIKE"],["valid_at DESC, id DESC"]);
									if(substr($ResignDate,0,4) == date("Y")) $bulanend = substr($ResignDate,5,2) * 1;
									else $bulanend = 12;

									$_param["name"][0] = "Bulan join dari,sampai";
									$_param["value"][0] = $bulanjoin.",".$bulanend;
									$_param["name"][1] = "Status";
									$_param["value"][1] = $f->fetch_single_data("statuses","name",["id" => $_DATA["status_id"]]);
									$_param["name"][2] = "NPWP";
									$_param["value"][2] = ($_DATA["npwp"]!="")?"Yes":"No";
									$_param["name"][3] = "Payment Type";
									$_param["value"][3] = "Transfer";
									$_param["name"][4] = "Bank Name";
									$_param["value"][4] = $_DATA["bank_name"];
									$_param["name"][5] = "Bank Account";
									$_param["value"][5] = $_DATA["bank_account"];
									$_param["name"][6] = "Bank Holder Name";
									$_param["value"][6] = $_DATA["bank_holder_name"];
									$_param["name"][7] = "Work Location";
									$_param["value"][7] = "";
									$_param["name"][8] = "Position";
									$_param["value"][8] = "";
									$_param["name"][9] = "Contract Status";
									$_param["value"][9] = "";
									$_param["name"][10] = "Recruitment Status";
									$_param["value"][10] = "";
									$_param["name"][11] = "Point Of Hire";
									$_param["value"][11] = "";
									$_param["name"][12] = "Resign/Termination Date";
									$_param["value"][12] = "";
									foreach($_param["name"] as $key => $param_name){
										if($db->fetch_single_data("employee_payroll_params","id",["employee_id" => $id,"param" => $param_name]) <= 0){
											$db->addtable("employee_payroll_params");
											$db->addfield("employee_id");	$db->addvalue($id);
											$db->addfield("valid_at");		$db->addvalue($_DATA["join_indohr_at"]);
											$db->addfield("param");			$db->addvalue($param_name);
											$db->addfield("params_value");	$db->addvalue($_param["value"][$key]);
											$db->insert();
										} else if($param_name == "Resign Date"){
											$ResignDateId = $db->fetch_single_data("employee_payroll_params","id",["employee_id" => $id, "param" => "Bulan join dari,sampai:LIKE", "params_value" => $bulanjoin.",".$bulanend],["valid_at DESC, id DESC"]);
											if($ResignDateId <= 0){
												$db->addtable("employee_payroll_params");
												$db->addfield("employee_id");	$db->addvalue($id);
												$db->addfield("valid_at");		$db->addvalue(date("Y")."-01-01");
												$db->addfield("param");			$db->addvalue("Bulan join dari,sampai");
												$db->addfield("params_value");	$db->addvalue($bulanjoin.",".$bulanend);
												$db->insert();
											}
										}
									}
								?>
								
								<font style="font-size:18px; font-weight:bolder; color:#013fa5;"><u>Employee Params</u></font>
								<?=$t->start("","data_content");?>
									<?=$t->header(["No.","Parameter","Tanggal Berlaku","Value","History"],["nowrap style='font-weight:bold;font-size:14px;text-align:center;'"]);?>
									<?php 
										foreach($_param["name"] as $key => $param_name){
											$param 				= $db->fetch_all_data("employee_payroll_params",[],"employee_id = '".$id."' AND param LIKE '".$param_name."'","valid_at DESC,id DESC")[0];
											$txt_param 			= $f->input("param[".$key."]",$param["param"],"type='hidden'");
											$txt_valid_at 		= $txt_param.$f->input("valid_at[".$key."]",format_tanggal($param["valid_at"],"Y-m-d"),"type='date'","form-control");
											$txt_params_value 	= $f->input("params_value[".$key."]",$param["params_value"],"","form-control");
											if($key == 1) 	$txt_params_value = $f->select("params_value[".$key."]",["TK"=>"TK","M0"=>"M0","M1"=>"M1","M2"=>"M2","M3"=>"M3"],$param["params_value"],"","select_form_tb");
											if($key == 2) 	$txt_params_value = $f->select("params_value[".$key."]",["Yes"=>"Yes","No"=>"No"],$param["params_value"],"","select_form_tb");
											if($key == 9) 	$txt_params_value = $f->select("params_value[".$key."]",["" => "", "Uji Coba"=>"Uji Coba","PKWT"=>"PKWT","Pegawai Tetap" => "Pegawai Tetap"],$param["params_value"],"","select_form_tb");
											if($key == 10) 	$txt_params_value = $f->select("params_value[".$key."]",["" => "", "Local Desa"=>"Local Desa","Local Reguler"=>"Local Reguler","Nasional" => "Nasional"],$param["params_value"],"","select_form_tb");
											if($key == 12) 	$txt_params_value = $f->input("params_value[".$key."]",format_tanggal($param["params_value"],"Y-m-d"),"type='date'","form-control");
											$view_history = "<img src=\"images/folder.png\" style='width:30px; height:30px;' title='Open Window' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/payroll_params_history_list.php?id=".$param["id"]."\")' >";
											if($key == 10 || $key == 11 || $key == 12){
												$view_history = "";
												$txt_valid_at = $txt_param.$f->input("valid_at[".$key."]",$param["valid_at"],"type='hidden''");
											}
											echo $t->row([($key+1),$param["param"],$txt_valid_at,$txt_params_value,$view_history],
														["align='right' width='3%'","valign='middle'","","","width='5%' align='center'"]);
										}
									?>
								<?=$t->end();?>
								<div style="padding: 5 0 5 0;">
									<?=$f->input("save_parameters","Save","type='submit'","btn btn-primary");?>
									<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-secondary");?>
								</div>
							<?=$f->end();?>
						</div>
					</div>
				</div>
				<!-- ==================== -->
				<!-- ==================== -->
				<!-- ==================== -->
				<div id="employee_others" style="display:none;">
					<div style="overflow-x:auto;">
						<div class="table_list" style="margin: 0 !important;">
								<font style="font-size:18px; font-weight:bolder; color:#013fa5;"><u>Default Fixed Income Setting</u></font>
								<?php
								echo $f->start();
									echo $t->start("","editor_content");
										echo $t->header(["No.","Item","Tanggal Berlaku","%","Nominal","Taxable","History"],["nowrap style='font-weight:bold;font-size:14px;text-align:center;'"]);
										$fixeds = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$id."' AND payroll_type_id='1' AND payroll_item_id > 0 GROUP BY payroll_item_id","payroll_item_id");
										foreach($fixeds as $key => $_fixed){
											$no = $key+1;
											$fixed = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$id."' AND payroll_type_id='1' AND payroll_item_id = '".$_fixed["payroll_item_id"]."'","valid_at DESC,id DESC")[0];
											$txt_payroll_item_id 	= $f->input("payroll_item_name[".$fixed["id"]."]",$fixed["name"],"","form-control");
											$txt_valid_at 			= $f->input("valid_at[".$fixed["id"]."]",$fixed["valid_at"],"type='date'","form-control");
											$txt_percentage 		= $f->input("percentage[".$fixed["id"]."]",$fixed["percentage"],"type='number' step='0.01' style='text-align:right;'","form-control");
											$txt_nominal 			= $f->input("nominal[".$fixed["id"]."]",$fixed["nominal"],"type='number' step='0.01' pattern='([0-9]{1,3}).([0-9]{1,3})' style='text-align:right;'","form-control");
											$checked 				= ($fixed["taxable"]=="1")?"checked":"";
											$chk_taxable 			= $f->input("taxable[".$fixed["id"]."]","1","type='checkbox' style='width:20px; height:20px;' ".$checked);

											$view_history = "<img src=\"images/folder.png\" style='width:30px; height:30px;' title='Open Window' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/payroll_settings_history_list.php?id=".$_fixed["id"]."\")' >";
											echo $t->row([$f->start().$no,$txt_payroll_item_id,$txt_valid_at,$txt_percentage,$txt_nominal,$chk_taxable,$view_history]);
										}
									echo $t->end();
									echo $f->input("save_default_fixed_income","Save","type='submit'","btn btn-primary");
								echo $f->end();
								echo $f->input("focus_default_fixed_income","","style='width:1px;height:1px;border:0px;'");
								?>
							
								<hr>
								<br>
								<font style="font-size:18px; font-weight:bolder; color:#013fa5;"><u>Additional Fixed Income Setting</u></font>
								<?php
									echo $t->start("","editor_content");
										echo $t->header(["No.","Item","Tanggal Berlaku","%","Nominal","Taxable","Exc. THP","","History"],["nowrap style='font-weight:bold;font-size:14px;text-align:center;'"]);
										$fixeds = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$id."' AND payroll_type_id='1' AND payroll_item_id = 0 GROUP BY name","id");
										$no = 0;
										foreach($fixeds as $key => $_fixed){
											$no = $key+1;
											$fixed				 	= $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$id."' AND payroll_type_id='1' AND name LIKE '".$_fixed["name"]."'","valid_at DESC,id DESC")[0];
											$txt_payroll_item_id 	= $f->input("employee_payroll_setting_id",$fixed["id"],"type='hidden'");
											$txt_payroll_item_id 	.= $f->input("payroll_item_name",$fixed["name"],"","form-control");
											$txt_valid_at 			= $f->input("valid_at",$fixed["valid_at"],"type='date'","form-control");
											$txt_percentage 		= $f->input("percentage",$fixed["percentage"],"type='number' step='0.01' style='text-align:right;'","form-control");
											$txt_nominal 			= $f->input("nominal",$fixed["nominal"],"type='number' step='0.01' style='text-align:right;'","form-control");
											$checked				= ($fixed["taxable"]=="1")?"checked":"";
											$chk_taxable 			= $f->input("taxable","1","type='checkbox' style='width:20px; height:20px;' ".$checked);
											$checked 				= ($fixed["excluding_thp"]=="1")?"checked":"";
											$chk_excluding_thp 		= $f->input("excluding_thp","1","type='checkbox' style='width:20px; height:20px;' ".$checked);
											$btn_save 				= $f->input("edit_fixed","Save","type='submit'","btn btn-primary");
											
											$view_history 			= "<img src=\"images/folder.png\" style='width:30px; height:30px;' title='Open Window' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/payroll_settings_history_list.php?id=".$_fixed["id"]."\")' >";
											echo $t->row([$f->start().$no,$txt_payroll_item_id,$txt_valid_at,$txt_percentage,$txt_nominal,$chk_taxable,$chk_excluding_thp,$btn_save.$f->end(),$view_history]);
										}
										$no++;
										$txt_payroll_item_id 		= $f->input("payroll_item_name","","","form-control");
										$txt_valid_at 				= $f->input("valid_at",date("Y-m-d"),"type='date'","form-control");
										$txt_percentage 			= $f->input("percentage","","type='number' step='0.01' style='text-align:right;'","form-control");
										$txt_nominal 				= $f->input("nominal","","type='number' step='0.01' style='text-align:right;'","form-control");
										$chk_taxable 				= $f->input("taxable","1","type='checkbox' style='width:20px; height:20px;' checked","");
										$chk_excluding_thp 			= $f->input("excluding_thp","1","type='checkbox' style='width:20px; height:20px;'");
										$btn_save 					= $f->input("save_fixed","Save","type='submit'","btn btn-primary");
										echo $t->row([$f->start().$no,$txt_payroll_item_id,$txt_valid_at,$txt_percentage,$txt_nominal,$chk_taxable,$chk_excluding_thp,$btn_save.$f->end()]);
									echo $t->end();
									echo $f->input("focus_fixed_income","","style='width:1px;height:1px;border:0px;'");
								?>
							
								<hr>
								<br>
								<font style="font-size:18px; font-weight:bolder; color:#013fa5;"><u>Variable Income</u></font>
								<?php
									echo $t->start("","editor_content");
										echo $t->header(["No.","Item","Tanggal Berlaku","%","Nominal","Taxable","Exc. Thp","","History"],["nowrap style='font-weight:bold;font-size:14px;text-align:center;'"]);
										$fixeds = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$id."' AND payroll_type_id='2' GROUP BY name","id");
										$no = 0;
										foreach($fixeds as $key => $_fixed){
											$no = $key+1;
											$fixed = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$id."' AND payroll_type_id='2' AND name LIKE '".$_fixed["name"]."'","valid_at DESC,id DESC")[0];
											$txt_payroll_item_id 	= $f->input("employee_payroll_setting_id",$fixed["id"],"type='hidden'");
											$txt_payroll_item_id 	.= $f->select("payroll_item_id",$db->fetch_select_data("payroll_items","id","name",["payroll_type_id" => "2"],[],"",true),$fixed["payroll_item_id"],"","select_form_tb");
											$txt_payroll_item_id 	.= "<br>".$f->input("payroll_item_name",$fixed["name"],"","form-control")."<div style='height:7px;'></div>";
											$txt_valid_at 			= $f->input("valid_at",$fixed["valid_at"],"type='date'","form-control");
											$txt_percentage 		= $f->input("percentage",$fixed["percentage"],"type='number' step='0.01' style='text-align:right;'","form-control");
											$txt_nominal 			= $f->input("nominal",$fixed["nominal"],"type='number' step='0.01' style='text-align:right;'","form-control");
											$checked 				= ($fixed["taxable"]=="1")?"checked":"";
											$chk_taxable 			= $f->input("taxable","1","type='checkbox' style='width:20px; height:20px;' ".$checked);
											$checked 				= ($fixed["excluding_thp"]=="1")?"checked":"";
											$chk_excluding_thp 		= $f->input("excluding_thp","1","type='checkbox' style='width:20px; height:20px;' ".$checked);
											$btn_save 				= $f->input("edit_variable","Save","type='submit'","btn btn-primary");
											$view_history 			= "<img src=\"images/folder.png\" style='width:30px; height:30px;' title='Open Window' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/payroll_settings_history_list.php?id=".$_fixed["id"]."\")' >";
											echo $t->row([$f->start().$no,$txt_payroll_item_id,$txt_valid_at,$txt_percentage,$txt_nominal,$chk_taxable,$chk_excluding_thp,$btn_save.$f->end(),$view_history]);
										}
										$no++;
										$txt_payroll_item_id 		= $f->input("employee_payroll_setting_id","","type='hidden'");
										$txt_payroll_item_id 		.= $f->select("payroll_item_id",$db->fetch_select_data("payroll_items","id","name",["payroll_type_id" => "2"],[],"",true),"","","select_form_tb");
										$txt_payroll_item_id 		.= "<br>".$f->input("payroll_item_name","","","form-control");
										$txt_valid_at 				= $f->input("valid_at",date("Y-m-d"),"type='date'","form-control");
										$txt_percentage 			= $f->input("percentage","","type='number' step='0.01' style='text-align:right;'","form-control");
										$txt_nominal 				= $f->input("nominal","","type='number' step='0.01' style='text-align:right;'","form-control");
										$chk_taxable 				= $f->input("taxable","1","type='checkbox' style='width:20px; height:20px;' checked");
										$chk_excluding_thp 			= $f->input("excluding_thp","1","type='checkbox' style='width:20px; height:20px;'");
										$btn_save 					= $f->input("save_variable","Save","type='submit'","btn btn-primary");
										echo $t->row([$f->start().$no,$txt_payroll_item_id,$txt_valid_at,$txt_percentage,$txt_nominal,$chk_taxable,$chk_excluding_thp,$btn_save.$f->end()]);
									echo $t->end();
									echo $f->input("focus_variable_income","","style='width:1px;height:1px;border:0px;'");
								?>
								
								<?php
									$taxs = $db->fetch_all_data("payroll_items",[],"payroll_type_id='3'","id","2");
									foreach($taxs as $key => $tax){
										$percentage = 0;
										if($key == 0) $percentage = 2;
										if($key == 1) $percentage = 1;
										if($db->fetch_single_data("employee_payroll_setting","id",["employee_id" => $id,"payroll_item_id" => $tax["id"]]) <= 0){
											$db->addtable("employee_payroll_setting");
											$db->addfield("employee_id");		$db->addvalue($id);
											$db->addfield("payroll_type_id");	$db->addvalue($tax["payroll_type_id"]);
											$db->addfield("payroll_item_id");	$db->addvalue($tax["id"]);
											$db->addfield("name");				$db->addvalue($tax["name"]);
											$db->addfield("valid_at");			$db->addvalue($employee["join_indohr_at"]);
											$db->addfield("percentage");		$db->addvalue($percentage);
											$db->addfield("taxable");			$db->addvalue(1);
											$db->addfield("excluding_thp");		$db->addvalue(0);
											$db->insert();
										}
									}
								?>
								
								<hr>
								<br>
								<font style="font-size:18px; font-weight:bolder; color:#013fa5;"><u>Deduction</u></font>
								<?php
									$deductions = $db->fetch_all_data("payroll_items",[],"payroll_type_id='4'","id");
									foreach($deductions as $key => $deduction){
										$_settings[$key]["payroll_type_id"] = $deduction["payroll_type_id"];
										$_settings[$key]["payroll_item_id"] = $deduction["id"];
										$_settings[$key]["name"] = $deduction["name"];
										$_settings[$key]["valid_at"] = $employee["join_indohr_at"];
										$percentage = 0;
										if($key == 0) $percentage = 2;
										if($key == 1) $percentage = 0.24;
										if($key == 2) $percentage = 0.3;
										if($key == 3) $percentage = 3.7;
										if($key == 4) $percentage = 2;
										if($key == 5) $percentage = 1;
										if($key == 6) $percentage = 4;
										if($key == 7) $percentage = 1;
										if($key == 8) $percentage = 100;
										$_settings[$key]["percentage"] = $percentage;
										if($db->fetch_single_data("employee_payroll_setting","id",["employee_id" => $id,"payroll_item_id" => $deduction["id"]]) <= 0 && !isset($_POST["edit_deduction"])){
											$db->addtable("employee_payroll_setting");
											$db->addfield("employee_id");		$db->addvalue($id);
											$db->addfield("payroll_type_id");	$db->addvalue($deduction["payroll_type_id"]);
											$db->addfield("payroll_item_id");	$db->addvalue($deduction["id"]);
											$db->addfield("name");				$db->addvalue($deduction["name"]);
											$db->addfield("valid_at");			$db->addvalue($employee["join_indohr_at"]);
											if($percentage > 0){
												$db->addfield("percentage");	$db->addvalue($percentage);
											}
											$db->addfield("taxable");			$db->addvalue(1);
											$db->addfield("excluding_thp");		$db->addvalue(0);
											$db->insert();
										}
									}
									
									echo $t->start("","editor_content");
									echo $t->header(["No.","Item","Tanggal Berlaku","%","Nominal","Taxable","Exc. Thp","","History"],["nowrap style='font-weight:bold;font-size:14px;text-align:center;'"]);
									$fixeds = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$id."' AND payroll_type_id='4' GROUP BY name","id");
									$no = 0;
									foreach($fixeds as $key => $_fixed){
										$no = $key+1;
										$fixed = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$id."' AND payroll_type_id='4' AND name LIKE '".$_fixed["name"]."'","valid_at DESC,id DESC")[0];
										$txt_payroll_item_id 	= $f->input("employee_payroll_setting_id",$fixed["id"],"type='hidden'");
										$txt_payroll_item_id 	.= $f->select("payroll_item_id",$db->fetch_select_data("payroll_items","id","name",["payroll_type_id" => "4"],[],"",true),$fixed["payroll_item_id"],"","select_form_tb");
										$txt_payroll_item_id 	.= "<br>".$f->input("payroll_item_name",$fixed["name"],"","form-control")."<div style='height:7px;'></div>";
										$txt_valid_at 			= $f->input("valid_at",$fixed["valid_at"],"type='date'","form-control");
										$txt_percentage 		= $f->input("percentage",$fixed["percentage"],"type='number' step='0.01' style='text-align:right;'","form-control");
										$txt_nominal 			= $f->input("nominal",$fixed["nominal"],"type='number' step='0.01' style='text-align:right;'","form-control");
										$checked				= ($fixed["taxable"]=="1")?"checked":"";
										$chk_taxable 			= $f->input("taxable","1","type='checkbox' style='width:20px; height:20px;' ".$checked);
										$checked 				= ($fixed["excluding_thp"]=="1")?"checked":"";
										$chk_excluding_thp 		= $f->input("excluding_thp","1","type='checkbox' style='width:20px; height:20px;' ".$checked);
										$view_history 			= "<img src=\"images/folder.png\" style='width:30px; height:30px;' title='Open Window' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/payroll_settings_history_list.php?id=".$_fixed["id"]."\")' >";
										echo $t->row([$f->start().$no,$txt_payroll_item_id,$txt_valid_at,$txt_percentage,$txt_nominal,$chk_taxable,$chk_excluding_thp,$btn_save.$f->end(),$view_history]);
									}
									$no++;
									$txt_payroll_item_id 		= $f->input("employee_payroll_setting_id","","type='hidden'");
									$txt_payroll_item_id 		.= $f->select("payroll_item_id",$db->fetch_select_data("payroll_items","id","name",["payroll_type_id" => "4"],[],"",true),"","","select_form_tb");
									$txt_payroll_item_id 		.= "<br>".$f->input("payroll_item_name","","","form-control");
									$txt_valid_at 				= $f->input("valid_at",date("Y-m-d"),"type='date'","form-control");
									$txt_percentage 			= $f->input("percentage","","type='number' step='0.01' style='text-align:right;'","form-control");
									$txt_nominal 				= $f->input("nominal","","type='number' step='0.01' style='text-align:right;'","form-control");
									$chk_taxable 				= $f->input("taxable","1","type='checkbox' style='width:20px; height:20px;' checked");
									$chk_excluding_thp 			= $f->input("excluding_thp","1","type='checkbox' style='width:20px; height:20px;'");
									$btn_save 					= $f->input("save_deduction","Save","type='submit'","btn btn-primary");
									echo $t->row([$f->start().$no,$txt_payroll_item_id,$txt_valid_at,$txt_percentage,$txt_nominal,$chk_taxable,$chk_excluding_thp,$btn_save.$f->end()]);
								echo $t->end();
								echo $f->input("focus_deduction","","style='width:1px;height:1px;border:0px;'");
							?>
						</div>
					</div>
				</div>
				<!-- ==================== -->
				<!-- ==================== -->
				<!-- ==================== -->
				
			</div>
		</div>
	</section>
    <!--//form  -->

<?php
	include_once "ajax/employees_js.php";
	include_once "footer.php";
	include_once "a_pop_up_js.php";
	include_once "window_boxs/wb_default.php";
?>
<script type="text/javascript"> 
	document.getElementById("name").focus(); 
	
	function employee_params(){
		document.getElementById("employee_others").style.display = "none";
		document.getElementById("employee_details").style.display = "none";
		document.getElementById("employee_params").style.display = "block";
	}
	
	function employee_details(){
		document.getElementById("employee_others").style.display = "none";
		document.getElementById("employee_details").style.display = "block";
		document.getElementById("employee_params").style.display = "none";
	}
	
	function employee_others(){
		document.getElementById("employee_others").style.display = "block";
		document.getElementById("employee_details").style.display = "none";
		document.getElementById("employee_params").style.display = "none";
	}
	
</script>
</body>
</html>