<script>
    /*
    * User specific permissions 
    *Author:
    */
	
	$(document).ready(function(){

		//Get permission tree
		$.ajax({ 
	        url: "<?php echo base_url() . 'index.php/Group_permissions/getTree' ?>",
	        method:"POST",
	        dataType: "json",            
	        success: function(data) {
	            $('#tree').treeview({ data: data,showCheckbox: true });
	        }    
    	});

        //When user change load group permissions
        $(document).on('change', '#user', function (event) {
            var user_id=$("#user").val();
            load_group_links();
            load_groups_not_in_user_groups(user_id);
            get_permissions_to_user();
        });

		//When group change load relevant permissions
        $(document).on('change', '#group_id', function (event) {
        	var group_id=$("#group_id").val();

        	getGroupPermissions(group_id);
            $("#hdn_group_id").val(group_id);
            $('#btnBlock').html('<button class="btn btn-primary" id="save_perms">Save</button>'); //Display save button
        });


        //Save permissions for given user
        $(document).on('click', '#save_perms', function (event) {

            var group_id = $("#hdn_group_id").val();
            var user_id = $("#user").val();
            checked_nodes = $('#tree').treeview('getChecked', false);

            var checked_perm_arr = [];
            if (checked_nodes) {
                $.each(checked_nodes, function (index, perm_node) {
                    
                    checked_perm_arr.push(perm_node.id);
  
                });
            }

            if (group_id > 0 && checked_perm_arr.length > 0 && user_id > 0) {

                saveUserPerms(checked_perm_arr, group_id, user_id);
            } else {
                alert("Could not save permissions.Make sure you have selected a user group & permissions");
            }

        });


        $(document).on('nodeChecked', '#tree', function (event, node) {
            p = $('#tree').treeview(true).getParent(node);
            if (p) {
                $('#tree').treeview(true).checkNode(p.nodeId, {silent: true});
            }
        });

        $(document).on('nodeUnchecked', '#tree', function (event, node) {
            $.each(node.nodes, function (index, child) {
                $('#tree').treeview(true).uncheckNode(child.nodeId, {silent: true});
            });

        });


	});


	//Get group permissions
	function getGroupPermissions() {

        $('#tree').treeview(true).uncheckAll();
        $('#tree').treeview(true).enableAll();
        var group_id=$("#group_id").val();

        if(group_id != 0){
            $.ajax({ 
                url: "<?php echo base_url() . 'index.php/Group_permissions/getUserGroupPermissions' ?>",
                method:"POST",
                data:{'group_id':group_id},           
                success: function(data) {
                    var obj = jQuery.parseJSON(data);

                    if (obj['status'] == "1") {

                        unchecked_nodes = $('#tree').treeview('getUnchecked', false);
                        $.each(unchecked_nodes, function (index, nodeobj) {
                            node_perm_id = nodeobj.id;
                            a = $.inArray(node_perm_id, obj['data']);
                            if (a > -1) {

                                $('#tree').treeview('expandNode', [nodeobj.nodeId, {levels: 2, silent: true}]);
                                $('#tree').treeview('checkNode', [nodeobj.nodeId, {silent: true}]);
                            }
                        });
                    }else{
                        $.ajax({ 
                            url: "<?php echo base_url() . 'index.php/Group_permissions/getTree' ?>",
                            method:"POST",
                            dataType: "json",            
                            success: function(data) {
                                $('#tree').treeview({ data: data,showCheckbox: true });
                            }    
                        });
                    }
                }    
            });
        }
    }

    //Get group permissions
    function getGroupPermissions(groupID) {

        $('#tree').treeview(true).uncheckAll();
        $('#tree').treeview(true).enableAll();
        var group_id=groupID;

        if(group_id != 0){
            $.ajax({ 
                url: "<?php echo base_url() . 'index.php/Group_permissions/getUserGroupPermissions' ?>",
                method:"POST",
                data:{'group_id':group_id},           
                success: function(data) {
                    var obj = jQuery.parseJSON(data);

                    if (obj['status'] == "1") {
                        console.log( obj['data']);
                        unchecked_nodes = $('#tree').treeview('getUnchecked', false);
                        $.each(unchecked_nodes, function (index, nodeobj) {
                            node_perm_id = nodeobj.id;
                            a = $.inArray(node_perm_id, obj['data']);
                            if (a > -1) {
                                if(nodeobj.parentId){
                                    $('#tree').treeview('disableNode', [nodeobj.nodeId, {silent: true}]);
                                }else{
                                    $('#tree').treeview('expandNode', [nodeobj.nodeId, {levels: 2, silent: true}]);   
                                }
                                
                                $('#tree').treeview('checkNode', [nodeobj.nodeId, {silent: true}]);
                            }
                        });
                    }else{
                        $.ajax({ 
                            url: "<?php echo base_url() . 'index.php/Group_permissions/getTree' ?>",
                            method:"POST",
                            dataType: "json",            
                            success: function(data) {
                                $('#tree').treeview({ data: data,showCheckbox: true });
                            }    
                        });
                    }
                }    
            });
        }
    }

    //Load users when group change
    function load_user_combo_to_group(groupid, selected) {
        var param = {};
        param.goup_id = groupid;

        var select_data = '';
        $.post("<?php echo base_url() . 'index.php/User_permisions/load_user_combo_to_group' ?>", param, function (response) {

            if (response.status == "1" && response.data != null) {
                select_data += '<option value=""> Select User </option>';
                $.each(response.data, function (index, row) {

                    if (response !== undefined || response !== null || response.length !== 0) {
                        if (parseInt(selected) === parseInt(row.id)) {
                            select_data += '<option value="' + row.id + '" selected>' + row.username + '</option>';
                        } else {
                            select_data += '<option value="' + row.id + '">' + row.username + '</option>';
                        }
                    } else {
                        select_data += '<option value="' + row.id + '">' + row.username + '</option>';
                    }
                });
            }
            $('#user_combo').html('').append(select_data);
        }, 'json');
    }

    //Get permission for specific user
    function get_permissions_to_user_old() {

        if ($("#user_combo").val() > 0) {
            var param = {};
            param.user_id = $("#user_combo").val();

            $.post('User_permisions/get_permissions_to_user', param, function (response) {

                if (response !== null) {
                    if (response.status == "1") {

                        unchecked_nodes = $('#tree').treeview('getUnchecked', false);
                        $.each(unchecked_nodes, function (index, nodeobj) {
                            node_perm_id = nodeobj.id;
                            a = $.inArray(node_perm_id, response.data);
                            if (a > -1) {
                                $('#tree').treeview('expandNode', [nodeobj.nodeId, {levels: 2, silent: true}]);
                                $('#tree').treeview('checkNode', [nodeobj.nodeId, {silent: true}]);
                            }
                        });

                    } else {
                        alert("No permissions assigned.");
                    }

                } else {
                    alert("Could not load data.");
                }
            }, 'json').fail(function () {
                alert("Could not load data.");
            });
        }
    }

    //Get permission for specific user
    function get_permissions_to_user() {

        if ($("#user").val() > 0) {
            var param = {};
            param.user_id = $("#user").val();

            $.post('User_permisions/get_permissions_to_user', param, function (response) {

                if (response !== null) {
                    if (response.status == "1") {

                        unchecked_nodes = $('#tree').treeview('getUnchecked', false);
                        $.each(unchecked_nodes, function (index, nodeobj) {
                            node_perm_id = nodeobj.id;
                            a = $.inArray(node_perm_id, response.data);
                            if (a > -1) {
                                $('#tree').treeview('expandNode', [nodeobj.nodeId, {levels: 2, silent: true}]);
                                $('#tree').treeview('checkNode', [nodeobj.nodeId, {silent: true}]);
                            }
                        });

                    } else {
                        $.ajax({ 
                            url: "<?php echo base_url() . 'index.php/Group_permissions/getTree' ?>",
                            method:"POST",
                            dataType: "json",            
                            success: function(data) {
                                $('#tree').treeview({ data: data,showCheckbox: true });
                            }    
                        });
                    }

                } else {
                    alert("Could not load data.");
                }
            }, 'json').fail(function () {
                alert("Could not load data.");
            });
        }
    }

    function get_permissions_for_user(){

        if ($("#user").val() > 0) {
            var param = {};
            param.user_id = $("#user").val();

            $.post('User_permisions/get_permissions_to_user', param, function (response) {

                if (response !== null) {
                    if (response.status == "1") {

                        unchecked_nodes = $('#tree').treeview('getUnchecked', false);
                        $.each(unchecked_nodes, function (index, nodeobj) {
                            node_perm_id = nodeobj.id;
                            a = $.inArray(node_perm_id, response.data);
                            if (a > -1) {
                                $('#tree').treeview('expandNode', [nodeobj.nodeId, {levels: 2, silent: true}]);
                                $('#tree').treeview('checkNode', [nodeobj.nodeId, {silent: true}]);
                            }
                        });

                    } else {
                        alert("No permissions assigned.");
                    }

                } else {
                    alert("Could not load data.");
                }
            }, 'json').fail(function () {
                alert("Could not load data.");
            });
        }

    }

    //Load groups for given user with links to permissions
    function load_group_links_old(){
        var userid=$("#user").val();
        var param = {};
        param.user_id = userid;

        var select_data = '<h4>Groups</h4>';
        select_data += '<a href="<?php echo site_url('user_permisions/load_all_user_permissions/') ?>'+userid+'" class="btn btn-sm btn-warning">All</a>&nbsp;';
        $.post("<?php echo base_url() . 'index.php/User_permisions/get_user_groups' ?>", param, function (response) {

            if (response.status == "1" && response.data != null) {
                select_data += '';
                $.each(response.data, function (index, row) {

select_data += '<a href="<?php echo site_url('user_permisions/load_group_permissions/') ?>'+row.id+'" class="btn btn-sm btn-success">' + row.name + '</a>&nbsp;';

                });
            }
            $('#groupBlock').html('').append(select_data);
        }, 'json');
    }

    //Load groups for given user with links to permissions
    function load_group_links(){

        var userid=$("#user").val();
        var param = {};
        param.user_id = userid;

        var select_data = '<h4>Groups</h4>';
        select_data += '<button id="user_perm_'+userid+'" type="button" class="perm_cls btn btn-sm btn-success" onClick="getAllUserPermissions(\'' + userid + '\')">All</button>&nbsp;';
        $.post("<?php echo base_url() . 'index.php/User_permisions/get_user_groups' ?>", param, function (response) {

            if (response.status == "1" && response.data != null) {
                select_data += '';
                $.each(response.data, function (index, row) {

            select_data += '<button id="group_perm_'+row.id +'" type="button" onClick="getAllGroupPermissions(\'' + row.id + '\',\''+userid+'\')" class="perm_cls btn btn-sm btn-primary">' + row.name + '</button>&nbsp;';

                });
            }
            $('#groupBlock').html('').append(select_data);
        }, 'json');
    }

    //Change color of clicked buttons
    function getAllUserPermissions(userID){
        $(".perm_cls").removeClass("btn btn-sm btn-success").addClass("btn btn-sm btn-primary");
        $("#user_perm_"+userID).removeClass("btn btn-sm btn-primary").addClass("btn btn-sm btn-success");
        $('#btnBlock').html(''); //Hide save button
    }

    //Change color of clicked buttons
    function getAllGroupPermissions(groupID, userID){
        $(".perm_cls").removeClass("btn btn-sm btn-success").addClass("btn btn-sm btn-primary");
        $("#group_perm_"+groupID).removeClass("btn btn-sm btn-primary").addClass("btn btn-sm btn-success");
        $("#user_perm_"+userID).removeClass("btn btn-sm btn-success").addClass("btn btn-sm btn-primary");
        getGroupPermissions(groupID);
        $('#btnBlock').html('<button class="btn btn-primary" id="save_perms">Save</button>'); //Display save button
        $("#hdn_group_id").val(groupID);
        
    }


    //Load user groups not in current user groups
    function load_groups_not_in_user_groups(userid, selected){
        var param = {};
        param.user_id = userid;

        var select_data = '';
        $.post("<?php echo base_url() . 'index.php/User_permisions/load_groups_not_in_user_groups' ?>", param, function (response) {

            if (response.status == "1" && response.data != null) {
                select_data += '<option value=""> Please Select A Group </option>';
                $.each(response.data, function (index, row) {

                    if (response !== undefined || response !== null || response.length !== 0) {
                        if (parseInt(selected) === parseInt(row.id)) {
                            select_data += '<option value="' + row.id + '" selected>' + row.name + '</option>';
                        } else {
                            select_data += '<option value="' + row.id + '">' + row.name + '</option>';
                        }
                    } else {
                        select_data += '<option value="' + row.id + '">' + row.name + '</option>';
                    }
                });
            }
            $('#group_id').html('').append(select_data);
        }, 'json');
    }

    //Save user permissions
    function saveUserPerms(permsArray, groupID, userID) {
        var param = {};
        param.user_id = userID;
        param.group_id=groupID;
        param.perms = permsArray;

        $.post('User_permisions/saveUserPermissions', param, function (response) {

            if (response !== null) {
                if (response.status == "1") {
                    alert("user group permissions updated.");
                    window.location.reload(true);

                } else {
                    alert("permissions update failed.");
                }
            } else {
                alert("Error, permissions update failed.");
            }
        }, 'json');
    }


</script>