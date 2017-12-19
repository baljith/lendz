<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="active">User list</li>
    </ol>
    <h1 class="page-header">User list<small></small></h1>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-inverse">
                <div class="panel-body">
                   <div class="col-md-12">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>User Email</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Account Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // echo '<pre>';
                                // print_r($userdata);die();
                                if(!empty($userdata))
                                {
                                    foreach($userdata as $user)
                                    {
                                        ?>
                                            <tr class="gradeA">
                                                <td><?php echo $user['User_Id']; ?></td>
                                                <td><?php echo $user['Username']; ?></td>
                                                <td><?php echo $user['User_Email']; ?></td>
                                                <td><?php echo $user['User_Phone']; ?></td>
                                                <td><?php echo $user['User_Address']; ?></td>
                                                <td><?php if($user['Verified'] == 1) { echo '<span class="badge badge-pill badge-success">Verified</span>'; } else { echo '<span class="badge badge-pill badge-info">Not Verified</span>'; } ?></td>
                                                 <td>
                                                    <div class="btn_three"> 
                                                        <a href="<?php echo base_url('users/view/'.$user['User_Id']); ?>" class="btn edit_btn">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                        <a title="Chat" href="<?php echo base_url('chat/messages/'.$user['User_Id']); ?>" type="button" class="btn edit_btn" title="<?php echo $this->lang->line('click_here_to_chat'); ?>">
                                                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>