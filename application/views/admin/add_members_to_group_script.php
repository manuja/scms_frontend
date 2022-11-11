
<script>
    $(document).ready(function () {

        load_available_members_list();
        assigned_member_list_to_the_group();

        var ggroup_id = $('#hidden_group_id').val();
//        alert(ggroup_id);
        if (ggroup_id) {
            load_grid_view_to_on_load(ggroup_id);
        }



        $('#member_list').select2({
            placeholder: 'Please select...'
        });

        $('#added_members').select2({
            placeholder: 'Please select...'
        });
    });


    $(document).on('click', '#prv-add', function () {

        var mem_group_id = $('#membership_groups').val();
//        var assigned = $('#assigned_privileges');
        var available = $('#available_privilegs');
        var selected_options = available.find('option:selected');
        var sel_count = selected_options.length;
        var options2 = {};
        $.each(selected_options, function (index, option2) {
            options2[$(option2).data('prvcode')] = $(option2).data('prvcode');
        });
        console.log(options2);
        if (selected_options.length > 0) {
            var names = '';
            names += '<ul style="text-align: left; padding-left: 94px;">';
            jQuery.each(options2, function (index, item) {
                names += '<li>' + item + '</li>';
            });
            names += '</ul>';
            Swal.fire({
                title: '<h2>Confirm selected member list</h2>',
                html: '<div>' + names + '</div>',
                showCloseButton: true,
                focusConfirm: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Confirm!'
            }).then((result) => {
                if (result.value) {

                    var options = {};
                    $.each(selected_options, function (index, option) {
                        options[$(option).val()] = $(option).val();
                    });
                    jQuery.post(site_url + '/Membership_Groups/add_selected_members_to_group', {options: options, mem_group_id: mem_group_id}, function (e) {
//            $.post("add_selected_members_to_group", {mem_group_id: mem_group_id, options: options}, function (e) {

                        var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                        successmsg += sel_count + ' member/s  successfully added.';
                        successmsg += '</div>';
                        $("#select_membership_groups").html(successmsg);
                        load_available_members_list(); //right side
                        assigned_member_list_to_the_group(); //left
                    }, 'json');
                }
            });
        } else {

            swal({
                type: 'error',
                title: 'Please select atleast one record!'
            });
//            alertify.error('Please select one or more.', 10000);
        }
    });
    $(document).on('click', '#prv-add-all', function () {
        var mem_group_id = $('#membership_groups').val();
//        var assigned = $('#assigned_privileges');
        var available = $('#available_privilegs');
        var selected_options = available.find('option');
        var sel_count = selected_options.length;
        if (selected_options.length > 0) {
            var options = {};
            $.each(selected_options, function (index, option) {
                options[$(option).val()] = $(option).val();
            });
//            console.log(options);
            $.post(site_url + '/Membership_Groups/add_selected_members_to_group', {mem_group_id: mem_group_id, options: options}, function (e) {
                var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                successmsg += sel_count + ' member/s  successfully added.';
                successmsg += '</div>';
                $("#select_membership_groups").html(successmsg);
                load_available_members_list();
                assigned_member_list_to_the_group();
            }, 'json');
        } else {
            swal({
                type: 'error',
                title: 'Please select atleast one record!'
            });
        }
    });
    $(document).on('click', '#prv-remove', function () {
        var mem_group_id = $('#membership_groups').val();
        var assigned = $('#assigned_privileges');
        var selected_options = assigned.find('option:selected');
        var sel_count = selected_options.length;
        if (selected_options.length > 0) {
            var options = {};
            $.each(selected_options, function (index, option) {
                options[$(option).val()] = $(option).val();
            });
            $.post(site_url + '/Membership_Groups/remove_selected_members_to_group', {mem_group_id: mem_group_id, options: options}, function (e) {
                var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                successmsg += sel_count + ' member/s  successfully removed.';
                successmsg += '</div>';
                $("#select_membership_groups").html(successmsg);
                load_available_members_list();
                assigned_member_list_to_the_group();
            }, 'json');
        } else {
            swal({
                type: 'error',
                title: 'Please select atleast one record!'
            });
        }
    });
    $(document).on('click', '#prv-remove-all', function () {
        var mem_group_id = $('#membership_groups').val();
        var assigned = $('#assigned_privileges');
        var selected_options = assigned.find('option');
        var sel_count = selected_options.length;
//        alert(sel_count);
        if (selected_options.length > 0) {
            var options = {};
            $.each(selected_options, function (index, option) {
                options[$(option).val()] = $(option).val();
            });
            $.post(site_url + '/Membership_Groups/remove_selected_members_to_group', {mem_group_id: mem_group_id, options: options}, function (e) {
                var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                successmsg += sel_count + ' member/s  successfully removed.';
                successmsg += '</div>';
                $("#select_membership_groups").html(successmsg);
                load_available_members_list();
                assigned_member_list_to_the_group();
            }, 'json');
        } else {
            swal({
                type: 'error',
                title: 'Please select atleast one record!'
            });
        }
    });
    function load_available_members_list() {

        var group_id = $('#membership_groups').val();
        var class_of_membership = $('#class_of_membership').val();
        var search_by_name = $('#search_by_name').val();
//        alert(group_id);
        var assigned = $('#available_privilegs');
        var url = site_url + 'Membership_Groups/load_available_member_list';
        $.post(url, {group_id: group_id, class_of_membership: class_of_membership, search_by_name: search_by_name}, function (d) {
//            console.log(d);
            if (d === undefined || d.length === 0 || d === null) {
                assigned.html('<option disabled class="not_selectable">No Members Found.</option>');
            } else {
                $('#available_privilegs').empty();
                $.each(d, function (index, prvdata) {
                    assigned.append('<option value="' + prvdata.user_tbl_id + '" data-prvcode="' + prvdata.user_name_w_initials + '" data-prvname="' + prvdata.prvName + '">' + prvdata.user_name_w_initials + '&nbsp / &nbsp ' + prvdata.membership_number + '</option>');
                });
            }
        }, 'json');
    }
    function load_grid_view_to_on_load(group_id) {


//admin div
        if (group_id.length > 0) {
            var selected_group_admins = '<ul>';
            $.post(site_url + '/Membership_Groups/load_group_admins_by_group_id', {group_id: group_id}, function (e) {
                $.each(e, function (index, prvdata) {
                    selected_group_admins += '<li>' + prvdata.user_name_w_initials + '</li>';
                });
                selected_group_admins += '</ul>';
                $('#admin_div').html(selected_group_admins);
            }, 'json');
            //core engineering div

            var selected_core_engineers = '<ul>';
            $.post(site_url + '/Membership_Groups/load_core_engineers_by_group_id', {group_id: group_id}, function (e) {
                $.each(e, function (index, prvdata) {
//                    console.log(prvdata.user_name_w_initials);
                    selected_core_engineers += '<li>' + prvdata.core_engineering_discipline_name + '-' + prvdata.core_engineering_discipline_code + '</li>';
                });
                selected_core_engineers += '</ul>';
                $('#core_engi_div').html(selected_core_engineers);
            }, 'json');
            //sub engineering div

            var selected_sub_engineers = '<ul>';
            $.post(site_url + '/Membership_Groups/load_sub_engineers_by_group_id', {group_id: group_id}, function (e) {
                $.each(e, function (index, prvdata) {
//                    console.log(prvdata.user_name_w_initials);
                    selected_sub_engineers += '<li>' + prvdata.engineering_discipline_sub_field_name + '-' + prvdata.engineering_discipline_sub_field_code + '</li>';
                });
                selected_sub_engineers += '</ul>';
                $('#sub_eng_div').html(selected_sub_engineers);
            }, 'json');
        } else {
            alertify.error('Please select one or more.', 1300);
        }
    }


    $(document).on('change', '#class_of_membership', function () {
        load_available_members_list();
    });
    $(document).on('keyup', '#search_by_name', function () {
        load_available_members_list();
    });
    $(document).on('keyup', '#search_by_names_added_members', function () {
        assigned_member_list_to_the_group();
    });
//}



    function assigned_member_list_to_the_group() {

        var group_id = $('#membership_groups').val();
        var search_by_names_added_members = $('#search_by_names_added_members').val();
//        alert(class_of_membership);
        var assigned = $('#assigned_privileges');
        var url = site_url + 'Membership_Groups/assigned_member_list_to_the_group';
        $.post(url, {group_id: group_id, search_by_names_added_members: search_by_names_added_members}, function (d) {
            console.log(d);
            if (d === undefined || d.length === 0 || d === null) {
                assigned.html('<option disabled class="not_selectable">No Members Found.</option>');
            } else {
                $('#assigned_privileges').empty();
                $.each(d, function (index, prvdata) {
                    assigned.append('<option value="' + prvdata.assigned_mem_id + '" data-prvcode="' + prvdata.user_name_w_initials + '" data-prvname="' + prvdata.prvName + '">' + prvdata.user_name_w_initials + '&nbsp / &nbsp ' + prvdata.membership_number + '</option>');
                });
            }
        }, 'json');
    }


    $(document).on('change', '#membership_groups', function () {
//            function assigned_member_list_to_the_group() {
        load_available_members_list();
        assigned_member_list_to_the_group();
        var group_id = $(this).val();
//admin div
        if (group_id.length > 0) {
            var selected_group_admins = '<ul>';
            $.post(site_url + '/Membership_Groups/load_group_admins_by_group_id', {group_id: group_id}, function (e) {
                $.each(e, function (index, prvdata) {
                    selected_group_admins += '<li>' + prvdata.user_name_w_initials + '</li>';
                });
                selected_group_admins += '</ul>';
                $('#admin_div').html(selected_group_admins);
            }, 'json');
            //core engineering div

            var selected_core_engineers = '<ul>';
            $.post(site_url + '/Membership_Groups/load_core_engineers_by_group_id', {group_id: group_id}, function (e) {
                $.each(e, function (index, prvdata) {
//                    console.log(prvdata.user_name_w_initials);
                    selected_core_engineers += '<li>' + prvdata.core_engineering_discipline_name + '-' + prvdata.core_engineering_discipline_code + '</li>';
                });
                selected_core_engineers += '</ul>';
                $('#core_engi_div').html(selected_core_engineers);
            }, 'json');
            //sub engineering div

            var selected_sub_engineers = '<ul>';
            $.post(site_url + '/Membership_Groups/load_sub_engineers_by_group_id', {group_id: group_id}, function (e) {
                $.each(e, function (index, prvdata) {
//                    console.log(prvdata.user_name_w_initials);
                    selected_sub_engineers += '<li>' + prvdata.engineering_discipline_sub_field_name + '-' + prvdata.engineering_discipline_sub_field_code + '</li>';
                });
                selected_sub_engineers += '</ul>';
                $('#sub_eng_div').html(selected_sub_engineers);
            }, 'json');
        } else {
            alertify.error('Please select one or more.', 1300);
        }
    });
    $(document).on('click', '#abcd', function () {

    });

</script>