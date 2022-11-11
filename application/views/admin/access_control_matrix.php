<?php $CI = &get_instance();?>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-universal-access text-blue"></i>
                <h3 class="box-title">Access control matrix</h3>


            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td style="background-color:#D676E1;">Main function</td>
                            <td style="background-color:blue;">Functions</td>
                            <td style="background-color:red;">Permission code</td>

                                <?php
                                //Fetch the parent groups
                                $groups = $CI->getGroups();

                                if (sizeof($groups) > 0) {
                                    foreach ($groups as $group) {
                                        $group_ids  = $group['id'];
                                        //Fetch the sub groups in parent groups
                                        $sub_groups = $CI->getSubGroup($group_ids);

                                        if (empty($sub_groups)) {
                                            $cols = 1;
                                        } else {
                                            $cols = 0;
                                            foreach ($sub_groups as $sgroup) {
                                                $cols++;
                                            }
                                        }

                                        $group_id = $group['id'];
                                        echo '<td colspan="'.$cols.'" style="background-color:'.$group['bg_color'].';">'.$group['name'].'</td>';
                                    }
                                }
                                ?>
                        </tr>
                            <tr>
                                <td>&nbsp;<!-- Main functions--></td>
                                <td>&nbsp;<!-- Functions--></td>
                                <td>&nbsp;<!-- Permission code--></td>
                                <?php
                                $groupss = $CI->getGroups();
                                if (sizeof($groupss) > 0) {
                                    foreach ($groupss as $group) {
                                        $group_id = $group['id'];

                                        $sub_groups = $CI->getSubGroupAndOrder($group_id);

                                        if (empty($sub_groups)) {
                                            echo '<td colspan=""></td>';
                                        } else {
                                            foreach ($sub_groups as $sgroup) {
                                                echo '<td>'.$sgroup['name'].'</td>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                                $child_perms = $CI->getChildPerms();
                                if (sizeof($child_perms) > 0){
                                   foreach ($child_perms as $child_perm){
                                    $level=$child_perm['level'];
                                    $is_child=$child_perm['is_child'];
                                    $ch_id=$child_perm['id'];
                                        if ($level == 2) {
                                            $color = '#ADD8E6';
                                            $parent_perm=$CI->getParentPerms($ch_id)['name'];
                                            $parent_color='#E1F90C';
                                        }else {
                                            $color = '#FFFFFF';
                                            $parent_perm="";
                                            $parent_color='#FFFFFF';
                                        }

echo "<tr><td style='background-color:".$parent_color."'>".$parent_perm."</td>";
echo "<td style='background-color:".$color."'>".$child_perm['name']."</td><td>".$child_perm['permission_code']."</td>";

                                $single_groups=$CI->getSingleGroups();

                                if(sizeof($single_groups) > 0){

                                  foreach($single_groups as $single_group){
                                    $sg_id=$single_group['id'];

                                    $sg_perms = $CI->singleGroupPermissions($sg_id, $ch_id);

                                        if($sg_perms == 1 && $level==3){
                                            echo "<td><i class='fa fa-check' style='color:#228B22'></i></td>";
                                          
                                        }else{
                                            echo "<td></td>";
                                        }
                                  }  
                                }else{
                                    echo '<td></td>';
                                }


                             
                                $grps = $CI->getGroups();
                                if (sizeof($grps) > 0) {
                                    foreach ($grps as $grp) {
                                        $gr_id = $grp['id'];

                                        $sub_grps = $CI->getSubGroupAndOrder($gr_id);

                                         if (!empty($sub_grps)) {
                                            foreach ($sub_grps as $s_group) {
                                               $ss_id=$s_group['id'];

                                                $grp_perms = $CI->singleGroupPermissions($ss_id, $ch_id);
 // echo "<pre>";                                               
// echo  $grp_perms;
                                                if($grp_perms == 1 && $level==3){
                                                    echo "<td><i class='fa fa-check' style='color:#228B22'></i></td>";
                                                  
                                                }else{
                                                    echo "<td></td>";
                                                }
                                       
                                            }

                                        }
                                    }
                                }


                                echo "</tr>";

                                   } 
                                }
                            ?>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->