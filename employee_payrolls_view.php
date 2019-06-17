<?php include_once "head.php"; ?>
<?php
	// $id = GET_url_decode("employee_id");
	// $employee = $db->fetch_all_data("employees",[],"id = '".$id."'")[0];
?>

<?php
	$_periode = $_GET["periode"];
	$employee_id = $_GET["employee_id"];
	$periode = strtoupper(date("F Y",mktime(0,0,0,substr($_periode,5,2),1,substr($_periode,0,4))));
	$employee = $db->fetch_all_data("employees",[],"id='".$employee_id."'")[0];
	$code = strtoupper($employee["code"]);
	$name = strtoupper($employee["name"]);
	$npwp = strtoupper($employee["npwp"]);
	$work_location = strtoupper($db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Work Location:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]));
	$position = strtoupper($db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Position:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]));
	$date_of_position = format_tanggal($db->fetch_single_data("employee_payroll_params","valid_at",["employee_id" => $employee_id, "param" => "Position:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]));
	$join_date = format_tanggal($employee["join_indohr_at"]);
	$payment_type = strtoupper($db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Payment Type:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]));
	$resign_date = format_tanggal($db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Resign Date:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]));
	$bank_name = strtoupper($db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Bank Name:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]));
	$tax_status = strtoupper($db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Status:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]));
	$bank_account = strtoupper($db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Bank Account:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]));

?>
<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="container">
			<div class="info-para" style="margin-left:15% !important;">

			<TABLE>
				<TBODY>
					<TR><TD colspan="10"><font face="tahoma" size="2" color="blue"><b>EMPLOYEE SALARY SLIP</b></font></TD></TR>
					<TR><TD colspan="10"><font face="tahoma" size="2" color="blue"><b><?=$periode;?></b></font></TD></TR>
					<TR></TR>
					<TR>
						<TD><font face="tahoma" size="2"><b>EMPLOYEE</b></font></TD>
						<TD><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD ><font face="tahoma" size="2"><b><?=$code;?> <?=$name;?></b></font></td>
						<td width="20"></td>
						<TD><font face="tahoma" size="2"><b>NPWP</b></font></TD>
						<TD><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD nowrap="nowrap"><font face="tahoma" size="2"><b><?=$npwp;?></b></font></td>
					</TR>
					<TR>
						<TD valign="top"><font face="tahoma" size="2"><b>WORK LOCATION</b></font></TD>
						<TD valign="top"><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD ><font face="tahoma" size="2"><b><?=$work_location;?></b></font></td>
					</TR>		
					<TR>
						<TD ><font face="tahoma" size="2"><b>POSITION</b></font></TD>
						<TD valign="top"><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD width="300"><font face="tahoma" size="2"><b><?=$position;?></b></font></td>
						<td width="20"></td>
						<TD><font face="tahoma" size="2"><b>DATE OF POSITION</b></font></TD>
						<TD><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD nowrap="nowrap"><font face="tahoma" size="2"><b><?=$date_of_position;?></b></font></td>
					</TR>		
					<TR>
						<TD><font face="tahoma" size="2"><b>JOIN DATE</b></font></TD>
						<TD><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD ><font face="tahoma" size="2"><b><?=$join_date;?></b></font></td>
						<td width="20"></td>
						<TD><font face="tahoma" size="2"><b>PAYMENT TYPE</b></font></TD>
						<TD><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD nowrap="nowrap"><font face="tahoma" size="2"><b><?=$payment_type;?></b></font></td>
					</TR>		
					<TR>
						<TD><font face="tahoma" size="2"><b>RESIGN DATE</b></font></TD>
						<TD><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD><font face="tahoma" size="2"><b><?=$resign_date;?></b></font></td>
						<td width="20"></td>
						<TD><font face="tahoma" size="2"><b>BANK NAME</b></font></TD>
						<TD><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD nowrap="nowrap"><font face="tahoma" size="2"><b><?=$bank_name;?></b></font></td>
					</TR>
					<TR>
						<TD><font face="tahoma" size="2"><b>TAX STATUS</b></font></TD>
						<TD><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD><font face="tahoma" size="2"><b><?=$tax_status;?></b></font></td>
						<td width="20"></td>
						<TD><font face="tahoma" size="2"><b>BANK ACCOUNT</b></font></TD>
						<TD><font face="tahoma" size="2"><b>:</b></font></TD>
						<TD nowrap="nowrap"><font face="tahoma" size="2"><b><?=$bank_account;?></b></font></td>
					</TR>										
				</TBODY>
			</TABLE>
			<TABLE>
				<TBODY>
					<tr><td colspan="10" width="650"><hr size="2" color="black"></td></tr>
					<tr>
						<td width="200" ><font face="tahoma" size="2"><b>FIXED INCOME</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b>AMOUNT</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b>YTD</b></font></td>		
						<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																
					</tr>
					<?php
						$total1 = 0;
						$total1Ytd = 0;
						$payrolls = $db->fetch_all_data("employee_payrolls",[],"employee_id='".$employee_id."' AND periode='".$_periode."' AND payroll_type_id = '1'","id");
						foreach($payrolls as $payroll){
							$total1 += $payroll["amount"];
							$total1Ytd += $payroll["ytd"];
					?>
						<tr>
							<td width="200"><font face="tahoma" size="2"><?=strtoupper($payroll["name"]);?></font></td>
							<td width="150" align="right"><font face="tahoma" size="2"><?=format_amount($payroll["amount"]);?>,-</font></td>
							<td width="150" align="right"><font face="tahoma" size="2"><?=format_amount($payroll["ytd"]);?>,-</font></td>
							<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																						
						</tr>
					<?php } ?>
					<tr>
						<td width="200" align="right"><font face="tahoma" size="2"><b>TOTAL FIXED INCOME</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b><?=format_amount($total1);?>,-</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b><?=format_amount($total1Ytd);?>,-</b></font></td>							
						<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																		
					</tr>
				</TBODY>
			</TABLE>
			<TABLE>
				<TBODY>
					<tr><td colspan="10" width="650"><hr size="2" color="black"></td></tr>
					<tr>
						<td width="200" ><font face="tahoma" size="2"><b>VARIABLE INCOME</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b>AMOUNT</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b>YTD</b></font></td>	
						<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																
					</tr>
					<?php
						$total2 = 0;
						$total2Ytd = 0;
						$payrolls = $db->fetch_all_data("employee_payrolls",[],"employee_id='".$employee_id."' AND periode='".$_periode."' AND payroll_type_id = '2'","id");
						foreach($payrolls as $payroll){
							$total2 += $payroll["amount"];
							$total2Ytd += $payroll["ytd"];
							if(strtoupper($payroll["name"]) == "TAX") $payroll["name"] = "Tunjangan Pajak";
					?>
						<tr>
							<td width="200"><font face="tahoma" size="2"><?=strtoupper($payroll["name"]);?></font></td>
							<td width="150" align="right"><font face="tahoma" size="2"><?=format_amount($payroll["amount"]);?>,-</font></td>
							<td width="150" align="right"><font face="tahoma" size="2"><?=format_amount($payroll["ytd"]);?>,-</font></td>
							<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																						
						</tr>
					<?php } ?>
					<tr>
						<td width="200" align="right"><font face="tahoma" size="2"><b>TOTAL VARIABLE INCOME</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b><?=format_amount($total2);?>,-</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b><?=format_amount($total2Ytd);?>,-</b></font></td>	
					</tr>
					<tr>
						<td width="200" align="right"><font face="tahoma" size="2"><b>INCOME BEFORE TAX</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b><?=format_amount($total1+$total2);?>,-</b></font></td>
					</tr>
				</TBODY>
			</TABLE>
			<TABLE>
				<TBODY>
				<tr><td colspan="10" width="650"><hr size="2" color="black"></td></tr>
					<tr>
						<td width="200" ><font face="tahoma" size="2"><b>TAX</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b>CALCULATION</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b></b></font></td>	
						<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																			
					</tr>
					<?php
						$total3 = 0;
						$total3Ytd = 0;
						$payrolls = $db->fetch_all_data("employee_payrolls",[],"employee_id='".$employee_id."' AND periode='".$_periode."' AND payroll_type_id = '3'","id");
						foreach($payrolls as $payroll){
							if($payroll["ytd"] != 0){
					?>
						<tr>
							<td width="200"><font face="tahoma" size="2"><?=strtoupper($payroll["name"]);?></font></td>
							<td width="150" align="right"><font face="tahoma" size="2"><?=format_amount($payroll["ytd"]);?>,-</font></td>
							<td width="150"  nowrap="nowrap"><font face="tahoma" size="2"></font></td>						
							<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																					
						</tr>
					<?php }} ?>
				</TBODY>
			</TABLE>
			<TABLE>
				<TBODY>
					<tr><td colspan="10" width="650"><hr size="2" color="black"></td></tr>
					<tr>
						<td width="200" ><font face="tahoma" size="2"><b>DEDUCTION</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b>AMOUNT</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b>YTD</b></font></td>		
						<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																
					</tr>
					<?php
						$total4 = 0;
						$total4Ytd = 0;
						$payrolls = $db->fetch_all_data("employee_payrolls",[],"employee_id='".$employee_id."' AND periode='".$_periode."' AND payroll_type_id = '4' AND payroll_item_id <> 59","id");
						foreach($payrolls as $payroll){
							$total4 += $payroll["amount"];
							$total4Ytd += $payroll["ytd"];
					?>
						<tr>
							<td width="200"><font face="tahoma" size="2"><?=strtoupper($payroll["name"]);?></font></td>
							<td width="150" align="right"><font face="tahoma" size="2"><?=format_amount($payroll["amount"]);?>,-</font></td>
							<td width="150" align="right"><font face="tahoma" size="2"><?=format_amount($payroll["ytd"]);?>,-</font></td>
							<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																						
						</tr>
					<?php } ?>
					<?php
						$payrolls = $db->fetch_all_data("employee_payrolls",[],"employee_id='".$employee_id."' AND periode='".$_periode."' AND payroll_type_id = '4' AND payroll_item_id = 59");
						foreach($payrolls as $payroll){
							$total4 += $payroll["amount"];
							$total4Ytd += $payroll["ytd"];
					?>
						<tr>
							<td width="200"><font face="tahoma" size="2"><?=strtoupper($payroll["name"]);?></font></td>
							<td width="150" align="right"><font face="tahoma" size="2"><?=format_amount($payroll["amount"]);?>,-</font></td>
							<td width="150" align="right"><font face="tahoma" size="2"><?=format_amount($payroll["ytd"]);?>,-</font></td>
							<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																						
						</tr>
					<?php } ?>
					<tr>
						<td width="200" align="right"><font face="tahoma" size="2"><b>TOTAL DEDUCTION</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b><?=format_amount($total4);?>,-</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b><?=format_amount($total4Ytd);?>,-</b></font></td>	
						<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																		
					</tr>
					<tr></tr>

					<tr>
						<td width="200" align="right"><font face="tahoma" size="2" color="blue"><b><BLINK>NET INCOME</BLINK></b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2" color="blue"><b><BLINK><?=format_amount($total1+$total2-$total4);?>,-</BLINK></b></font></td>
					</tr>
				</TBODY>
			</TABLE>
			<TABLE>
				<TBODY>
					<tr><td colspan="10" width="650"><hr size="2" color="black"></td></tr>
					<!--
					<tr>
						<td width="200" ><font face="tahoma" size="2"><b>SAVING</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b>AMOUNT</b></font></td>
						<td width="150" align="right"><font face="tahoma" size="2"><b>YTD</b></font></td>		
						<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																															
					</tr>
					<tr>
						<td width="200"><font face="tahoma" size="2">THT 3.7%  (BPJS)</font></td>
						<td width="150" align="right"><font face="tahoma" size="2">777.000,-</font></td>
						<td width="150" align="right"><font face="tahoma" size="2">17.316.000,-</font></td>						
						<td width="105" align="right"><font face="tahoma" size="2"><b></b></font></td>																
					</tr>
					<tr><td colspan="10" width="650"><hr size="2" color="black"></td></tr>
					-->
				</TBODY>
			</TABLE>
			
			<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_view","_list",$_SERVER["PHP_SELF"])."?periode=".$_GET["periode"]."&project=".$_GET["project"]."&do_filter=Load';\"","btn btn-secondary");?>
		</div>
	</div>
</section>

<?php
	include_once "footer.php";
?>
</body>
</html>