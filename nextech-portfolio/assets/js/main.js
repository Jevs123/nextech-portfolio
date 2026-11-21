/**
 * NexTech Portfolio – core behaviour.
 * Mobile menu, header shadow and contact form validation.
 * (Animations live in animations.js.)
 */
(function () {
	'use strict';

	var header = document.getElementById('site-header');
	var toggle = document.getElementById('nav-toggle');
	var nav = document.getElementById('primary-nav');

	/* Mobile navigation */
	function setMenu(open) {
		if (!toggle || !nav) { return; }
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		nav.classList.toggle('is-open', open);
		document.body.classList.toggle('menu-open', open);
	}

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			setMenu(toggle.getAttribute('aria-expanded') !== 'true');
		});
		nav.addEventListener('click', function (e) {
			if (e.target.closest('a')) { setMenu(false); }
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') { setMenu(false); toggle.focus(); }
		});
	}

	/* Header shadow on scroll */
	function onScroll() {
		if (header) { header.classList.toggle('is-scrolled', window.scrollY > 8); }
	}
	onScroll();
	window.addEventListener('scroll', onScroll, { passive: true });

	/* ---------- Active navigation ----------
	 * Other pages get their active link from PHP (nextech_active_nav).
	 * On the homepage, an IntersectionObserver keeps it in sync with the section on screen.
	 */
	var navLinks = Array.prototype.slice.call(document.querySelectorAll('.nav-link[data-nav]'));
	var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function setActive(key) {
		navLinks.forEach(function (link) {
			var on = link.getAttribute('data-nav') === key;
			link.classList.toggle('is-active', on);
			if (on) { link.setAttribute('aria-current', 'page'); } else { link.removeAttribute('aria-current'); }
		});
	}

	var sections = Array.prototype.slice.call(document.querySelectorAll('[data-nav-section]'));
	var locked = false, lockTimer;

	function lockSpy() {
		locked = true;
		clearTimeout(lockTimer);
		// Released when smooth scrolling ends (or after a safety timeout).
		lockTimer = setTimeout(function () { locked = false; }, 1100);
	}
	if ('onscrollend' in window) {
		window.addEventListener('scrollend', function () { clearTimeout(lockTimer); locked = false; });
	}

	if (sections.length && 'IntersectionObserver' in window) {
		var spy = new IntersectionObserver(function (entries) {
			if (locked) { return; }
			entries.forEach(function (entry) {
				if (entry.isIntersecting) { setActive(entry.target.getAttribute('data-nav-section')); }
			});
		}, { rootMargin: '-35% 0px -60% 0px', threshold: 0 });
		sections.forEach(function (sec) { spy.observe(sec); });

		// Reaching the footer means the last section (Contact) is the one in view.
		var footer = document.querySelector('.site-footer');
		if (footer) {
			new IntersectionObserver(function (entries) {
				if (!locked && entries[0].isIntersecting) { setActive('contact'); }
			}, { threshold: 0.6 }).observe(footer);
		}
	}

	/* In-page links on the homepage scroll smoothly instead of reloading the page. */
	var onFront = !!document.getElementById('home');
	if (onFront) {
		document.addEventListener('click', function (e) {
			var a = e.target.closest && e.target.closest('a[href]');
			if (!a || e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey || e.button) { return; }

			var url;
			try { url = new URL(a.href, window.location.href); } catch (err) { return; }
			if (url.origin !== window.location.origin || url.pathname !== window.location.pathname) { return; }

			var target = null;
			if (url.hash && url.hash.length > 1) {
				target = document.getElementById(decodeURIComponent(url.hash.slice(1)));
			} else if (!url.search || url.search === window.location.search) {
				target = document.getElementById('home'); // the Home link
			}
			if (!target) { return; }

			e.preventDefault();
			lockSpy();
			var navKey = a.getAttribute('data-nav') || target.getAttribute('data-nav-section');
			if (navKey) { setActive(navKey); }
			target.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
			if (window.history && history.pushState) {
				history.pushState(null, '', url.hash && target.id !== 'home' ? url.hash : window.location.pathname + window.location.search);
			}
		});
	}

	/* Contact form validation (the server validates again) */
	var form = document.getElementById('contact-form');
	if (form) {
		var rules = [
			{ id: 'contact_name', err: 'err-name', check: function (v) { return v.trim().length > 0; }, msg: 'Please enter your name.' },
			{ id: 'contact_email', err: 'err-email', check: function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()); }, msg: 'Please enter a valid email address.' },
			{ id: 'contact_message', err: 'err-message', check: function (v) { return v.trim().length >= 10; }, msg: 'Please write at least 10 characters.' }
		];

		var validate = function (rule) {
			var field = document.getElementById(rule.id);
			var out = document.getElementById(rule.err);
			var ok = rule.check(field.value);
			field.setAttribute('aria-invalid', ok ? 'false' : 'true');
			out.textContent = ok ? '' : rule.msg;
			return ok;
		};

		rules.forEach(function (rule) {
			var field = document.getElementById(rule.id);
			field.addEventListener('blur', function () { validate(rule); });
			field.addEventListener('input', function () {
				if (field.getAttribute('aria-invalid') === 'true') { validate(rule); }
			});
		});

		form.addEventListener('submit', function (e) {
			var firstBad = null;
			rules.forEach(function (rule) {
				if (!validate(rule) && !firstBad) { firstBad = document.getElementById(rule.id); }
			});
			if (firstBad) {
				e.preventDefault();
				firstBad.focus();
			}
		});
	}
})();
