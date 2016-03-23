<div class="main">
    <div class="container">
        <h3>Current user: <?php echo $_SESSION['logged_in']['username']?></h3>
<hr>
<h3>Role: <?php echo $_SESSION['logged_in']['role_name']?></h3>
<hr>
<h3>Select a role to manage:</h3>
<ul class="role_list">
    <?php
    foreach($role_names as $role_id => $role_name){
        echo '<li class="role_element">'.$role_name.'<a href=""><img class="role_img" src="';
        echo base_url('assets/images/edit.png');
        echo '"></a></li>';
    }
    ?>
</ul>
<hr>
</div>
</div>