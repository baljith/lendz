<?php 
if(!empty($messags))
{
    ?>
    <li class="dropdown-header">Messages (<?php echo count($messags); ?>)</li>
    <?php 
    foreach($messags as $msg)
    {
        ?>
        <li class="media">
            <?php
            if(!empty($msg['Thread']))
            {
                ?>
                <a href="<?php echo base_url('chat/user/'.$msg['Sent_By'].'/'.$msg['Thread'].'/'.$msg['Thread_Type']); ?>">
                <?php
            }
            else
            {
                ?>
                <a href="<?php echo base_url('chat/user/'.$msg['Sent_By']); ?>">
                <?php
            }
            ?> 
            
                <div class="media-left">
                <?php 
                if(!empty($msg['User_Image']))
                {
                    ?>
                    <img src="<?php echo base_url('assets/upload/profile_pictures/'.$msg['User_Image']); ?>" class="media-object" alt="">
                    <?php
                }
                else
                {
                    ?>
                    <i class="media-object bg-green"><?php echo substr(ucfirst($msg['User_First_Name']),0,1); ?></i>
                    <?php
                }
                ?>
                </div>
                <div class="media-body">
                    <h6 class="media-heading"  style="font-size: 14px;"><?php echo ucfirst($msg['User_First_Name'])." ".ucfirst($msg['User_Last_Name']); ?></h6>
                    <p>
                    <?php if(strlen($msg['Message'])>50){ echo substr($msg['Message'],0,50)."..."; }else{ echo $msg['Message']; } ?>
                    </p>
                    <div class="text-muted f-s-11"><?php echo date_visible($msg['Date']); ?></div>
                </div>
            </a>
        </li>
        <?php
    }
?>
<li class="dropdown-footer text-center">
            <a href="<?php echo base_url('chat/messages'); ?>">View all</a>
        </li>
<?php
}
else
{
    ?>
    <li class="dropdown-header">Messages (0)</li>
    <li class="media">
        <a href="javascript:;">
            <div class="media-body">
                <p>No new messages</p>
            </div>
       </a>
    </li>
    <li class="dropdown-footer text-center">
        <a href="<?php echo base_url('chat/messages'); ?>">View old messages</a>
    </li>
    <?php
}
?>
