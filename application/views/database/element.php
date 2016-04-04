<div class="main">
    <div class="container">
        <h3>Current user: <?php echo $_SESSION['logged_in']['username']?></h3>
        <hr>
        <h3>Role: <?php echo $_SESSION['logged_in']['role_name']?></h3>
        <hr>
        <h3><?php echo $object_title ?></h3>
        <ul class="user_list">
            <?php
            foreach($names as $id => $name){
                echo '<li class="user_element">'.$name.'<a href="';
                echo site_url('/access_control').'/'.$method.'/'.$name.'_'.$id;
                echo '"><img class="user_img" src="';
                echo base_url('assets/images');
                if($method == 'permission_edit'){
                    echo '/delete.png';
                }else{
                    echo '/edit.png';
                }
                echo '"></a></li>';
            }
            ?>
        </ul>
        <hr>
    </div>
</div>