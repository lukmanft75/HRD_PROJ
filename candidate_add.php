<?php
	include_once "head.php";
	
	if(isset($_POST["save"])){
		$errormessage = "";
		$_POST["phone_2"] = msisdn_format($_POST["phone_2"]);
		if($errormessage == ""){
			$db->addtable("candidates");
			$db->addfield("name");				$db->addvalue($_POST["name"]);
			$db->addfield("nickname");			$db->addvalue($_POST["nickname"]);
			$db->addfield("birthdate");			$db->addvalue($_POST["birthdate"]);
			$db->addfield("birthplace");		$db->addvalue($_POST["birthplace"]);
			$db->addfield("sex");				$db->addvalue($_POST["sex"]);
			$db->addfield("status_id");			$db->addvalue($_POST["status_id"]);
			$db->addfield("religion");			$db->addvalue($_POST["religion"]);
			$db->addfield("nationality");		$db->addvalue($_POST["nationality"]);
			$db->addfield("address");			$db->addvalue($_POST["address"][1]);
			$db->addfield("address_2");			$db->addvalue($_POST["address"][2]);
			$db->addfield("address_3");			$db->addvalue($_POST["address"][3]);
			$db->addfield("address_4");			$db->addvalue($_POST["address"][4]);
			$db->addfield("address_owner");		$db->addvalue($_POST["address_owner"]);
			$db->addfield("phone");				$db->addvalue($_POST["phone"]);
			$db->addfield("phone_2");			$db->addvalue($_POST["phone_2"]);
			$db->addfield("bank_name");			$db->addvalue($_POST["bank_name"]);
			$db->addfield("bank_account");		$db->addvalue($_POST["bank_account"]);
			$db->addfield("bank_holder_name");	$db->addvalue($_POST["bank_holder_name"]);
			$db->addfield("no_kk");				$db->addvalue($_POST["no_kk"]);
			$db->addfield("ktp");				$db->addvalue($_POST["ktp"]);
			$db->addfield("npwp");				$db->addvalue($_POST["npwp"]);
			$db->addfield("email");				$db->addvalue($_POST["email"]);
			$inserting = $db->insert();
			if($inserting["affected_rows"] >= 0){
				$_SESSION["alert_success"] = "Data saved successfully!";
				 ?><script type="text/JavaScript">setTimeout("location.href = '<?=str_replace("_add","_list",$_SERVER["PHP_SELF"]);?>';",1500);</script><?php
				
			} else {
				$_SESSION["alert_danger"] = "Failed to saved!";
			}
		} else {
			$_SESSION["alert_danger"] = $errormessage;
		}
	}
?>
	<!--form -->
	<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="container">
			<?php include_once "a_notification.php"; ?>
			<div class="sub-head mb-3 ">
				<h4>Candidate Add</h4>
			</div>
			<div class="info-para">
				<?=$f->start();?>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Name</font>
							<?=$f->input("name",@$_POST["name"],"placeholder='' required","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Nickname</font>
							<?=$f->input("nickname",@$_POST["nickname"],"placeholder=''","form-control");?>
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
							<?=$f->select("status_id",$db->fetch_select_data("statuses","id","name",[],[],"",true),@$_POST["status_id"],"required","select_form");?>
						</div>
					</div>
					<div class="form-group contact-forms">
						<font style="color:#1a75ff;font-style:italic;">Address</font>
						<?=$f->textarea("address[1]",@$_POST["address"][1],"placeholder='' rows='3'","form-control");?>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Sub-District</font>
							<?=$f->input("address[2]",@$_POST["address"][2],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">City</font>
							<?=$f->input("address[3]",@$_POST["address"][3],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Province</font>
							<?=$f->input("address[4]",@$_POST["address"][4],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Nationality</font>
							<?=$f->input("nationality",@$_POST["nationality"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Owner of the address</font>
							<?=$f->select("address_owner",["own" => "Own","parent_family" => "Parent/Familiy","rent_lease" => "Rent/Lease"],@$_POST["address_owner"],"","select_form");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Religion</font>
							<?=$f->input("religion",@$_POST["religion"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Phone</font>
							<?=$f->input("phone",@$_POST["phone"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Handphone</font>
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
							<?=$f->input("bank_account",@$_POST["bank_account"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Holder Name</font>
							<?=$f->input("bank_holder_name",@$_POST["bank_holder_name"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Family Card Number</font>
							<?=$f->input("no_kk",@$_POST["no_kk"],"placeholder='' type='number'","form-control");?>
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
	include_once "footer.php";
	include_once "a_pop_up_js.php";
?>
<script type="text/javascript"> 
	document.getElementById("name").focus(); 
</script>
</body>
</html>