<?php
if (isset($this->session->userdata['logged_in'])) {
    $username = ($this->session->userdata['logged_in']['username']);
    $email = ($this->session->userdata['logged_in']['email']);
} else {
}
?>
<div id="profile">
    <?php
    echo "<b id='welcome'><i>" . $_SESSION['logged_in']['username'] ."</i></b>";
    echo "<br/>";
    echo "<br/>";
    echo "<p>Welcome to your basic profile page</p>";
    echo "<br/>";
    echo "<br/>";
    echo "<p>Your Username is " . $_SESSION['logged_in']['username']."</p>";
    echo "<br/>";
    echo "<p>Your Email is " . $_SESSION['logged_in']['email']."</p>";
    echo "<br/>";
    echo "<p>You our navigating our page via " .$_SESSION['brand_name']." ".$_SESSION['model_name']."</p>";
    ?>
</div>
<br/>