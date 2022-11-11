<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery/dist/jquery.min.js"></script>
<style>
   #map {
        width: 100%;
        height: 700px;
    }
    #div_class_A:hover{
        cursor: pointer;
    }
    #div_class_B:hover{
        cursor: pointer;
    }
    #div_District:hover{
        cursor: pointer;
    }
    #div_Offices:hover{
        cursor: pointer;
    }
    #div_All:hover{
        cursor: pointer;
    }
</style>
<?php
//  echo "<pre>";
//  print_r($map_data);
//  die();

 $class_A_file = '';
 $class_B_file = '';
//  $offices_file = '';
 foreach ($map_data as $map) {
     if($map->road_type == 1){ //A
        $class_A_file = $map->uploaded_file;
     }else if($map->road_type == 2){ //B
        $class_B_file = $map->uploaded_file;
     }else if($map->road_type == 3){ //Offices
        $offices_file = $map->uploaded_file;
     }
     else{
         //none
     }
 }
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Box Comment -->
                <div class="box box-widget">
                    <!-- <div class="box-header with-border text-center" style="background-color: #fff !important; color: #244b90;  border-radius: 6px;">
                        <h1 style="margin-bottom: 20px;">
                            <i class="fa fa-check-circle-o fa-lg" style="color: #00a65a;"></i> &nbsp; Eligibility criteria for non recognized degrees
                        </h1>
                    </div> -->
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="four-zero-three">
                                  <!--  -->
                                  <div class="col-md-12">
                                  
                                  <div class="col-md-12">
                                    <div class="col-md-10">
                                    </div>
                                    <div class="col-md-2" style="margin-left:-30px;">
                                    <?php if(!empty($this->session->userdata('user_id'))){ 
                                            if($this->session->userdata('username')=='administrator'){ ?>
                                                <a class="btn btn-primary" href="<?php echo site_url('admin_dashboard')?>" target="_blank">Back to System Dashboard</a>
                                            <?php }else{ ?>
                                                <!-- <a class="btn btn-primary" href="<?php //echo site_url('dashboard')?>">Back to System Dashboard</a> -->
                                                <a class="btn btn-primary" href="<?php echo site_url('member_dashboard')?>" target="_blank">Back to System Dashboard</a>
                                            <?php } ?>
                                    <?php }else{ ?>
                                        <a class="btn btn-primary" href="http://www.rda.gov.lk/" target="_blank">Back to Website</a>
                                    <?php } ?>
                                    </div>
                                  </div>
                                    <br/>
                                        <div class="col-md-12"><h3>RDA Sri Lanka</h3></div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <div id="map" style="margin-top:10px;"></div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type='hidden' id='selected_switch' name='selected_switch' value='All'>
                                                    
                                                    <div class="row" id="div_class_A" class="hover_div">
                                                        <div class="col-sm-2">
                                                        <div style="border: 1px solid black;width:20px;height:20px;background:red;margin-top:10px;"></div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                        <h5>Class A</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="div_class_B" class="hover_div">
                                                        <div class="col-sm-2">
                                                            <div style="border: 1px solid black;width:20px;height:20px;background:green;margin-top:10px;"></div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <h5>Class B</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="div_District" class="hover_div">
                                                        <div class="col-sm-2">
                                                            <div style="border: 1px solid black;width:20px;height:20px;background:black;margin-top:10px;"></div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <h5>District Boundary</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="div_Offices" class="hover_div">
                                                        <div class="col-sm-2">
                                                            <div style="margin-top:5px;margin-left:-3px;"><img src="<?php echo site_url('assets/images/pin.png');?>" width="28px" height="28px"></div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <h5>Offices</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="div_All" class="hover_div">
                                                        <div class="col-sm-2">
                                                            <div style="border: 1px solid black;width:20px;height:20px;background:white;margin-top:10px;"></div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <h5>All</h5>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        </div>
                                    </div>
                                 <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    var map;
    var bounds;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(7.8169531,80.3676023),
            zoom: 8,
            mapTypeId: "roadmap"
        });
        var infowindow = new google.maps.InfoWindow();

        var url = window.location.origin;

        var data_layer_1 = new google.maps.Data({map: map});
        var data_layer_2 = new google.maps.Data({map: map});
        var data_layer_3 = new google.maps.Data({map: map});
        var data_layer_4 = new google.maps.Data({map: map});

        // data_layer_1.loadGeoJson("<?php //echo site_url('assets/geojson_files/RDA_A_Class_Roads.geojson')?>");//Class_A
        // data_layer_2.loadGeoJson("<?php //echo site_url('assets/geojson_files/Road.json')?>");//Class_B
        // data_layer_3.loadGeoJson("<?php //echo site_url('assets/geojson_files/District.json')?>");
        //data_layer_4.loadGeoJson("<?php //echo site_url('assets/geojson_files/Saved Places.json')?>");
        

        var roads_url_A = "<?php echo site_url('uploads/uploaded_geojson_files/') . $class_A_file; ?>";
        var roads_url_B = "<?php echo site_url('uploads/uploaded_geojson_files/') . $class_B_file; ?>";
        var offices_url = "<?php echo site_url('uploads/uploaded_geojson_files/') . $offices_file; ?>";

        var selected_map = $('#selected_switch').val();

            if(selected_map=='All'){
                $bool_all = true;
                $bool_class_A = false;
                $bool_class_B = false;
                $bool_district = false;
                $bool_offices = false;
            }
            if(selected_map=='A'){
                $bool_all = false;
                $bool_class_A = true;
                $bool_class_B = false;
                $bool_district = false;
                $bool_offices = false;
            }
            if(selected_map=='B'){
                $bool_all = false;
                $bool_class_A = false;
                $bool_class_B = true;
                $bool_district = false;
                $bool_offices = false;
            }
            if(selected_map=='District'){
                $bool_all = false;
                $bool_class_A = false;
                $bool_class_B = false;
                $bool_district = true;
                $bool_offices = false;
            }
            if(selected_map=='Offices'){
                $bool_all = false;
                $bool_class_A = false;
                $bool_class_B = false;
                $bool_district = false;
                $bool_offices = true;
            }

            if($bool_all){
                data_layer_1.loadGeoJson(roads_url_A);//Class_A
                data_layer_2.loadGeoJson(roads_url_B);//Class_B
                data_layer_3.loadGeoJson('assets/geojson_files/District.json');
                data_layer_4.loadGeoJson(offices_url);
            }
            if($bool_class_A){
                data_layer_1.loadGeoJson(roads_url_A);//Class_A
            }
            if($bool_class_B){
                data_layer_2.loadGeoJson(roads_url_B);//Class_B
            }
            if($bool_district){
                data_layer_3.loadGeoJson('assets/geojson_files/District.json');
            }
            if($bool_offices){
                data_layer_4.loadGeoJson(offices_url);
            }
        
            data_layer_1.setStyle({
                    fillColor: 'rgba(0,0,0,0)',
                    strokeColor: 'red',
                    strokeWeight: 2
            });
            data_layer_2.setStyle({
                    fillColor: 'rgba(0,0,0,0)',
                    strokeColor: 'green',
                    strokeWeight: 2
            });
            data_layer_3.setStyle({
                    fillColor: 'rgba(0,0,0,0)',
                    strokeColor: 'black',
                    strokeWeight: 0.75
            });
            data_layer_4.setStyle(function(feature) {
                return {
                    // icon:feature.getProperty('icon');
                    icon: "<?php echo site_url('assets/images/pin.png')?>",
                    title: feature.getProperty('Location').Business_Name 
                };
            });
            //'http://giclk.info/alpha/rda_app/assets/images/pin.png'

            data_layer_1.addListener('click', function(event) { //mouseover
                console.log(event.feature.getProperty('Name'));
                var set_text1 = event.feature.getProperty('Name') + "<br/>" +
                               event.feature.getProperty('Class') + "<br/>" +
                               event.feature.getProperty('TL_Nm_Tran');
                infowindow.setContent(set_text1);
                infowindow.setPosition(event.latLng);
                infowindow.open(map);
            });  

            data_layer_2.addListener('click', function(event) { //mouseover
                console.log(event.feature.getProperty('Name'));
                var set_text2 = event.feature.getProperty('Name');
                infowindow.setContent(set_text2);
                infowindow.setPosition(event.latLng);
                infowindow.open(map);
            });  
            data_layer_3.addListener('click', function(event) { //mouseover
                console.log(event.feature.getProperty('Name'));
                var set_text3 = event.feature.getProperty('Name');
                infowindow.setContent(set_text3);
                infowindow.setPosition(event.latLng);
                infowindow.open(map);
            }); 

            // var marker;
            // var infowindow = new google.maps.InfoWindow();
            // marker = new google.maps.Marker({
            //     position: new google.maps.LatLng(data.latitute, data.logitude),
            //     map: map,
            //     icon: 'https://pssp.health.gov.lk/maptool/assets/images/hi_marker.png'
            // });  

            data_layer_4.addListener('click', function(event) { //mouseover
                console.log(event.feature.getProperty('Location').Business_Name);
                var set_text3 = event.feature.getProperty('Location').Business_Name + "<br/>" +
                                event.feature.getProperty('Location').Address;
                infowindow.setContent(set_text3);
                infowindow.setPosition(event.latLng);
                infowindow.open(map);
            });       
    }

    $(document).ready(function($){
        
        $(document).on('click', '#div_class_A', function () {
            $('#selected_switch').val('A');
            initMap();
        });
        $(document).on('click', '#div_class_B', function () {
            $('#selected_switch').val('B');
            initMap();
        });
        $(document).on('click', '#div_District', function () {
            $('#selected_switch').val('District');
            initMap();
        });
        $(document).on('click', '#div_All', function () {
            $('#selected_switch').val('All');
            initMap();
        });
        $(document).on('click', '#div_Offices', function () {
            $('#selected_switch').val('Offices');
            initMap();
        });
    });

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLMa3iWxS66YYjxWGrY1RGJgz391f9vw4&libraries=drawing,geometry&callback=initMap" async defer>
</script>