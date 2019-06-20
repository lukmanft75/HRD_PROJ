<?php
	include_once "head.php";
	include_once "generate_payroll.php";
?>
	<!--form -->
	<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="container">
			<div class="sub-head mb-3 ">
				<h4>Generate Employees Payrolls</h4>
			</div>
			<div class="info-para">
				<?php
					if(isset($_GET["regenerate"])){
						$_GET["project"] = $db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $_GET["employee_id"],"param" => "Project:LIKE","valid_at" => $_GET["periode"].":<="],["valid_at DESC","id DESC"]);
						$_GET["generate"] = "Generate";
						$_GET["periode"] = substr($_GET["periode"],0,7);
					}
					
					if(is_array($_SESSION["GET"]["employee_payrolls_list"]) && !isset($_GET["generate"])) $_GET = $_SESSION["GET"]["employee_payrolls_list"];
					
					if(!$_GET["periode"]) $_GET["periode"] = date("Y-m");
					$periode = $f->input("periode",$_GET["periode"],"type='month'","form-control");
					// $project = $f->select("project",$db->fetch_select_data("projects","id","name",[],["id"],"",true),$_GET["project"],"","select_form_tb");
					$_periode = $_GET["periode"]."-".date("t",mktime(0,0,0,substr($_GET["periode"],5,2),1,substr($_GET["periode"],0,4)));
				?>
				<?=$f->start("","GET");?>
					<?=$t->start("","editor_content");?>
						<?=$t->row(["Periode",$periode]);?>
						<!--
							<?=$t->row(["Project",$project]);?>
						-->
					<?=$t->end();?>
					<?=$f->input("generate","Generate","type='submit'","btn btn-primary");?>
					<?=$f->input("back","Back","type='button' onclick=\"window.location='employee_payrolls_list.php?periode=".$_GET["periode"]."&project=".$_GET["project"]."&do_filter=Load';\"","btn btn-secondary");?>
				<?=$f->end();?>

				<?php
					if(isset($_GET["generate"])){
						if(date("Y-m") < $_GET["periode"]){
							echo "Date cannot exceed this time!";
						} else {
							if(isset($_GET["employee_id"]))
								$employees = $db->fetch_all_data("employees",[],"id='".$_GET["employee_id"]."'");
							else
								// $employees = $db->fetch_all_data("employees",[],"id IN (SELECT employee_id FROM employee_payroll_params WHERE param LIKE 'Project' AND params_value = '".$_GET["project"]."')");
								$employees = $db->fetch_all_data("employees",[],"id IN (SELECT employee_id FROM employee_payroll_params)");
							
							
							foreach($employees as $key => $employee){
								// $current_project_id = $db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee["id"],"param" => "Project:LIKE","valid_at" => $_periode.":<="],["valid_at DESC","id DESC"]);
								$current_project_id = $db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee["id"],"valid_at" => $_periode.":<="],["valid_at DESC","id DESC"]);

								// if($current_project_id == $_GET["project"]){//make sure last project is valid
									$no++;
									$generating = generate_payroll($_GET["periode"],$employee["id"]);
									echo $no.". ".$employee["code"]." -- ".$employee["name"]." ==> ".$generating["result"]."&nbsp;<b><a target='_BLANK' href=\"employee_payrolls_view.php?employee_id=".$employee["id"]."&periode=".$_GET["periode"]."-01"."\" style='color:#013fa5; font-weight:bolder; font-style:italic;'>View</a></b><br>";
								// }
							}
						}
					}
				?>
			</div>
		</div>
	</section>
    <!--//form  -->

<?php
	include_once "footer.php";
?>
</body>
</html>