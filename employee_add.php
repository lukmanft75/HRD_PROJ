<?php
	include_once "head.php";
	include_once "employee_func.php";
	
	if(isset($_POST["save"])){
		$code = get_valid_code($_POST["code_employee"]);
		$_POST["phone"] = msisdn_format($_POST["phone"]);
		$db->addtable("employees");
		$db->addfield("code");				$db->addvalue($code);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("birthplace");		$db->addvalue($_POST["birthplace"]);
		$db->addfield("birthdate");			$db->addvalue($_POST["birthdate"]);
		$db->addfield("sex");				$db->addvalue($_POST["sex"]);
		$db->addfield("status_id");			$db->addvalue($_POST["status_id"]);
		$db->addfield("address");			$db->addvalue($_POST["address"]);
		$db->addfield("address_2");			$db->addvalue($_POST["address_2"]);
		$db->addfield("address_3");			$db->addvalue($_POST["address_3"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("phone_2");			$db->addvalue($_POST["phone_2"]);
		$db->addfield("bank_name");			$db->addvalue($_POST["bank_name"]);
		$db->addfield("bank_account");		$db->addvalue($_POST["bank_account"]);
		$db->addfield("bank_holder_name");	$db->addvalue($_POST["bank_holder_name"]);
		$db->addfield("ktp");				$db->addvalue($_POST["ktp"]);
		$db->addfield("npwp");				$db->addvalue($_POST["npwp"]);
		$db->addfield("email");				$db->addvalue($_POST["email"]);
		$db->addfield("join_indohr_at");	$db->addvalue($_POST["join_indohr_at"]);
		$db->addfield("employed_as_csr");	$db->addvalue($_POST["employed_as_csr"]);
		$db->addfield("emergency_no1");			$db->addvalue($_POST["emergency_no1"]);
		$db->addfield("emergency_name1");		$db->addvalue($_POST["emergency_name1"]);
		$db->addfield("emergency_relation1");	$db->addvalue($_POST["emergency_relation1"]);
		$db->addfield("emergency_no2");			$db->addvalue($_POST["emergency_no2"]);
		$db->addfield("emergency_name2");		$db->addvalue($_POST["emergency_name2"]);
		$db->addfield("emergency_relation2");	$db->addvalue($_POST["emergency_relation2"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] >= 0){
			$_SESSION["alert_success"] = "Data saved successfully!";
			 ?><script type="text/JavaScript">setTimeout("location.href = '<?=str_replace("_add","_edit",$_SERVER["PHP_SELF"])."?".url_encode("employee_id")."=".url_encode($inserting["insert_id"]);?>';",1500);</script><?php
			
		} else {
			$_SESSION["alert_danger"] = "Failed to saved!";
		}
	}
?>
	<!--form -->
	<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="container">
			<?php include_once "a_notification.php"; ?>
			<div class="sub-head mb-3 ">
				<h4>Employee Add</h4>
			</div>
			<div class="info-para">
				<?=$f->input("code_generate","","type='hidden' style='width: 1px !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_generator_code.php?employee_id=".$id."&updating_table=false\")'", "");?>
				<?=$f->start();?>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Code</font>
							<?=$f->input("code_employee",@$_POST["code_employee"],"placeholder='Please Generate Here!' onclick='generate_code();' readonly","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Name</font>
							<?=$f->input("name",@$_POST["name"],"placeholder='' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Birthplace</font>
							<?=$f->input("birthplace",@$_POST["birthplace"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Birthdate</font>
							<?=$f->input("birthdate",@$_POST["birthdate"],"placeholder='' type='date' style='height:43px;'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Sex</font>
							<?=$f->select("sex",[""=>"","M"=>"M","F"=>"F"],@$_POST["sex"],"required","select_form");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Marital Status</font>
							<?=$f->select("status_id",$db->fetch_select_data("statuses","id","name",[],[],"",true),@$_POST["status_id"],"required","select_form");?>						</div>
					</div>
					<div class="form-group contact-forms">
						<font style="color:#1a75ff;font-style:italic;">Address</font>
						<?=$f->textarea("address",@$_POST["address"],"placeholder='' rows='3'","form-control");?>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Additional Address 1</font>
							<?=$f->textarea("address_2",@$_POST["address_2"],"placeholder='' rows='3'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Additional Address 2</font>
							<?=$f->textarea("address_3",@$_POST["address_3"],"placeholder='' rows='3'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Handphone</font>
							<?=$f->input("phone",@$_POST["phone"],"placeholder='' type='number'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Emergency Phone</font>
							<?=$f->input("phone_2",@$_POST["phone_2"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Name</font>
							<?=$f->input("bank_name",@$_POST["bank_name"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Account</font>
							<?=$f->input("bank_account",@$_POST["bank_account"],"placeholder='' type='number'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Holder Name</font>
							<?=$f->input("bank_holder_name",@$_POST["bank_holder_name"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">NIK</font>
							<?=$f->input("ktp",@$_POST["ktp"],"placeholder='' type='number' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">NPWP</font>
							<?=$f->input("npwp",@$_POST["npwp"],"placeholder='' type='number'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Email</font>
							<?=$f->input("email",@$_POST["email"],"placeholder='' type='email'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Join Date</font>
							<?=$f->input("join_indohr_at",@$_POST["join_indohr_at"],"placeholder='' type='date'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Employee As CSR</font>
							<?=$f->select("employed_as_csr",array("1"=>"No","2"=>"Yes"),@$_POST["employed_as_csr"],"required","select_form");?>
						</div>
					</div>
					<br>
					Emergency Contact 1
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Phone Number</font>
							<?=$f->input("emergency_no1",@$_POST["emergency_no1"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Name</font>
							<?=$f->input("emergency_name1",@$_POST["emergency_name1"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Relationship</font>
							<?=$f->input("emergency_relation1",@$_POST["emergency_relation1"],"placeholder=''","form-control");?>
						</div>
					</div>
					<br>
					Emergency Contact 2
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Phone Number</font>
							<?=$f->input("emergency_no2",@$_POST["emergency_no2"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Name</font>
							<?=$f->input("emergency_name2",@$_POST["emergency_name2"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Relationship</font>
							<?=$f->input("emergency_relation2",@$_POST["emergency_relation2"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="text-left click-subscribe">
						<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
						<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-secondary");?>
					</div>
				<?=$f->end();?>
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
</script>
</body>
</html>