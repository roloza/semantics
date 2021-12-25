// Menu
const sideMenuToggle = document.querySelectorAll('.side-menu-parent');

if (sideMenuToggle != null) {
	sideMenuToggle.forEach(function (element) {
		element.addEventListener('click', function (e) {
			toggleMenu(this);
		});
	});
}

var toggleMenu = function (element) {
	element.classList.toggle('side-menu--open')
	var list = element.parentNode.querySelectorAll('ul')
	for (var i = 0; i < list.length; ++i) {
		if (list[i].classList.contains('show')) {
			list[i].classList.add('hide')
			list[i].classList.remove('show')
		} else {
			list[i].classList.add('show')
			list[i].classList.remove('hide')
		}
	}
}
// END Menu

