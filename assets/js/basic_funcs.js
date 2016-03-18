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

    $(".admin_manage_btn").hover(function(){
        if($(this).attr("src").indexOf('show_icon.png') > -1){
            $(this).attr("src", function(i, old){
                return old.replace("show_icon.png","hide_icon.png")
            })
        }else{
            $(this).attr("src", function(i, old){
                return old.replace("hide_icon.png","show_icon.png")
            })
        }
    });
}