$(document).ready(function(){
    main();
});

function main() {
    $("#posts").DataTable();

    if (location.pathname.indexOf("/create") != -1) {
        $("#create_post").addClass("active");
    } else if (location.pathname.indexOf("/posts") != -1) {
        $("#home").addClass("active");
    } else if (location.pathname.indexOf("/user_registration_show") != -1 || location.pathname.indexOf("/new_user_registration") != -1 )  {
        $("#register").addClass("active");
    } else if (location.pathname.indexOf("/user_login_process") != -1 || location.pathname.indexOf("/logout") != -1) {
        $("#login_button").addClass("active");
    } else if (location.pathname.indexOf("/admin_page") != -1) {
        $("#profile_button").addClass("active");
    }
}