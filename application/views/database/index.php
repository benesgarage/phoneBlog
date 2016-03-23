<div class="main">
        <div class="container">
            <h3>Current user: <?php echo $_SESSION['logged_in']['username']?></h3>
            <hr>
            <h3>Role: <?php echo $_SESSION['logged_in']['role_name']?></h3>
            <hr>
            <h3>Permissions:</h3>
            <ul class="perm_list">
                <?php
                foreach($perm_names as $perm_id => $perm_name){
                    echo '<li class="perm_element">'.$perm_name.'<img class="perm_img" src="';
                    if(isset($perms[$perm_id]) and $perms[$perm_id] == TRUE){
                        echo base_url('assets/images/good.png');
                    }else{
                        echo base_url('assets/images/bad.png');
                    }
                    echo '"></li>';
                    }
                ?>
            </ul>
            <hr>
        </div>
</div>