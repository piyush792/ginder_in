<script language="javascript">
    $("#main-nav li").each(function() {
        var hreflink = $(this).attr("href");
        if (hreflink.toLowerCase()==location.href.toLowerCase()) {
            $(this).parent("li").addClass("active open");
        }
    });
</script> 

<div id="navi" class="navi">
    <ul id="main-nav" class='main-nav'>

        <li <?php echo ($this->request->params['controller']=='admins' && $this->request->params['action']=='admin_index') ? 'class="active open"' : '' ?>>
            <?php echo $this->Html->link('<div class="ico"><i class="icon-home icon-white"></i></div> Dashboard', '/admin/index', array('escape' => false, 'class' => 'light')); ?>
        </li>

        <li <?php echo ($this->request->params['controller']=='categories' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="active open"' : '' ?>>
            <?php echo $this->Html->link('<div class="ico"><i class="icon-home icon-white"></i></div> Category Management', array('controller'=>'categories','action'=>'admin_index'), array('escape' => false, 'class' => 'light')); ?>
        </li>

        <li <?php echo ($this->request->params['controller']=='users' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="active open"' : '' ?>>
            <?php echo $this->Html->link('<div class="ico"><i class="icon-home icon-white"></i></div> User Management', array('controller'=>'users','action'=>'admin_index'), array('escape' => false, 'class' => 'light')); ?>
        </li>

        <li>
            <a href="#" class='light toggle-collapsed'>
                <div class="ico"><i class="icon-th-large icon-white"></i></div>
                Product Management
            </a>
            <ul class="collapsed-nav <?php echo (!in_array($this->request->params['controller'], array('products','product_attributes','product_attribute_values'))) ? 'closed' : '' ?>"> <!--for closing remove closed-->
                <li <?php echo ($this->request->params['controller'] == 'products' && $this->request->params['action'] == 'admin_index') ? 'class="active"' : '' ?>>
                    <?php echo $this->Html->link('Products', array('controller' => 'products','action' => 'index'));?>
                </li>
                <li <?php echo ($this->request->params['controller'] == 'product_attributes' && $this->request->params['action'] == 'admin_index') ? 'class="active"' : '' ?>>
                    <?php echo $this->Html->link('Product Attributes', array('controller' => 'product_attributes','action' => 'admin_index'));?>
                </li>
                <li <?php echo ($this->request->params['controller'] == 'product_attribute_values' && $this->request->params['action'] == 'admin_index') ? 'class="active"' : '' ?>>
                    <?php echo $this->Html->link('Product Attributes Values', array('controller' => 'product_attribute_values','action' => 'admin_index'));?>
                </li>
            </ul>
        </li>

        <li <?php echo ($this->request->params['controller']=='EmailTemplates' && (in_array($this->request->params['action'],array('admin_index','admin_add','admin_edit')))) ? 'class="active open"' : '' ?>>
            <?php echo $this->Html->link('<div class="ico"><i class="icon-home icon-white"></i></div> Email Management', array('controller'=>'EmailTemplates','action'=>'admin_edit'), array('escape' => false, 'class' => 'light')); ?>
        </li>
        
        <li <?php echo (in_array($this->request->params['controller'], array('admins')) && $this->request->params['action']=='admin_change_password')?'class="active open"':''?>>
            <?php echo $this->Html->link('<div class="ico"><i class="icon-wrench icon-white"></i></div>Settings'.$this->Html->image('toggle-subnav-down.png',array('alt'=>'')),'/admin/',array('escape'=>false,'class'=>'light toggle-collapsed')); ?>
            <ul class="collapsed-nav <?php echo (!in_array($this->request->params['controller'], array('admins'))) ? 'closed' : '' ?>">
                <li <?php echo ($this->request->params['controller'] == 'admins') ? 'class="active"' : '' ?>>
                    <?php echo $this->Html->link('Change Password', '/admin/admins/change_password/'); ?>
                </li>
            </ul>
        </li>
    </ul>
</div>