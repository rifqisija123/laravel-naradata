$(document).ready(function () {
    const sidebar = $("#sidebar");
    const overlay = $("#overlay");
    const hamburger = $("#toggleSidebar i");

    $("#toggleSidebar").on("click", function () {
        sidebar.toggleClass("active");

        if (sidebar.hasClass("active")) {
            overlay.fadeIn();
            hamburger.removeClass("fa-bars").addClass("fa-times");
        } else {
            overlay.fadeOut();
            hamburger.removeClass("fa-times").addClass("fa-bars");
        }
    });

    $("#overlay").on("click", function () {
        sidebar.removeClass("active");
        overlay.fadeOut();
        hamburger.removeClass("fa-times").addClass("fa-bars");
    });
});
