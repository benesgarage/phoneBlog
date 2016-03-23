<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>KITMAKER Posts</title>
        <link rel="stylesheet" href="<?php echo base_url("application/views/database/style.css"); ?>">
    </head>
    <body>
    <div class="headboard">
        <img src="<?php echo base_url('assets/images/administrator.png');?>">
        <img class="title" src="<?php echo base_url('assets/images/adminSec.png');?>">
        <ul class="nav-list">
            <a href="<?php echo base_url('/access_control');?>"><li>Home</li></a>
            <a href="<?php echo base_url('/access_control/users');?>"><li>Users</li></a>
            <a href="<?php echo base_url('/access_control/roles');?>"><li>Roles</li></a>
            <a href="<?php echo base_url('/access_control/permissions');?>"><li>Permissions</li></a>
        </ul>
    </div>