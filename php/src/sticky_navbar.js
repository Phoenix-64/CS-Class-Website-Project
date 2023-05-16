window.onscroll = function () {
    myFunction();

};

var navbar;
var sticky;

setTimeout(
    function () {
        navbar = document.getElementById("navbar");
        sticky = navbar.offsetTop + 1;
    },
    100
);

function myFunction()
{
    if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky");
    } else {
        navbar.classList.remove("sticky");
    }
}