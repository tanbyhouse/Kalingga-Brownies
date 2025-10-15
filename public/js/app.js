document.addEventListener('DOMContentLoaded', function () {
	var cards = document.querySelectorAll('.product-card');
	if ('IntersectionObserver' in window && cards.length) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) {
					e.target.classList.remove('opacity-0', 'translate-y-4');
					e.target.classList.add('opacity-100', 'translate-y-0');
					io.unobserve(e.target);
				}
			});
		}, { threshold: 0.15 });
		cards.forEach(function (c) { io.observe(c); });
	} else {
		cards.forEach(function (c) { c.classList.remove('opacity-0', 'translate-y-4'); c.classList.add('opacity-100'); });
	}
});