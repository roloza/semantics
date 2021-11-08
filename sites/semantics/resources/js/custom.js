const sideMenuToggle = document.querySelector('.side-menu-parent');

if (sideMenuToggle != null) {
    sideMenuToggle.addEventListener('click', function(e) {
        sideMenuToggle.classList.toggle('side-menu--open')

        var list = this.parentNode.querySelectorAll('ul')
        for (var i = 0; i < list.length; ++i) {
            if (list[i].classList.contains('show')) {
                list[i].classList.add('hide')
                list[i].classList.remove('show')
            } else {
                list[i].classList.add('show')
                list[i].classList.remove('hide')
            }
         }

    });
}
