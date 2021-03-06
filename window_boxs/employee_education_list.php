<?php include_once "wb_head.php" ;?>
<body>			
	<?php
		$db->addtable("employee_educations");
		if($_GET["employee_id"] > 0) {
			$employee_id 	= $_GET["employee_id"];
			$db->awhere("employee_id = '".$employee_id."'");
		}
		$employee_educations = $db->fetch_data(true);
		
		if($_GET["deleting"]){
			$db->addtable("employee_educations");	$db->where("id",$_GET["deleting"]);
			$deleting = $db->delete_();
			$_SESSION["alert_success"] = "Data deleted successfully!";
			?>
				<script type="text/JavaScript">setTimeout("location.href = '?employee_id=<?=$employee_id;?>';",1500);</script>
			<?php
		}
	?>
	
	<div class="modal-body" id="List">
		<div class="login mx-auto mw-100">
			<h5 class="text-center">Employee Educations</h5>
			<?php include_once "../a_notification.php"; ?>
			<div class="table_list">
				<div style="overflow-x:auto;">
					<?=$t->start("","","data_content");?>
						<?=$t->header(["No","Action","Degree","Institution","City","Major","Graduation Year","GPA"]);?>
						<?php 
							$i=0;
							foreach($employee_educations as $no => $data){
								$i++;
								$actions = 	"<img src='../images/edit.png' style='width:20px; height:20px;' title='Edit' onclick=\"window.location='".str_replace("_list","_edit",$_SERVER["PHP_SELF"])."?data_id=".$data["id"]."&employee_id=".$employee_id."';\" '>";
								$actions .= "<img src='../images/vertical.png' style='width:20px; height:20px;'>";
								$actions .= "<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$data["id"]."&employee_id=".$employee_id."';}\"><img src='../images/cancel.png' style='width:20px; height:20px;' title='Delete'></a>";
								$degree	= $db->fetch_single_data("degrees","name",["id" => $data["degree_id"]]);
								
								echo $t->row([$i,
											$actions,
											$degree,
											$data["institution"],
											$data["city"],
											$data["major"],
											$data["graduation_year"],
											$data["gpa"]],
											["align='right' width='3%'",
											"",
											"",
											"",
											"",
											"",
											"align='right'",
											"align='right'"]);
							}
						?>
					<?=$t->end();?>
				</div>
			</div>
				<?=$f->input("add","Add","type='button' onclick=\"window.location='".str_replace("_list","_add",$_SERVER["PHP_SELF"])."?employee_id=".$employee_id."';\"","btn btn-info");?>
		</div>
	</div>
</body>			
