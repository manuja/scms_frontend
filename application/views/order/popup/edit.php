
<div class="modal fade rotate" id="update-staff" style="display:none;">
    <div class="modal-dialog modal-lg"> 
        <form id="update-staff-form" method="post">   
            <div class="modal-content panel panel-primary">
                <div class="modal-header panel-heading">
                    <h4 class="modal-title -remove-title">Edit/Update</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body panel-body" id="render-update-data">
                   <!--  <div class="text-center"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div> -->
                   <!--  <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="nameedit" class="form-control input-staff-firstname" id="name-nameedit" placeholder="Name">
                            </div>
                        </div>                        
                    </div> -->
                    <div class="row">
                    <div class="col-md-3">
                            <div class="form-group">
                                <select id="droporderitemedit" name="droporderitemedit" class="form-control" required>
                                    <option selected value="">Select Order Item</option>
                                    
                                </select>
                            </div>
                        </div>
                         <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" name="qtyedit" class="form-control input-staff-qtyedit" id="qtyedit" placeholder="qtyedit">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      
                                <input type="hidden" name="orderidvaledit" class="form-control input-staff-email" id="orderidvaledit" placeholder="orderid">
                         
                                <input type="hidden" name="ListItemId" class="form-control input-staff-email" id="ListItemId" placeholder="listitem">

                                <input type="text" name="qtyedithide" class="form-control input-staff-qtyedithide" id="qtyedithide" placeholder="qtyedithide">
                          
                        <!-- <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="emailedit" class="form-control input-staff-email" id="emailedit" placeholder="Email">
                            </div>
                        </div> -->
                        <!-- <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="addressedit" class="form-control input-staff-address" id="addressedit" placeholder="Address" required>
                            </div>
                        </div> -->
                    </div>

                    <!-- <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="mobileedit" class="form-control input-staff-contactno" id="mobile" placeholder="Mobile No">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="number" name="salaryedit" class="form-control input-staff-salary" id="salaryedit" placeholder="Salary">
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer panel-footer">
                    <div class="row">
                        <div class="col-sm-12">                            
                            <button type="button" class="btn rkmd-btn btn-success" data-addempid="" id="update-staff">Update</button> 
                            <button type="button" class="btn rkmd-btn btn-danger" data-dismiss="modal">Close</button>
                        </div>                    
                    </div>
                </div>
            </div>
        </form>      
    </div>
</div>
