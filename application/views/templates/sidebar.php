  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- search form -->

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">


       <li class="   ">
        <a href="<?php echo site_url('auth/dashboard'); ?>">
          <i class="fa fa-tachometer"></i> <span>Dashboard</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-database"></i>
          <span>Master Data</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">6</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url('class_of_membership/index'); ?>"><i class="fa fa-circle-o"></i> Class of Membership</a></li>
          <li><a href="<?php echo site_url('engineering_discipline/index'); ?>"><i class="fa fa-circle-o"></i> Engineering Discipline</a></li>
          <li><a href="<?php echo site_url('place_of_work/index'); ?>"><i class="fa fa-circle-o"></i> Place of Work</a></li>
          <li><a href="<?php echo site_url('type_of_institution/index'); ?>"><i class="fa fa-circle-o"></i> Type of Institution</a></li>
          <li><a href="<?php echo site_url('payment_methods/index'); ?>"><i class="fa fa-circle-o"></i> Payment Methods</a></li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-circle-o"></i>
              <span>Payment Categories</span>
              <span class="pull-right-container">
                <span class="label label-primary pull-right">2</span>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url('main_payment_categories/index'); ?>"><i class="fa fa-circle-o"></i> Main Payment Categories</a></li>
              <li><a href="<?php echo site_url('sub_payment_categories/index'); ?>"><i class="fa fa-circle-o"></i> Sub Payment Categories</a></li>
            </ul>
          </li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-money"></i>
          <span>Finance</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">3</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url('payment_registry/index'); ?>"><i class="fa fa-circle-o"></i> Payment Registry</p></a></li>
          <li><a href="<?php echo site_url('outstanding_payments/index'); ?>"><i class="fa fa-circle-o"></i> Outstanding Payments</p></a></li>
          <li><a href="<?php echo site_url('bulk_payments/index'); ?>"><i class="fa fa-circle-o"></i> Bulk Payments</p></a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Membership Applications</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">5</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url('membership_applications'); ?>"><i class="fa fa-circle-o"></i> Normal Membership <p style="padding-left: 24px;">Applications</p></a></li>
          <li><a href="<?php echo site_url('membership_applications/show_membership_reinstatement_applications'); ?>"><i class="fa fa-circle-o"></i> Membership Reinstatement <p style="padding-left: 24px;">Applications</p></a></li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-circle-o"></i>
              <span>Technical Engineers</span>
              <span class="pull-right-container">
                <span class="label label-primary pull-right">2</span>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url('membership_applications/show_technical_engineer_applications'); ?>"><i class="fa fa-circle-o"></i> Technical Engineer <p style="padding-left: 24px;">Applications</p></a></li>
              <li><a href="<?php echo site_url('membership_applications/show_viva_results'); ?>"><i class="fa fa-circle-o"></i> Viva Results</a></li>
            </ul>
          </li>
          <li><a href="<?php echo site_url('membership_applications/show_membership_transfer_applications'); ?>"><i class="fa fa-circle-o"></i> Membership Transfer <p style="padding-left: 24px;">Applications</p></a></li>
          <li><a href="<?php echo site_url('membership_applications/show_b_paper_applications'); ?>"><i class="fa fa-circle-o"></i> B Paper <p style="padding-left: 24px;">Applications</p></a></li>
          <li><a href="<?php echo site_url('membership_applications/show_direct_route_membership_applications'); ?>"><i class="fa fa-circle-o"></i> Direct Route Membership <p style="padding-left: 24px;">Applications</p></a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-user"></i>
          <span>User Management</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">3</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url('auth/index'); ?>"><i class="fa fa-circle-o"></i> Users</a></li>
          <li><a href="<?php echo site_url('auth/groups'); ?>"><i class="fa fa-circle-o"></i> Groups</a></li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-circle-o"></i>
              <span>Permissions</span>
              <span class="pull-right-container">
                <span class="label label-primary pull-right">3</span>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url('permissions'); ?>"><i class="fa fa-circle-o"></i> System Permissions</a></li>
              <li><a href="<?php echo site_url('group_permissions'); ?>"><i class="fa fa-circle-o"></i> Group Permissions</a></li>
              <li><a href="<?php echo site_url('user_permissions'); ?>"><i class="fa fa-circle-o"></i> User Permissions</a></li>
            </ul>
          </li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Membership Groups</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">7</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url('membership_groups/index'); ?>"><i class="fa fa-circle-o"></i> View Membership Groups</p></a></li>
          <li><a href="<?php echo site_url('membership_groups/create_membership_group'); ?>"><i class="fa fa-circle-o"></i> Create Membership Group</p></a></li>
          <li><a href="<?php echo site_url('membership_groups/add_members_to_group'); ?>"><i class="fa fa-circle-o"></i> Add Members to Group</p></a></li>
          <li><a href="<?php echo site_url('membership_groups/group_meetings'); ?>"><i class="fa fa-circle-o"></i> Group Meetings</p></a></li>
          <li><a href="<?php echo site_url('membership_groups/create_event'); ?>"><i class="fa fa-circle-o"></i> Create Event</p></a></li>
          <li><a href="<?php echo site_url('membership_groups/add_documents'); ?>"><i class="fa fa-circle-o"></i> Add Documents</p></a></li>
          <li><a href="<?php echo site_url('membership_groups/send_message'); ?>"><i class="fa fa-circle-o"></i> Send Message</p></a></li>
        </ul>
      </li>

      <li class="   ">
        <a href="<?php echo site_url('membership_directory/index'); ?>">
          <i class="fa fa-address-book"></i> <span>Membership Directory</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-check-square-o"></i>
          <span>Professional Review</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">2</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url('professional_review/pr_results'); ?>"><i class="fa fa-circle-o"></i> PR Results</p></a></li>
          <li><a href="<?php echo site_url('professional_review/pr_check_list'); ?>"><i class="fa fa-circle-o"></i> PR Check List</p></a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-check-square-o"></i>
          <span>CDP</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">1</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url('cdp/cdp_check_list'); ?>"><i class="fa fa-circle-o"></i> CDP Check List</p></a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Resource Person</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">2</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url('resource_person/resource_person_payment_information'); ?>"><i class="fa fa-circle-o"></i> Payments</p></a></li>
          <li><a href="<?php echo site_url('resource_person/resource_person_applications'); ?>"><i class="fa fa-circle-o"></i> Applications</p></a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-university"></i>
          <span>Training Organizations</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">1</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url('training_organizations/training_organization_evaluation_applications'); ?>"><i class="fa fa-circle-o"></i> Applications</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>