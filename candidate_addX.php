<?php include_once "head.php";?>
<div class="bo_title">Add Candidate</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("candidates");
		$db->addfield("name");			$db->addvalue($_POST["name"]);
		$db->addfield("nickname");		$db->addvalue($_POST["nickname"]);
		$db->addfield("birthdate");		$db->addvalue($_POST["birthdate"]);
		$db->addfield("birthplace");	$db->addvalue($_POST["birthplace"]);
		$db->addfield("sex");			$db->addvalue($_POST["sex"]);
		$db->addfield("status_id");		$db->addvalue($_POST["status_id"]);
		$db->addfield("religion");		$db->addvalue($_POST["religion"]);
		$db->addfield("nationality");	$db->addvalue($_POST["nationality"]);
		$db->addfield("address");		$db->addvalue($_POST["address"]);
		$db->addfield("address_owner");	$db->addvalue($_POST["address_owner"]);
		$db->addfield("phone");			$db->addvalue($_POST["phone"]);
		$db->addfield("phone_2");		$db->addvalue($_POST["phone_2"]);
		$db->addfield("bank_name");		$db->addvalue($_POST["bank_name"]);
		$db->addfield("bank_account");	$db->addvalue($_POST["bank_account"]);
		$db->addfield("bank_holder_name");$db->addvalue($_POST["bank_holder_name"]);
		$db->addfield("no_kk");			$db->addvalue($_POST["no_kk"]);
		$db->addfield("ktp");			$db->addvalue($_POST["ktp"]);
		$db->addfield("npwp");			$db->addvalue($_POST["npwp"]);
		$db->addfield("email");			$db->addvalue($_POST["email"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] >= 0){
			javascript("alert('Data Saved');");
			javascript("window.location='".str_replace("_add","_edit",$_SERVER["PHP_SELF"])."?id=".$inserting["insert_id"]."';");
		} else {
			javascript("alert('Saving data failed');");
		}
	}
	
	$name = $f->input("name",@$_POST["name"],"style='width:100%'");
	$nickname = $f->input("nickname",@$_POST["nickname"],"style='width:100%'");
	$birthdate = $f->input("birthdate",@$_POST["birthdate"],"type='date'");
	$birthplace = $f->input("birthplace",@$_POST["birthplace"],"style='width:100%'");
	$sex = $f->select("sex",array("M" => "M", "F" => "F"),@$_POST["sex"],"style='height:25px'");
	$status_id = $f->select("status_id",$db->fetch_select_data("statuses","id","name",[],[],"",true),@$_POST);
	$religion = $f->input("religion",@$_POST["religion"],"style='width:100%'");
	$nationality = $f->input("nationality",@$_POST["nationality"],"style='width:100%'");
	$address = $f->textarea("address",$_POST["address"]);
	$address_owner = $f->select("address_owner",["own" => "Own","parent_family" => "Parent/Familiy","rent_lease" => "Rent/Lease"],@$_POST["address_owner"]);
	$phone = $f->input("phone",$_POST["phone"],"style='width:100%'");
	$phone_2 = $f->input("phone_2",$_POST["phone_2"],"style='width:100%'");
	$bank_name = $f->input("bank_name",$_POST["bank_name"],"style='width:100%'");
	$bank_account = $f->input("bank_account",$_POST["bank_account"],"style='width:100%'");
	$bank_holder_name = $f->input("bank_holder_name",$_POST["bank_holder_name"],"style='width:100%'");
	$no_kk = $f->input("no_kk",$_POST["no_kk"],"style='width:100%'");
	$ktp = $f->input("ktp",$_POST["ktp"],"style='width:100%'");
	$npwp = $f->input("npwp",$_POST["npwp"],"style='width:100%'");
	$email = $f->input("email",$_POST["email"],"style='width:100%'");
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
         <?=$t->row(["Name",$name]);?>
         <?=$t->row(["Nickname",$nickname]);?>
         <?=$t->row(["Birthplace",$birthplace]);?>
         <?=$t->row(["Birthdate",$birthdate]);?>
         <?=$t->row(["Sex",$sex]);?>
         <?=$t->row(["Status",$status_id]);?>
         <?=$t->row(["Address",$address]);?>
         <?=$t->row(["Owner of the address",$address_owner]);?>
         <?=$t->row(["Phone",$phone]);?>
         <?=$t->row(["HandPhone",$phone_2]);?>
         <?=$t->row(["Bank Name",$bank_name]);?>
         <?=$t->row(["Bank Account",$bank_account]);?>
         <?=$t->row(["Bank Holder Name",$bank_holder_name]);?>
         <?=$t->row(["No KK",$no_kk]);?>
         <?=$t->row(["NIK",$ktp]);?>
         <?=$t->row(["NPWP",$npwp]);?>
         <?=$t->row(["Email",$email]);?>
	<?=$t->end();?>
	<br>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>