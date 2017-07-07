//Open right menu
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    }

//Close right menu
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

//Dropdown
$(document).ready(function(){
    $(".dropdown").click(function(){
        $(this).children(".child").toggle(250);
    });
});

//Change class
$(document).ready(function() {
    $(".caret_right").click(function() {
        $(this).toggleClass('caret_down');
    });
});