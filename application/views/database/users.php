<div class="main">
    <div class="container">
        <h3>Current user: <?php echo $_SESSION['logged_in']['username']?></h3>
        <hr>
        <h3>Role: <?php echo $_SESSION['logged_in']['role_name']?></h3>
        <hr>
        <h3>Select a user to manage:</h3>
        <ul class="user_list">
            <?php
            foreach($user_names as $user_id => $user_name){
                echo '<li class="user_element">'.$user_name.'<a href=""><img class="user_img" src="';
                echo base_url('assets/images/edit.png');
                echo '"></a></li>';
            }
            ?>
        </ul>
        <hr>
    </div>
</div>