<?php
$user_info = isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : -1;   //if user is logged, pass user data to variable

if ($user_info != -1) {                                                     //if variable has acquired user data
    $username = ($user_info['username']);
    $email = ($user_info['email']);
} else {                                                                    //otherwise redirect to login page
    header("location:".base_url()."user_auth/logout");
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
    echo "<p>You are navigating our page via " .$_SESSION['brand_name']." ".$_SESSION['model_name']."</p>";
    ?>
</div>
<br/>