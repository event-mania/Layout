const navlink = document.querySelector(".nav-link a");
window.onscroll = () => {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        navlink.style.padding = "16px 24px";
    } else {
        navlink.style.padding = "12px 20px";
    }
}