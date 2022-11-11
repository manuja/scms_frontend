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
        <li class="active">Users</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <h1>Users</h1>
      <table class="table">
        <thead style="font-size: 16px;">
          <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Username</th>
            <th>Group</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            for($i = 1; $i <= 10; $i++) {
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td>User <?php echo $i; ?></td>
            <td>user<?php echo $i; ?></td>
            <td>Group <?php echo $i; ?></td>
            <td>Active</td>
            <td><a href="#" class="btn btn-danger">Deactivate</a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->