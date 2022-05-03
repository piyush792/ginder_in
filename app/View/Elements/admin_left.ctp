<!-- Left sidebar section start -->
<div class='admin-navigation-wrapper'>
    <ul>

    <li <?php echo ($this->request->params['controller']=='categories' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-cog"></span>Category Management', array('controller'=>'categories','action'=>'admin_index'), array('escape' => false, 'class' => 'light')); ?>
    </li>

    <li <?php echo ($this->request->params['controller']=='users' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-user"></span>User Management', array('controller'=>'users','action'=>'admin_index'), array('escape' => false, 'class' => 'light')); ?>
    </li>

    <li <?php echo ($this->request->params['controller'] == 'products' && $this->request->params['action'] == 'admin_index') ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-cog"></span>Products', array('controller' => 'products','action' => 'index'), array('escape' => false, 'class' => 'light'));?>
    </li>

    <li <?php echo ($this->request->params['controller'] == 'products' && $this->request->params['action'] == 'admin_manage_products') ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-cog"></span>Manage Products', array('controller' => 'products','action' => 'manage_products'), array('escape' => false, 'class' => 'light'));?>
    </li>
    
    <!--<li <?php //echo ($this->request->params['controller']=='products' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php //echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-user"></span>Transaction Lists', array('controller'=>'products','action'=>'admin_transaction_lists'), array('escape' => false, 'class' => 'light')); ?>
    </li>-->

    <li <?php echo ($this->request->params['controller']=='products' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-user"></span>Premium Ads Expired', array('controller'=>'products','action'=>'admin_premium_ads_expire'), array('escape' => false, 'class' => 'light')); ?>
    </li>
    <!-- <li <?php //echo ($this->request->params['controller']=='products' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php //echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-user"></span>Premium Ads Reminder Mail', array('controller'=>'products','action'=>'admin_premium_ads_reminder_mail'), array('escape' => false, 'class' => 'light')); ?>
    </li> -->

    <li <?php echo ($this->request->params['controller']=='users' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-user"></span>Recent Ads Expired', array('controller'=>'products','action'=>'admin_unpaid_ads_expire'), array('escape' => false, 'class' => 'light')); ?>
    </li>
    <!-- <li <?php //echo ($this->request->params['controller']=='users' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php //echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-user"></span>Recent Ads Reminder Mail', array('controller'=>'products','action'=>'admin_unpaid_ads_reminder_mail'), array('escape' => false, 'class' => 'light')); ?>
    </li> -->

    <li <?php echo ($this->request->params['controller'] == 'product_attributes' && $this->request->params['action'] == 'admin_index') ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-cog"></span>Attributes', array('controller' => 'product_attributes','action' => 'admin_index'), array('escape' => false, 'class' => 'light'));?>
    </li>

    <li <?php echo ($this->request->params['controller'] == 'product_attribute_values' && $this->request->params['action'] == 'admin_index') ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-cog"></span>Attributes Values', array('controller' => 'product_attribute_values','action' => 'admin_index'), array('escape' => false, 'class' => 'light'));?>
    </li>

    <li <?php echo ($this->request->params['controller']=='EmailTemplates' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-cog"></span>Email Management', array('controller'=>'EmailTemplates','action'=>'admin_edit'), array('escape' => false, 'class' => 'light')); ?>
    </li>

    <li <?php echo ($this->request->params['controller']=='contents' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-cog"></span>Web Pages Management', array('controller'=>'contents','action'=>'admin_index'), array('escape' => false, 'class' => 'light')); ?>
    </li>

    <li <?php echo ($this->request->params['controller']=='social_links' && (in_array($this->request->params['action'],array('index')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-list-alt"></span>Social Links', array('controller'=>'social_links','action'=>'admin_index'), array('escape' => false, 'class' => 'light')); ?>
    </li>

    <li <?php echo ($this->request->params['controller']=='reports' && (in_array($this->request->params['action'],array('index')))) ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-list-alt"></span>Reports', array('controller'=>'reports','action'=>'admin_index'), array('escape' => false, 'class' => 'light')); ?>
    </li>


    <li <?php echo ($this->request->params['controller'] == 'admins') ? 'class="adim-nav-item active"' : 'class="adim-nav-item"' ?>>
        <?php echo $this->Html->link('<span class="nav-admin-icon glyphicon glyphicon-cog"></span>Change Password', '/admin/admins/change_password/', array('escape' => false, 'class' => 'light')); ?>
    </li>

    <!-- <li class='adim-nav-item active'><a href='superadmin-manage-ads.html'><span class="nav-admin-icon glyphicon glyphicon-cog"></span>Manage
        Ads</a></li>
    <li class='adim-nav-item'><a href='superadmin-manage-user-profiles.html'><span class="nav-admin-icon glyphicon glyphicon-user"></span>User
        Profile</a></li>
    <li class='adim-nav-item'><a href='superadmin-manage-social-links.html'><span class="nav-admin-icon glyphicon glyphicon-link"></span>Social
        Links</a></li>
    <li class='adim-nav-item'><a href='superadmin-manage-reports.html'><span class="nav-admin-icon glyphicon glyphicon-list-alt"></span>Reports</a></li>
    <li class='adim-nav-item'><a href='superadmin-manage-adminusers.html'><span class="nav-admin-icon glyphicon glyphicon-cog"></span>Admin
        Users</a>
    </li> -->
    </ul>
</div>
<!-- Left sidebar section end -->