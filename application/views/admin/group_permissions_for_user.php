  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Group Permissions</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
          <div class="box-header">
            <i class="fa fa-users text-blue"></i>

            <h3 class="box-title">Group Permissions</h3>

            
          </div>
          <div class="box-body">

            <div style="max-height: 400px; overflow-y: scroll;">
                <div id="tree"></div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-3">
                <button class="btn btn-primary" id="save_perms">Save</button>
              </div>
            </div>

          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->