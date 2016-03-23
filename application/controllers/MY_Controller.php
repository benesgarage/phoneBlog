<?php
class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    protected function user_is_logged()
    {
        if(isset($_SESSION['logged_in'])){
            return TRUE;
        }
        return FALSE;
    }
}