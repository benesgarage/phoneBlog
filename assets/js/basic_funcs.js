window.onload = function(){
    main();
};

function main() {
    if (location.pathname == '/phoneBlog/posts') {
        $("#home").addClass("active");
    } else if (location.pathname == '/phoneBlog/posts/create') {
        $("#create_post").addClass("active");
    }
}