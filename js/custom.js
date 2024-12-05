jQuery(document).ready(function($) {
    // Toggle dropdown on click for mobile screens
    $('.nav-menu li').click(function(e) {
        // Prevent the dropdown from closing immediately on mobile
        e.stopPropagation();
        // Close other dropdowns
        $('.nav-menu li').not(this).removeClass('active');
        // Toggle active class on clicked item
        $(this).toggleClass('active');
    });

    // Close dropdowns if clicked outside
    $(document).click(function() {
        $('.nav-menu li').removeClass('active');
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.hamburger-menu');
    const menu = document.querySelector('.main-menu');

    hamburger.addEventListener('click', function () {
        menu.classList.toggle('open');
    });
});
