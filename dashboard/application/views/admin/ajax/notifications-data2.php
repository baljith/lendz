<?php 
if(!empty($notification))
{
    //print_r($notification);
    ?>
    <li class="dropdown-header">Notifications (<?php echo count($notification); ?>)</li>
    <?php 
    foreach($notification as $msg)
    {   
        ?>
        <li class="media">
            <?php 
            if($msg['Notification_Type']=='new_tool')
            {
                ?>
                <a data-id="<?php echo $msg['N_Id']; ?>" href="<?php echo base_url('users/tool_view/'.$msg['Tool_Id'].'/tool    '); ?>" onclick="update_notification(this)">
                <?php
            }
            else if($msg['Notification_Type']=='show_tools')
            {
                ?>
                <a class="link_p" href="<?php echo base_url('users/notifications/'.$msg['N_Id']); ?>">
                <?php
            }
            else
            {
                ?>
                <a href="<?php echo base_url('users/notifications'); ?>">
                <?php
            }
            ?>
           
                <div class="media-body">
                    <p>
                    <?php
                    $msg_show = ucfirst($msg['User_First_Name'])." ".ucfirst($msg['User_Last_Name'])." (".get_role_name($msg['Role']).")".$msg['Notification'];
                     if(strlen($msg_show)>50){ echo substr($msg_show,0,50)."..."; }else{ echo $msg_show; } ?>
                    </p>
                    <div class="text-muted f-s-11"><?php echo date_visible($msg['Date']); ?></div>
                </div>
            </a>
        </li>
        <?php
    }
?>
<li class="dropdown-footer text-center">
            <a href="<?php echo base_url('users/notifications'); ?>">View all</a>
        </li>
<?php
}
else
{
    ?>
    <li class="dropdown-header">Notifications (0)</li>
    <li class="media">
        <a href="javascript:;">
            <div class="media-body">
                <p>No new notifications</p>
            </div>
       </a>
    </li>
    <li class="dropdown-footer text-center">
        <a href="<?php echo base_url('users/notifications'); ?>">View old notifications</a>
    </li>
    <?php
}
?>
