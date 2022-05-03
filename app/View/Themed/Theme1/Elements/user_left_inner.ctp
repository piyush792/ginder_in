<ul>
    <li class='adim-nav-item'>
    <?php echo $this->Html->link($this->Html->image("icon-admin-manage-ads.png").' <span> Manage Ads</span>', array('controller'=>'users','action'=>'/index'), array('escape' => false, 'class'=>'nav-admin-icon')); ?>
    </li>
    <li class='adim-nav-item'>
    <?php echo $this->Html->link($this->Html->image("icon-admin-personalinfo.png").' <span> Personal Info</span>', array('controller'=>'users','action'=>'/profile'), array('escape' => false, 'class'=>'nav-admin-icon')); ?>
    </li>
    <li class='adim-nav-item'>
    <?php echo $this->Html->link($this->Html->image("icon-admin-settings.png").' <span> Settings</span>', array('controller'=>'users','action'=>'/change_password'), array('escape' => false, 'class'=>'nav-admin-icon')); ?>
    </li>
</ul>