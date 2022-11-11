<?php
$mem_id = $this->session->userdata('user_id');
?>

<script>
    var mem_id = <?php echo $mem_id ?>;
    var admin = <?php echo $is_admin->is_admin ?>;

    json_load_group_post();

    $(document).on('click', '#save_post', function (event) {
        event.preventDefault();
        var fullForm = $("#add_comment");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            save_group_post();
        }


    });
    $(document).on('click', '.post_post', function () {

        var post_val = $(this).val();
        var reply_val = $('#cmnt_reply_' + post_val + '').val();
        save_post_reply(reply_val, post_val);
    });
    function save_group_post() {


        var group_post = document.getElementById('add_comment');
        var formData = new FormData(group_post);
        //                    formData.append('recommendations', JSON.stringify(get_RecommendationRecords()));

        $.ajax({
            method: 'POST',
            url: site_url + 'Membership_Groups/save_group_post',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
        }).always(function (data) {
            //                        console.log(data);
            if (data.status == '1') {
                $('#createPostModal').modal('hide');
                json_load_group_post();
                $('#add_comment').trigger("reset");
            } else if (data.status == '3') {
                json_load_group_post();
                $('#add_comment').trigger("reset");
            } else {

            }

        });
        //                });
    }



    function json_load_group_post() {
        var group_id = $('#group_id').val();
        var param = {};
        param.group_id = group_id;
        var tableData = '';
        var post_div = '';
        jQuery.post(site_url + 'Membership_Groups/get_group_posts', param, function (response) {
            if (response === undefined || response.length === 0 || response == null) {
                tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
                jQuery('#group_posts_div').html('').append(post_div);
            } else {
                jQuery.each(response, function (index, qData) {
//                    console.log(qData);
//alert(qData.mem_id);
//alert(mem_id);
                    var user_pic1;
                    if (qData.user_picture) {
                        user_pic1 = qData.user_picture;
                    } else {
                        user_pic1 = "uploads/images/no-user.png";
                    }

                    post_div += '<ul id="comments-list" class="comments-list"><li><div class="comment-main-level" ><div class="comment-avatar"><img src="<?php echo base_url("uploads/user_profiles_pictures/'+ user_pic1 +'") ?>"  alt=""></div><div class="comment-box"><div class="comment-head"><h6 class="comment-name by-author"><a href="">' + qData.user_name_w_initials + ' </a><span>' + qData.posted_date + '</span></h6><i><button class="fa fa-angle-down" role="button"  data-toggle="collapse" title="Reply" data-parent="#accordion_' + qData.post_id + '" href="#collapse_' + qData.post_id + '" aria-expanded="true" aria-controls="collapse_' + qData.post_id + '" ></div>';
                    if (mem_id == qData.member_id || admin == 1) {
                        post_div += '</button></i><i><button class="fa fa-edit post_edit" id="post_edit" value="' + qData.post_id + '" data-toggle="modal" data-target="#createPostModal" ></button></i><i><button class="post_delete fa fa-trash" id="post_delete" value="' + qData.post_id + '" ></button></i>';
                    }
                    post_div += '<div class="comment-content"><h4>' + qData.post_title + '</h4>' + qData.post_description + '</div></div></div><div id="collapse_' + qData.post_id + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_' + qData.post_id + '"><div class="row" style="margin-top: 20px;"><div class="col-sm-12"><div class="card" style="min-height: 75px;height: 100px !important; float: right; width: 87%;"><div class="col-md-1 text-right"><i class="fa fa-user fa-2x"></i></div><div class="col-md-10"><div class="form-group"><textarea class="form-control" id="cmnt_reply_' + qData.post_id + '" placeholder="Add a comment..." required=""></textarea></div></div><div class="form-group col-sm-1"><button value="' + qData.post_id + '" style="margin-top: 20px; margin-left: -25px;" id="post_post" type="button" class="btn btn-success post_post">Post</button></div></div></div></div>';
                    jQuery.each(qData.reply, function (index, qData2) {
//                        console.log(qData2.reply_by+'______'+mem_id);
                        var user_pic;
                        if (qData2.user_picture) {
                            user_pic = qData2.user_picture;
                        } else {
                            user_pic = "uploads/images/no-user.png";
                        }
                        post_div += '<ul class="comments-list reply-list ul_' + qData.post_id + '" id="ul_list_list' + qData.post_id + '"><li><div class="comment-avatar"><img src="<?php echo base_url("uploads/user_profiles_pictures/'+ user_pic +'") ?>"alt=""></div><div class="comment-box"><div class="comment-head"><h6 class="comment-name"><a href="">' + qData2.user_name_w_initials + '</a><span>' + qData2.reply_date + '</span></h6>';
                        if (mem_id == qData2.reply_by || admin == 1) {
                            post_div += '<i><button class="fa fa-edit reply_edit" id="reply_edit" value="' + qData2.reply_id + '" data-toggle="modal" data-target="#createReplyModal" ></button></i><i><button class="fa fa-trash reply_delete" id="reply_delete" value="' + qData2.reply_id + '" ></button></i>';
                        }
                        post_div += '</div><div class="comment-content">' + qData2.post_reply + '</div></div></li></ul>';
                    });

                    post_div += '</div></li></ul>';


//                    console.log(post_div);
                });
                jQuery('#group_posts_div').html('').append(post_div);
            }
        }, "json");


    }











    function save_post_reply(reply_val, post_val) {

        var data = {
            reply_val: reply_val,
            post_val: post_val
        };

        var element = '#ul_list_list' + post_val;

        jQuery.post('<?php echo site_url("Membership_Groups/save_group_post_reply") ?>', data, function (d) {

            if (d.status == 1) {
                var current_index = $("#tabs").tabs("option", "active");
                $("#tabs").tabs('load', current_index);
                $('#cmnt_reply_' + post_val).val('');
//                var prof_pic = d.data;
                if ((element).length > 0)
                {
                    json_load_group_post();
                } else {
                    json_load_group_post();
                }

            } else if (d.status == 2) {


            }
        }, 'json');
    }




    $(document).on('click', '.post_edit', function () {
//alert();
        var post_val = $(this).val();
        edit_post(post_val);

    });


    function edit_post(post_val) {

        var data = {
            post_val: post_val
        };
        jQuery.post('<?php echo site_url("Membership_Groups/edit_group_post") ?>', data, function (d) {
//            console.log(d);
            if (d.status == 1) {
                $('#hidden_post_id').val(d.data.post_id);
                $('#post_title').val(d.data.post_title);
                $('#description').val(d.data.post_description);
            }
        }, 'json');
    }
    $(document).on('click', '.reply_edit', function () {
        var reply_val = $(this).val();
        edit_reply(reply_val);

    });


    function edit_reply(reply_val) {
//alert(reply_val);
        var data = {
            reply_val: reply_val
        };
        jQuery.post('<?php echo site_url("Membership_Groups/edit_group_post_reply") ?>', data, function (d) {
//            console.log(d);
            if (d.status == 1) {
                $('#hidden_reply_id').val(d.data.reply_id);
                $('#reply_post').val(d.data.post_reply);
            }
        }, 'json');
    }


//update posted reply for the created post
    $(document).on('click', '#save_reply', function (event) {
        event.preventDefault();
        var fullForm = $("#add_reply");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            update_post_reply();
        }


    });


    $(document).on('click', '#update_reply', function () {
//alert();
        var hidden_reply_val = $('#hidden_reply_id').val();
        var post_reply = $('#reply_post').val();
        update_reply(hidden_reply_val, post_reply);

    });


    function update_reply(hidden_reply_val, post_reply) {

        var data = {
            hidden_reply_val: hidden_reply_val,
            post_reply: post_reply
        };
        jQuery.post('<?php echo site_url("Membership_Groups/update_group_post_reply") ?>', data, function (d) {
//            console.log(d);
            if (d.status == 1) {
                json_load_group_post();
            } else {
                json_load_group_post();
            }
        }, 'json');
    }


    $(document).on('click', '.post_delete', function () {
        var post_del = $(this).val();

        swal({
            title: 'Are you sure?',
            text: "This Post will Be Deleted!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm!'
        }).then((result) => {
            if (result.value) {
                delete_post(post_del);
            }
        });


    });

    function delete_post(post_del) {

        var data = {
            post_del: post_del
        };
        jQuery.post('<?php echo site_url("Membership_Groups/delete_group_post") ?>', data, function (d) {
//            console.log(d);
            if (d.status == 1) {
                json_load_group_post();
            }
        }, 'json');
    }



    $(document).on('click', '.reply_delete', function () {
        var reply_del = $(this).val();

        swal({
            title: 'Are you sure?',
            text: "This Reply will Be Deleted!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm!'
        }).then((result) => {
            if (result.value) {
                delete_post_reply(reply_del);

            }
        });



    });

    function delete_post_reply(reply_del) {

        var data = {
            reply_del: reply_del
        };
        jQuery.post('<?php echo site_url("Membership_Groups/delete_group_post_reply") ?>', data, function (d) {
//            console.log(d);
            if (d.status == 1) {
                location.reload();
            }
        }, 'json');
    }



    function load_memnership_group_messages() {
        var param = {};
        param.group_id = '2';
        var tableData = '';
        var post_div = '';
        jQuery.post(site_url + 'Membership_Groups/membership_group_view_group_messages', param, function (response) {
            if (response === undefined || response.length === 0 || response == null) {
                tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
                jQuery('#group_posts_div').html('').append(post_div);
            } else {
                jQuery.each(response, function (index, qData) {


                });
                jQuery('#group_posts_div').html('').append(post_div);
            }
        }, "json");


    }


    $(document).on('click', '.meeting_confirmation', function (event) {
        var confirmation_val = $(this).val();
        var meeting_id = $(this).data("meeting_id");
        var group_id = $('#group_id').val();
        var data = {
            confirmation_val: confirmation_val,
            meeting_id: meeting_id,
            group_id: group_id
        };
        jQuery.post('<?php echo site_url("Membership_Groups/meeting_confirmation") ?>', data, function (d) {
//            console.log(d);
            if (d.status == 1) {
                var confirmation;
                var stst_class;
                if (d.data == 1) {
                    jQuery('#current_stats' + meeting_id).addClass('bg-green');
                    jQuery('#current_stats' + meeting_id).removeClass('bg-orange');
                    jQuery('#current_stats' + meeting_id).removeClass('bg-red');
                    jQuery('#current_stats' + meeting_id).removeClass('bg-blue');
                    confirmation = 'Confirmed';
                } else if (d.data == 2) {
                    jQuery('#current_stats' + meeting_id).removeClass('bg-green');
                    jQuery('#current_stats' + meeting_id).addClass('bg-orange');
                    jQuery('#current_stats' + meeting_id).removeClass('bg-red');
                    jQuery('#current_stats' + meeting_id).removeClass('bg-blue');
                    confirmation = 'Not Sure';
                } else if (d.data == 3) {
                    jQuery('#current_stats' + meeting_id).removeClass('bg-green');
                    jQuery('#current_stats' + meeting_id).removeClass('bg-orange');
                    jQuery('#current_stats' + meeting_id).addClass('bg-red');
                    jQuery('#current_stats' + meeting_id).removeClass('bg-blue');
                    confirmation = 'Rejected';
                } else {
                    jQuery('#current_stats' + meeting_id).removeClass('bg-green');
                    jQuery('#current_stats' + meeting_id).removeClass('bg-orange');
                    jQuery('#current_stats' + meeting_id).removeClass('bg-red');
                    jQuery('#current_stats' + meeting_id).addClass('bg-blue');
                }
//                alert(stst_class);
                jQuery('#current_stats' + meeting_id).html('').append(confirmation);
//                jQuery('#current_stats' + meeting_id).addClass(stst_class);
            }
        }, 'json');

    });


</script>