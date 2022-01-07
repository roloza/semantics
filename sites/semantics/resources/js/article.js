const titles = document.querySelectorAll('.article h2');
const summaryContainer = document.querySelector('#summary-container');
const currentScrollTop = document.documentElement.scrollTop;

if (titles.length > 0) {
	if(summaryContainer.children.length > 0) {
		summaryContainer.children[0].style.display = 'block';
	}
	const sommaire = document.querySelector('#jsSommaireContent')
	titles.forEach(function (element) {

		let a = document.createElement("a");
		a.setAttribute('data-position-y', element.getBoundingClientRect().top + currentScrollTop - element.getBoundingClientRect().height - 70)
		a.innerHTML = element.innerHTML
		a.classList.add('summary-link')
		a.addEventListener('click', function (e) {
			window.scroll(0, this.getAttribute('data-position-y'));
		});
		sommaire.append(a);
	})

	
};
const initialSummaryPosition = summaryContainer.getBoundingClientRect().top + currentScrollTop;

let onScroll = function() {
	if (initialSummaryPosition < document.documentElement.scrollTop && !summaryContainer.classList.contains('fixed')) {
		summaryContainer.classList.add('fixed');
		summaryContainer.style.width = summaryContainer.parentElement.getBoundingClientRect().width + "px";
	} else if (initialSummaryPosition >= document.documentElement.scrollTop && summaryContainer.classList.contains('fixed')){
		summaryContainer.classList.remove('fixed');
	}
	
}

if (window.innerWidth >= 1024 ) {
	document.addEventListener('scroll', onScroll);
}






