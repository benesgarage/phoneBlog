 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/views/user_auth/css/style.css">
 <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>

<h2><?php echo $title; ?></h2>
 <hr/>
<?php
echo "<div class='error_msg'>";
echo validation_errors();
echo "</div>"; ?>

<?php echo form_open('posts/create'); ?>
<label>Author :</label>
<input type="text" name="user" title="User" style="color:#888;"
       value="<?php
       if (isset($_SESSION['logged_in'])){
           echo $_SESSION['logged_in']['username'];
       }else{
           echo 'Anonymous';
       }
       ?>"
       readonly="true"/>
<label for="title">Title :</label>
<input type="input" name="title" /><br />
<label for="text">Text :</label>
<textarea name="body"></textarea><br />

<input type="submit" name="submit" value="Create post" />

</form>