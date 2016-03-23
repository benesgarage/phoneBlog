<div class="main">
    <div class="container">
        <h3>Current user: <?php echo $_SESSION['logged_in']['username']?></h3>
<hr>
<h3>Role: <?php echo $_SESSION['logged_in']['role_name']?></h3>
<hr>
<h3>Select a permission to manage:</h3>
<ul class="perm_list">
    <?php
    foreach($perm_names as $perm_id => $perm_name){
        echo '<li class="perm_element">'.$perm_name.'<a href=""><img class="perm_img" src="';
        echo base_url('assets/images/edit.png');
        echo '"></a></li>';
    }
    ?>
</ul>
<hr>
</div>
</div>