<div class="main">
    <div class="container">
        <h3>Current user: <?php echo $_SESSION['logged_in']['username']?></h3>
        <hr>
        <h3>Role: <?php echo $_SESSION['logged_in']['role_name']?></h3>
        <hr>
        <h3><?php echo $manage_message ?></h3><hr>
        <?php echo form_open('access_control/'.$method.'/'.$slug); ?>
        <?php
        if(isset($role_names)) {
            ?>
            <br>
            <div class="form_item">
                <span>Role:</span>
                <select name="role" class="role_dropdown">
                    <?php
                    foreach ($role_names as $rid => $name) {
                        echo '<option';
                        if ($managed_user_data['id_role'] == $rid) {
                            echo ' selected=selected';
                        }
                        echo ' value="' . $rid . '">' . $name . '</option>';
                    }
                    ?>
                </select>
            </div>
            <?php
        }
        ?>
        <h4>Permissions:</h4>
        <ul class="perm_list">
            <?php
                foreach ($perm_names as $pid => $name){
                    echo '<li>'.$name.'<select class="perm_dropdown" name="'.$pid.'">';
                    foreach ($functions as $fid => $func){
                        echo '<option';
                        if(isset($perms[$pid]) and $perms[$pid] == $fid){
                            echo ' selected=selected value =""';
                        }elseif(!isset($perms[$pid]) and $fid == -1){
                            echo ' selected=selected value =""';
                        }else{
                            echo ' value='.$fid;
                        }
                        echo '>'.$func;
                        echo '</option>';
                        }
                    echo '</select></li>';
                }
            ?>
        </ul>
        <div style="clear: both"></div>
        <input class="submit_button" type="submit" value=" Confirm changes " name="submit"/>
        <?php
        if (isset($confirm_message)) {
        echo "<div class='confirm_message'>";
            echo $confirm_message;
            echo "</div>";
        }
        ?>
        <br />
        <?php echo form_close(); ?>

    </div>
</div>