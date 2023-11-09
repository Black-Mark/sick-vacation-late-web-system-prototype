var isMenuVisible = false;
var sidebar = document.getElementById('sidebar');

function toggleMenu() {
    isMenuVisible = !isMenuVisible;
    if (isMenuVisible) {
        sidebar.classList.add('active');
    } else {
        sidebar.classList.remove('active');
    }
}

document.body.addEventListener("click", (event) => {
    const clickedElement = event.target;
    if (!clickedElement.closest("#top-nav")) {
        if (isMenuVisible) {
            if (!clickedElement.closest("#sidebar")) {
                sidebar.classList.remove('active');
                isMenuVisible = false;
            }
        }
    }
});

function onScroll() {
    var topNav = document.getElementById('top-nav');
    var scrollY = window.scrollY || window.pageYOffset;
    if (scrollY > 0) {
        topNav.classList.add('fixed');
    } else {
        topNav.classList.remove('fixed');
    }
}

// Attach the scroll event listener
window.addEventListener('scroll', onScroll);