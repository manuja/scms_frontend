 /**
 * Created by test on 4/27/2018.
 */



$(document).ready(function($){

    $(function () {
        $('.select-dropdown').select2();
    });

    // onchange filters
    $('#search_filter_category').on('change', function(event){
        event.preventDefault();
        var search = $('#search_filter_search').val();
        var dropdown = $('#search_filter_category').val();
        $.ajax({
            url: 'VideoUserManual/getUserManualsFilters/',
            data: {
                search: search,
                category: dropdown
            },
            dataType : 'html',
            type: 'post',
            success: function (data) {
                var view = data;
                if(data) {
                    $("#video-list").html(view);
                }else{
                    $("#video-list").html('<h5>No Results...</h5>');
                    console.log('Error Fetching Data');
                }

            },
            error: function () {
                $("#video-list").html('<h5>No Results...</h5>');
                console.log('Error Fetching Data');
            }
        });
    });
    $('#search_filter_search').on('keyup', function(event){
        event.preventDefault();
        var search = $('#search_filter_search').val();
        var dropdown = $('#search_filter_category').val();
        $.ajax({
            url: 'VideoUserManual/getUserManualsFilters/',
            data: {
                search: search,
                category: dropdown
            },
            dataType : 'html',
            type: 'post',
            success: function (data) {
                var view = data;
                if(data) {
                    $("#video-list").html(view);
                }else{
                    $("#video-list").html('<h5>No Results...</h5>');
                    console.log('Error Fetching Data');
                }

            },
            error: function () {
                $("#video-list").html('<h5>No Results...</h5>');
                console.log('Error Fetching Data');
            }
        });
    });
    

    
    $('button[type="reset"]').on('click', function(e){
        e.preventDefault();
        var form = $(this).closest('form');
        form.find('input, textarea').val('');
        form.find('input[type="radio"]').prop('checked', false);
        form.find('select').prop("selectedIndex", 0).trigger('change.select2');

    });
});

// onclick video
function playvideo(video_id){
        var recordurl = "VideoUserManual/fetchVideo/"+video_id;
        $.ajax({
            url: recordurl,
            data: {
                video_id: video_id
            },
            dataType : 'html',
            type: 'post',
            success: function (data) {
                var view = data;
                if(data) {
                    $("#modal-video .modal-content").html(view);
                }else{
                    $("#modal-video .modal-content").html('<h5>Error Fetching Data</h5>');
                    console.log('Error Fetching Data');
                }

            },
            error: function () {
                $("#modal-view-status .modal-content").html('<h5>Error Fetching Data</h5>');
                console.log('Error Fetching Data');
            }
        });

    $('#modal-video').modal('show');

}