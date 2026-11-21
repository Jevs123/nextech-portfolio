/**
 * NexTech Portfolio – animations.
 * Scroll reveal with stagger, rotating hero words, count-up numbers, network
 * canvas, card tilt, hero spotlight, scroll progress and animated skill bars.
 * Everything is skipped or simplified when the visitor prefers reduced motion.
 */
(function () {
	'use strict';

	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

	/* ---------- Scroll reveal with stagger ---------- */
	var reveals = $$('.reveal');

	reveals.forEach(function (el) {
		var parent = el.parentElement;
		if (!parent) { return; }
		var siblings = Array.prototype.filter.call(parent.children, function (c) { return c.classList.contains('reveal'); });
		var index = siblings.indexOf(el);
		if (index > 0) { el.style.transitionDelay = Math.min(index, 6) * 90 + 'ms'; }
	});

	function showAll() { reveals.forEach(function (el) { el.classList.add('is-visible'); }); }

	if (!('IntersectionObserver' in window) || reduce) {
		showAll();
	} else {
		var revealObs = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				var el = entry.target;
				el.classList.add('is-visible');
				revealObs.unobserve(el);
				// Remove the stagger delay afterwards so hover effects stay snappy.
				setTimeout(function () { el.style.transitionDelay = ''; }, 1200);
			});
		}, { threshold: 0.12 });
		reveals.forEach(function (el) { revealObs.observe(el); });
	}

	/* ---------- Scroll progress bar ---------- */
	var bar = document.getElementById('scroll-progress');
	if (bar) {
		var ticking = false;
		var update = function () {
			var h = document.documentElement.scrollHeight - window.innerHeight;
			bar.style.transform = 'scaleX(' + (h > 0 ? Math.min(window.scrollY / h, 1) : 0) + ')';
			ticking = false;
		};
		window.addEventListener('scroll', function () {
			if (!ticking) { ticking = true; requestAnimationFrame(update); }
		}, { passive: true });
		update();
	}

	/* ---------- Rotating hero words (typewriter) ---------- */
	var rotator = document.querySelector('.rotator');
	if (rotator && !reduce) {
		var words = [];
		try { words = JSON.parse(rotator.getAttribute('data-words') || '[]'); } catch (e) { words = []; }

		if (words.length > 1) {
			var w = 0, c = words[0].length, deleting = false;
			var tick = function () {
				var word = words[w];
				rotator.textContent = word.slice(0, c);
				var delay = deleting ? 35 : 70;

				if (!deleting && c === word.length) { deleting = true; delay = 1700; }
				else if (deleting && c === 0) { deleting = false; w = (w + 1) % words.length; delay = 350; }
				else { c += deleting ? -1 : 1; }

				setTimeout(tick, delay);
			};
			setTimeout(tick, 1700);
		}
	}

	/* ---------- Count-up numbers + skill bars ---------- */
	var counters = $$('[data-count]');
	function runCount(el) {
		var target = parseInt(el.getAttribute('data-count'), 10) || 0;
		if (reduce || target === 0) { el.textContent = target; return; }
		var start = null, dur = 1200;
		var step = function (ts) {
			if (start === null) { start = ts; }
			var p = Math.min((ts - start) / dur, 1);
			el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
			if (p < 1) { requestAnimationFrame(step); }
		};
		requestAnimationFrame(step);
	}
	if ('IntersectionObserver' in window) {
		var countObs = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) { runCount(entry.target); countObs.unobserve(entry.target); }
			});
		}, { threshold: 0.6 });
		counters.forEach(function (el) { countObs.observe(el); });
	} else {
		counters.forEach(runCount);
	}

	/* ---------- Card tilt (mouse only) ---------- */
	if (!reduce && window.matchMedia && window.matchMedia('(hover: hover)').matches) {
		$$('.tilt').forEach(function (card) {
			card.addEventListener('pointermove', function (e) {
				if (e.pointerType !== 'mouse') { return; }
				var r = card.getBoundingClientRect();
				var x = (e.clientX - r.left) / r.width - 0.5;
				var y = (e.clientY - r.top) / r.height - 0.5;
				card.style.setProperty('--ry', (x * 8).toFixed(2) + 'deg');
				card.style.setProperty('--rx', (-y * 8).toFixed(2) + 'deg');
				card.style.setProperty('--ty', '-6px');
			});
			card.addEventListener('pointerleave', function () {
				card.style.setProperty('--ry', '0deg');
				card.style.setProperty('--rx', '0deg');
				card.style.setProperty('--ty', '0px');
			});
		});
	}

	/* ---------- The single site-wide network background ----------
	 * One fixed canvas behind the whole page. Dots drift on their own, react to the
	 * pointer and move a little as you scroll, so it feels alive from top to bottom.
	 */
	(function () {
		var canvas = document.getElementById('site-bg-canvas');
		var ctx = canvas && canvas.getContext && canvas.getContext('2d');
		if (!ctx) { return; }

		var bg = canvas.parentElement;
		var dpr = Math.min(window.devicePixelRatio || 1, 1.5);
		var w = 0, h = 0, nodes = [], pointer = null;

		function build() {
			var count = Math.max(24, Math.min(70, Math.round((w * h) / 20000)));
			while (nodes.length > count) { nodes.pop(); }
			while (nodes.length < count) {
				nodes.push({
					x: Math.random() * w, y: Math.random() * h,
					vx: (Math.random() - 0.5) * 0.35, vy: (Math.random() - 0.5) * 0.35,
					r: 1.3 + Math.random() * 1.7
				});
			}
		}

		function resize() {
			var nw = window.innerWidth, nh = window.innerHeight;
			if (w && h) { nodes.forEach(function (n) { n.x *= nw / w; n.y *= nh / h; }); }
			w = nw; h = nh;
			canvas.width = Math.round(w * dpr); canvas.height = Math.round(h * dpr);
			ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
			build();
			draw();
		}

		function draw() {
			ctx.clearRect(0, 0, w, h);
			var link = 140, shift = reduce ? 0 : window.scrollY * 0.18, pts = [];

			for (var i = 0; i < nodes.length; i++) {
				var n = nodes[i];
				if (!reduce) {
					n.x += n.vx; n.y += n.vy;
					if (n.x < 0 || n.x > w) { n.vx *= -1; }
					if (n.y < 0 || n.y > h) { n.vy *= -1; }
				}
				// scrolling slides the dots slowly upward (wrapped), giving a gentle parallax
				pts.push({ x: n.x, y: ((n.y - shift) % h + h) % h, r: n.r });
			}

			for (var a = 0; a < pts.length; a++) {
				var p = pts[a];
				for (var b = a + 1; b < pts.length; b++) {
					var q = pts[b], dx = p.x - q.x, dy = p.y - q.y, d = Math.sqrt(dx * dx + dy * dy);
					if (d < link) {
						ctx.strokeStyle = 'rgba(139,188,255,' + (0.30 * (1 - d / link)).toFixed(3) + ')';
						ctx.lineWidth = 1;
						ctx.beginPath(); ctx.moveTo(p.x, p.y); ctx.lineTo(q.x, q.y); ctx.stroke();
					}
				}
				if (pointer) {
					var px = p.x - pointer.x, py = p.y - pointer.y, pd = Math.sqrt(px * px + py * py);
					if (pd < 170) {
						ctx.strokeStyle = 'rgba(77,150,255,' + (0.55 * (1 - pd / 170)).toFixed(3) + ')';
						ctx.beginPath(); ctx.moveTo(p.x, p.y); ctx.lineTo(pointer.x, pointer.y); ctx.stroke();
					}
				}
				ctx.fillStyle = 'rgba(139,188,255,0.85)';
				ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2); ctx.fill();
			}
		}

		function loop() {
			if (!document.hidden) { draw(); }
			requestAnimationFrame(loop);
		}

		resize();
		if (!reduce) { requestAnimationFrame(loop); }

		var timer;
		window.addEventListener('resize', function () { clearTimeout(timer); timer = setTimeout(resize, 150); });

		if (!reduce) {
			window.addEventListener('pointermove', function (e) {
				if (e.pointerType === 'touch') { return; }
				pointer = { x: e.clientX, y: e.clientY };
				bg.style.setProperty('--mx', e.clientX + 'px');
				bg.style.setProperty('--my', e.clientY + 'px');
			}, { passive: true });
			document.addEventListener('pointerleave', function () { pointer = null; });
		}
	})();
})();
