<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('posts/create'); ?>
<label>Author</label>
<input type="text" name="user" title="User" style="color:#888;"
       value="<?php
       if (isset($_SESSION['logged_in'])){
           echo $_SESSION['logged_in']['username'];
       }else{
           echo 'Anonymous';
       }
       ?>"
       readonly="true"/>
<label for="title">Title</label>
<input type="input" name="title" /><br />
<label for="text">Text</label>
<textarea name="body"></textarea><br />

<input type="submit" name="submit" value="Create post item" />

</form>