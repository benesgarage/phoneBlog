<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('posts/create'); ?>

<label for="title">Title</label>
<input type="input" name="title" /><br />

<label for="text">Text</label>
<textarea name="body"></textarea><br />

<input type="submit" name="submit" value="Create post item" />

</form>