<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>KITMAKER Posts</title>
    </head>
    <body>
    <?php
        $_SESSION["brand_name"] = MyWurfl::get('brand_name');
        if($_SESSION["brand_name"] == "generic web browser"){
            $_SESSION["brand_name"] = MyWurfl::get('advertised_browser');
        }
        $_SESSION["model_name"] = MyWurfl::get('model_name');
    ?>
        <h1>Hi <?php if(isset($_SESSION['logged_in'])){
                echo $_SESSION['logged_in']['username'];
            }else {
                echo 'Anon';
            }
            ?>!<img id="device" src="<?php echo base_url(); ?>assets/images/<?php
            if (MyWurfl::get('is_phone') == true){
                echo 'cell_icon.png';
            }elseif(MyWurfl::get('is_tablet') == true){
                echo 'tablet_icon.png';
            }elseif(MyWurfl::get('is_full_desktop') == true){
                echo 'desktop_icon.png';
            }else{
                echo 'questionmark_icon.png';
            }
            ?>">
            <label id="device_brand"><?php echo $_SESSION['brand_name']?></label>
            <label id="device_model"><?php echo $_SESSION['model_name']?></label></h1>
        <div id="wrapper">
            <div id="menu">
                <div id="content">