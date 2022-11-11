<?php 
session_start();
require_once '../library/config.php';
require_once '../library/functions.php';
require_once '../library/func_activity_log.php';
require_once 'functions.php';
$date_ss=date("Y-m-d H:i:s");
$_SESSION['lstlog']=$date_ss;

?>
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" id="chart_of_account">
  <tr class="tbl_header">
    <td width="224" height="25" class="border_bottom_left">&nbsp;MAIN GROUP</td>
    <td width="224" class="border_bottom_left">&nbsp;SUB GROUP</td>
    <td width="260" class="border_bottom_left">&nbsp;ACCOUNT NAME</td>
    <td width="150" class="border_bottom_left">&nbsp;LEDGER</td>
    <td width="100" class="border_bottom_left" align="center">&nbsp;ACCOUNT ID</td>
    <td width="92" class="border_bottom_left_right" align="center">&nbsp;ACTION</td>
  </tr>
				  <?php
                  $sql = "SELECT * FROM tbl_acc_group WHERE group_parent_id='0' ORDER BY group_order";
				  $result = mysql_query($sql) or die(mysql_error());
				  if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_assoc($result)){ 
					$mgp_id = $row['group_id'];
					?>

                      <tr class="font_nav">
                        <td height="25" valign="top" class="border_bottom_left">&nbsp;<?php echo $row['group_name']; ?></td>
                        <td colspan="5">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                         
                        <?php
						$sql_sub = "SELECT * FROM tbl_acc_group WHERE group_parent_id='$mgp_id'";
						$rs_sub = mysql_query($sql_sub) or die(mysql_error());
                        if(mysql_num_rows($rs_sub)>0){
							while($row_sub = mysql_fetch_assoc($rs_sub)){ $sub_gp=$row_sub['group_id'];  ?>
                              <tr>
                                <td width="27%" height="25" valign="top" class="border_bottom_left">&nbsp;<?php echo $row_sub['group_name']; ?></td>
                                <td width="73%" valign="top">
                               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <?php 
								$sql_acc = "SELECT * FROM tbl_acc_ledger WHERE ledger_group_id='$sub_gp' ORDER BY ledger_name ASC";
								$rs_acc = mysql_query($sql_acc) or die(mysql_error());
								if(mysql_num_rows($rs_acc)>0){
									while($row_acc = mysql_fetch_assoc($rs_acc)){  
									$led_id = $row_acc['ledger_id'];
									$led_default = $row_acc['ledger_default_account'];
									?>
                                  <tr>
                                    <td width="260" height="25" class="border_bottom_left">&nbsp;<a href="acc_view_account.php?acc_id=<?php echo $led_id;?>" style="cursor:pointer;" class="font_nav" target="_blank"><?php if($row_acc['ledger_type_id']==6){echo $row_acc['ledger_name']."(".$row_acc['ledger_default_currency'].")";}else{echo $row_acc['ledger_name'];} ?></a></td>
                                    <td width="150" class="border_bottom_left">&nbsp;<?php echo GetLedgerId($row_acc['ledger_type_id']); ?></td>
                                    <td width="100" class="border_bottom_left" align="center">&nbsp;<?php echo $row_acc['ledger_code']; ?></td>
                                    <td width="90" class="border_bottom_left_right" align="center"><?php if($led_default==0){ ?>
                                      
                                      <?php /*?><img src="../images/btn_edit.gif" width="16" height="16"  onclick="document.getElementById('light').style.display='block'; document.getElementById('fade').style.display='block'; center('light'); loadauth('edit_ledger.php','ledger_id='+<?php echo $led_id;?>,'ACCACCEDI');" style="cursor:pointer"/><?php */?>
                                      
                                      <i class="fa fa-pencil-square-o" aria-hidden="true" style="cursor:pointer;" onclick="document.getElementById('light').style.display='block'; document.getElementById('fade').style.display='block'; center('light'); loadauth('edit_ledger.php','ledger_id='+<?php echo $led_id;?>,'ACCACCEDI');"></i>
    
    									&nbsp;&nbsp;&nbsp;
    
    
    <?php
    $sql_check = "SELECT * FROM tbl_acc_transaction WHERE acc_id='$led_id'";
	$rs_check = mysql_query($sql_check) or die(mysql_error($sql_check));
	if(mysql_num_rows($rs_check)==0){
	?>
      <?php /*?><img src="../images/del.gif" width="16" height="16"  onclick="document.getElementById('light').style.display='block'; document.getElementById('fade').style.display='block'; center('light'); loadauth('delete_ledger2.php','ledger_id='+<?php echo $led_id;?>,'ACCACCDEL');" style="cursor:pointer"/><?php */?>
      
      <i class="fa fa-times" aria-hidden="true" style="cursor:pointer;" onclick="document.getElementById('light').style.display='block'; document.getElementById('fade').style.display='block'; center('light'); loadauth('delete_ledger2.php','ledger_id='+<?php echo $led_id;?>,'ACCACCDEL');"></i>
      
    <?php } ?>
                                    
                                    <?php }?></td>
                                  </tr>
                                 <?php	} }else{ ?>
                                  <tr>
                                    <td height="25" colspan="4" class="border_bottom_left_right">&nbsp;</td>
                                  </tr>
                                <?php }	?>
                                </table>

                                </td>
                              </tr>
                                
					<?php	} }else{ ?>
                      <tr>
                        <td width="27%" height="25" valign="top" class="border_bottom_left">&nbsp;</td>
                        <td width="73%" valign="top" class="border_bottom_left_right">&nbsp;</td>
                      </tr>
					<?php }	?>
                    
                     <?php 
						$sql_direct = "SELECT * FROM tbl_acc_ledger WHERE  ledger_group_id='$mgp_id' ORDER BY ledger_name ASC";
						$rs_direct = mysql_query($sql_direct) or die(mysql_error($sql_direct));
						if(mysql_num_rows($rs_direct)>0){  ?>
 					<tr>
                        <td class="border_bottom_left" height="25" width="27%">&nbsp;</td>
                        <td class="border_bottom_left_right" height="25" width="73%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <?php while($row_direct = mysql_fetch_assoc($rs_direct)){ $led_default = $row_direct['ledger_default_account'];?>
                    <tr>
                            <td width="260" height="25" class="border_bottom">&nbsp;<a href="acc_view_account.php?acc_id=<?php echo $row_direct['ledger_id'];?>" style="cursor:pointer;" class="font_nav" target="_blank"><?php if($row_direct['ledger_type_id']==6){echo $row_direct['ledger_name']."(".$row_direct['ledger_default_currency'].")";}else{echo $row_direct['ledger_name'];}?></a></td>
                            <td width="150" class="border_bottom_left">&nbsp;<?php echo GetLedgerId($row_direct['ledger_type_id']); ?></td>
                            <td width="100" class="border_bottom_left" align="center">&nbsp;<?php echo $row_direct['ledger_code']; ?></td>
                            <td width="90" class="border_bottom_left" align="center"><?php if($led_default==0){?>
                            
                             <?php /*?><img src="../images/btn_edit.gif" width="16" height="16"  onclick="document.getElementById('light').style.display='block'; document.getElementById('fade').style.display='block'; center('light'); loadauth('edit_ledger.php','ledger_id='+<?php echo $row_direct['ledger_id'];?>,'ACCACCEDI');" style="cursor:pointer"/><?php */?>
                             
                             <i class="fa fa-pencil-square-o" aria-hidden="true" style="cursor:pointer;" onclick="document.getElementById('light').style.display='block'; document.getElementById('fade').style.display='block'; center('light'); loadauth('edit_ledger.php','ledger_id='+<?php echo $row_direct['ledger_id'];?>,'ACCACCEDI');"></i>
    
    						&nbsp;&nbsp;&nbsp;
                             
    
    <?php
    $sql_check = "SELECT * FROM tbl_acc_transaction WHERE acc_id='".$row_direct['ledger_id']."'";
	$rs_check = mysql_query($sql_check) or die(mysql_error($sql_check));
	if(mysql_num_rows($rs_check)==0){
	?>
      <?php /*?><img src="../images/del.gif" width="16" height="16"  onclick="document.getElementById('light').style.display='block'; document.getElementById('fade').style.display='block'; center('light'); loadauth('delete_ledger2.php','ledger_id='+<?php echo $row_direct['ledger_id'];?>,'ACCACCDEL');" style="cursor:pointer"/><?php */?>
      
      <i class="fa fa-times" aria-hidden="true" style="cursor:pointer;" onclick="document.getElementById('light').style.display='block'; document.getElementById('fade').style.display='block'; center('light'); loadauth('delete_ledger2.php','ledger_id='+<?php echo $row_direct['ledger_id'];?>,'ACCACCDEL');"></i>
      
    <?php } ?>
                                    
                            <?php }?></td>
                          </tr>
                        <?php } ?>
                        </table> </td>
                      </tr><?php } ?>
                      
                        </table>
                        </td>
                        </tr>
                      
                     <?php }?>
 <?php }   ?>
  <tr>
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>