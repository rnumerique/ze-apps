$(document).ready(function () {
    $("#menu-hover").hide();
    $("#menu-hover-shadow").hide();

    $("#ze-header .menu").click(function () {
        $("#menu-hover").toggle('slow');
        $("#menu-hover-shadow").toggle();
    });

    $("#menu-hover-shadow").click(function () {
        $("#menu-hover").hide('slow');
        $("#menu-hover-shadow").hide();
    });


    $("#menu-hover a").click(function () {
        $("#menu-hover").hide('slow');
        $("#menu-hover-shadow").hide();
    });
});