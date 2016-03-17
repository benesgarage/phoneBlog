$(document).ready(function(){
    main();
});

function main() {
    $("#posts").DataTable();

    if (location.pathname == '/phoneBlog/posts') {
        $("#home").addClass("active");
    } else if (location.pathname == '/phoneBlog/posts/create') {
        $("#create_post").addClass("active");
    }
}