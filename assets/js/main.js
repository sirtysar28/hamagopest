/**
 * Hamago Pest Solutions — Main JS
 * - Mobile drawer
 * - Sticky header shadow
 * - Scroll reveal (IntersectionObserver) — animasi smooth
 * - Parallax on scroll (data-hmg-parallax) dengan rAF lerp
 * - Back to top
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		/* =====================================================
		 * Mobile drawer
		 * =================================================== */
		var burger = document.getElementById('hmgBurger');
		var drawer = document.getElementById('hmgMobileNav');
		var overlay = document.getElementById('hmgOverlay');
		var closeBtn = document.getElementById('hmgCloseNav');

		function openDrawer() {
			if (!drawer || !overlay) return;
			drawer.classList.add('open');
			overlay.classList.add('show');
			overlay.hidden = false;
			if (burger) {
				burger.classList.add('open');
				burger.setAttribute('aria-expanded', 'true');
			}
			document.body.style.overflow = 'hidden';
		}

		function closeDrawer() {
			if (!drawer || !overlay) return;
			drawer.classList.remove('open');
			overlay.classList.remove('show');
			if (burger) {
				burger.classList.remove('open');
				burger.setAttribute('aria-expanded', 'false');
			}
			document.body.style.overflow = '';
			window.setTimeout(function () {
				if (!overlay.classList.contains('show')) overlay.hidden = true;
			}, 350);
		}

		if (burger) burger.addEventListener('click', function () {
			drawer.classList.contains('open') ? closeDrawer() : openDrawer();
		});
		if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
		if (overlay) overlay.addEventListener('click', closeDrawer);
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') closeDrawer();
		});
		if (drawer) {
			drawer.querySelectorAll('a').forEach(function (a) {
				a.addEventListener('click', closeDrawer);
			});
		}

		/* =====================================================
		 * Sticky header shadow
		 * =================================================== */
		var header = document.getElementById('site-header');
		function onScrollHeader() {
			if (!header) return;
			if (window.scrollY > 10) header.classList.add('scrolled');
			else header.classList.remove('scrolled');
		}
		window.addEventListener('scroll', onScrollHeader, { passive: true });
		onScrollHeader();

		/* =====================================================
		 * Scroll reveal — smooth fade/slide saat elemen masuk viewport
		 * =================================================== */
		var revealEls = document.querySelectorAll('[data-reveal]');
		if (revealEls.length) {
			if (reduceMotion || !('IntersectionObserver' in window)) {
				revealEls.forEach(function (el) { el.classList.add('is-visible'); });
			} else {
				var io = new IntersectionObserver(function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							var el = entry.target;
							var delay = parseFloat(el.getAttribute('data-delay')) || 0;
							el.style.setProperty('--rd', delay + 'ms');
							el.classList.add('is-visible');
							io.unobserve(el);
						}
					});
				}, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
				revealEls.forEach(function (el) { io.observe(el); });
			}
		}

		/* =====================================================
		 * Parallax on scroll — smooth via rAF lerp
		 * data-hmg-parallax="0.15" (positif = lebih lambat/depth)
		 * =================================================== */
		var parallaxEls = [];
		document.querySelectorAll('[data-hmg-parallax]').forEach(function (el) {
			parallaxEls.push({ el: el, speed: parseFloat(el.getAttribute('data-hmg-parallax')) || 0.1, cur: 0, target: 0 });
		});

		function updateTargets() {
			var vh = window.innerHeight;
			parallaxEls.forEach(function (item) {
				var rect = item.el.getBoundingClientRect();
				var center = rect.top + rect.height / 2 - vh / 2;
				item.target = center * item.speed * -1;
			});
		}

		function loop() {
			var active = false;
			parallaxEls.forEach(function (item) {
				item.cur += (item.target - item.cur) * 0.08; // lerp smooth
				if (Math.abs(item.target - item.cur) > 0.1) active = true;
				item.el.style.transform = 'translate3d(0,' + item.cur.toFixed(2) + 'px,0)';
			});
			window.requestAnimationFrame(loop);
			void active;
		}

		if (parallaxEls.length && !reduceMotion) {
			window.addEventListener('scroll', function () {
				window.requestAnimationFrame(updateTargets);
			}, { passive: true });
			window.addEventListener('resize', updateTargets);
			updateTargets();
			loop();
		}

		/* =====================================================
		 * Slider generik (.hmg-slider) — dipakai hero image slider.
		 * • 1 slide  = background statis (tidak ada kontrol)
		 * • 2+ slide = autoplay + panah + dots + swipe + pause hover
		 * Dipasang ulang otomatis saat widget dirender ulang Elementor.
		 * =================================================== */
		function initHmgSliders(root) {
			var scope = (root && root.querySelectorAll) ? root : document;
			var list = scope.classList && scope.classList.contains('hmg-slider')
				? [scope]
				: Array.prototype.slice.call(scope.querySelectorAll('.hmg-slider'));

			list.forEach(function (slider) {
				if (slider.getAttribute('data-hmg-slider-ready')) return;
				slider.setAttribute('data-hmg-slider-ready', '1');

				var slides = slider.querySelectorAll('.hero-slide, .hmg-slide'); /* hero background pakai .hero-slide */
				if (slides.length < 2) return; /* 1 gambar = statis */

				var host = slider.closest('.hero') || slider.parentElement;
				var prevBtn = host.querySelector('.hmg-slider-nav--prev');
				var nextBtn = host.querySelector('.hmg-slider-nav--next');
				var dots = Array.prototype.slice.call(host.querySelectorAll('.hmg-slider-dot'));

				var idx = 0;
				var timer = null;

				function go(n) {
					idx = (n + slides.length) % slides.length;
					slides.forEach(function (sl, i) {
						sl.classList.toggle('is-active', i === idx);
						sl.setAttribute('aria-hidden', i === idx ? 'false' : 'true');
					});
					dots.forEach(function (d, i) {
						d.classList.toggle('is-active', i === idx);
					});
				}
				function next() { go(idx + 1); }
				function prev() { go(idx - 1); }

				if (prevBtn) prevBtn.addEventListener('click', function () { stopAuto(); prev(); startAuto(); });
				if (nextBtn) nextBtn.addEventListener('click', function () { stopAuto(); next(); startAuto(); });
				dots.forEach(function (d, i) {
					d.addEventListener('click', function () { stopAuto(); go(i); startAuto(); });
				});

				/* Keyboard: panah kiri/kanan saat fokus di dalam slider */
				host.addEventListener('keydown', function (e) {
					if (e.key === 'ArrowRight') { stopAuto(); next(); startAuto(); }
					else if (e.key === 'ArrowLeft') { stopAuto(); prev(); startAuto(); }
				});

				/* Autoplay — data-autoplay (ms) di-render dari kontrol Elementor */
				var speed = parseInt(slider.getAttribute('data-autoplay'), 10) || 0;
				var autoplay = speed > 0 && !reduceMotion;

				function startAuto() {
					if (!autoplay || timer) return;
					timer = window.setInterval(next, speed);
				}
				function stopAuto() {
					if (timer) { window.clearInterval(timer); timer = null; }
				}

				if (autoplay) {
					host.addEventListener('mouseenter', stopAuto);
					host.addEventListener('mouseleave', startAuto);
					document.addEventListener('visibilitychange', function () {
						document.hidden ? stopAuto() : startAuto();
					});
					startAuto();
				}

				/* Swipe di layar sentuh */
				var sx = 0, sy = 0;
				slider.addEventListener('touchstart', function (e) {
					sx = e.touches[0].clientX; sy = e.touches[0].clientY;
				}, { passive: true });
				slider.addEventListener('touchend', function (e) {
					var dx = e.changedTouches[0].clientX - sx;
					var dy = e.changedTouches[0].clientY - sy;
					if (Math.abs(dx) > 48 && Math.abs(dx) > Math.abs(dy)) {
						stopAuto(); dx < 0 ? next() : prev(); startAuto();
					}
				}, { passive: true });

				go(0);
			});
		}

		initHmgSliders(document);

		/* Re-init saat widget hero dirender ulang di editor Elementor */
		window.hmgInitSliders = initHmgSliders;
		try {
			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/hamago_hero.default', function ($scope) {
					initHmgSliders($scope && $scope[0] ? $scope[0] : document);
				});
			} else if (window.jQuery) {
				window.jQuery(window).on('elementor/frontend/init', function () {
					if (window.elementorFrontend && window.elementorFrontend.hooks) {
						window.elementorFrontend.hooks.addAction('frontend/element_ready/hamago_hero.default', function ($scope) {
							initHmgSliders($scope && $scope[0] ? $scope[0] : document);
						});
					}
				});
			}
		} catch (err) { /* noop */ }

		/* =====================================================
		 * Slider testimoni (.testi-grid.is-slider) — aktif otomatis
		 * saat item lebih dari 3. Scroll-snap + tombol navigasi.
		 * =================================================== */
		function initHmgTestiSliders(root) {
			var scope = (root && root.querySelectorAll) ? root : document;
			var list = (scope.classList && scope.hasAttribute && scope.hasAttribute('data-testi-slider'))
				? [scope]
				: Array.prototype.slice.call(scope.querySelectorAll('[data-testi-slider]'));

			list.forEach(function (track) {
				if (track.getAttribute('data-testi-ready')) return;
				track.setAttribute('data-testi-ready', '1');

				var host = track.closest('.testimonials') || track.parentElement;
				var prevBtn = host.querySelector('[data-testi-nav] .testi-nav-btn--prev');
				var nextBtn = host.querySelector('[data-testi-nav] .testi-nav-btn--next');

				function step() {
					var card = track.querySelector('.testi-card');
					return card ? card.getBoundingClientRect().width + 24 : 320;
				}
				function update() {
					if (prevBtn) prevBtn.disabled = track.scrollLeft <= 4;
					if (nextBtn) nextBtn.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
				}

				if (prevBtn) prevBtn.addEventListener('click', function () { track.scrollBy({ left: -step(), behavior: reduceMotion ? 'auto' : 'smooth' }); });
				if (nextBtn) nextBtn.addEventListener('click', function () { track.scrollBy({ left: step(), behavior: reduceMotion ? 'auto' : 'smooth' }); });
				track.addEventListener('scroll', function () { window.requestAnimationFrame(update); }, { passive: true });
				window.addEventListener('resize', update);
				update();
			});
		}

		initHmgTestiSliders(document);
		window.hmgInitTestiSliders = initHmgTestiSliders;
		try {
			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/hamago_testimonials.default', function ($scope) {
					initHmgTestiSliders($scope && $scope[0] ? $scope[0] : document);
				});
			}
		} catch (err) { /* noop */ }

		/* =====================================================
		 * Back to top
		 * =================================================== */
		var backTop = document.getElementById('hmgBackTop');
		if (backTop) {
			window.addEventListener('scroll', function () {
				if (window.scrollY > 600) backTop.classList.add('show');
				else backTop.classList.remove('show');
			}, { passive: true });
			backTop.addEventListener('click', function () {
				window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
			});
		}

		/* =====================================================
		 * Statistik count-up — elemen [data-count] beranimasi naik
		 * saat masuk viewport. Format: "1.200+", "98%", "4.9", dst.
		 * =================================================== */
		function hmgAnimateCount(el) {
			var raw = el.getAttribute('data-count') || el.textContent || '';
			var m = raw.match(/^([^\d]*)([\d.,]+)(.*)$/);
			if (!m) { el.textContent = raw; return; }
			var prefix = m[1], numStr = m[2], suffix = m[3];
			/* "1.200" / "1,200" = pemisah ribuan; "4.9" = desimal. */
			var thousands = /^\d{1,3}([.,]\d{3})+$/.test(numStr);
			var target = parseFloat(thousands ? numStr.replace(/[.,]/g, '') : numStr.replace(',', '.'));
			if (isNaN(target)) { el.textContent = raw; return; }
			var decimals = (!thousands && /[.,]\d/.test(numStr)) ? (numStr.split(/[.,]/)[1] || '').length : 0;

			function fmt(v) {
				var s = decimals ? v.toFixed(decimals) : String(Math.round(v));
				if (thousands || s.length > 3) {
					var parts = decimals ? s.split('.') : [s];
					parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
					return parts.join(decimals ? ',' : '');
				}
				return s;
			}

			if (reduceMotion) { el.textContent = prefix + fmt(target) + suffix; return; }

			var dur = 1400, t0 = null;
			function step(ts) {
				if (!t0) t0 = ts;
				var p = Math.min((ts - t0) / dur, 1);
				var e = 1 - Math.pow(1 - p, 3); /* ease-out cubic */
				el.textContent = prefix + fmt(target * e) + suffix;
				if (p < 1) window.requestAnimationFrame(step);
			}
			window.requestAnimationFrame(step);
		}

		var countEls = document.querySelectorAll('[data-count]');
		if (countEls.length) {
			if (!('IntersectionObserver' in window)) {
				countEls.forEach(function (el) { el.textContent = el.getAttribute('data-count') || el.textContent; });
			} else {
				var countIo = new IntersectionObserver(function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							hmgAnimateCount(entry.target);
							countIo.unobserve(entry.target);
						}
					});
				}, { threshold: 0.4 });
				countEls.forEach(function (el) { countIo.observe(el); });
			}
		}

		/* =====================================================
		 * Anchor smooth scroll (dengan offset header sticky).
		 * Dinonaktifkan saat Elementor editor aktif agar klik/edit
		 * elemen di preview tidak terhalang.
		 * =================================================== */
		var isElementorEditor = document.body.classList.contains('elementor-editor-active') || document.body.classList.contains('elementor-editor-preview');
		if (!isElementorEditor) {
			document.querySelectorAll('a[href*="#"]:not([href="#"])').forEach(function (link) {
				link.addEventListener('click', function (e) {
					try {
						var url = new URL(link.href, window.location.href);
						if (url.origin !== window.location.origin || !url.hash) return;
						var target = document.querySelector(url.hash);
						if (!target) return;
						e.preventDefault();
						var h = document.getElementById('site-header');
						var offset = h ? h.offsetHeight + 14 : 20;
						var top = target.getBoundingClientRect().top + window.scrollY - offset;
						window.scrollTo({ top: top, behavior: reduceMotion ? 'auto' : 'smooth' });
						history.replaceState(null, '', url.hash);
					} catch (err) { /* biarkan default */ }
				});
			});
		}
	});
})();

		/* =====================================================
		 * Popup video (lightbox) — tombol [data-hmg-video]
		 * =================================================== */
		(function () {
			var modal = document.getElementById('hmgVideoModal');
			if (!modal) return;
			var frame = modal.querySelector('[data-hmg-video-frame]');

			function open(url) {
				if (!url) return;
				frame.innerHTML = '';
				var ifr = document.createElement('iframe');
				ifr.src = url;
				ifr.title = 'Video';
				ifr.allow = 'autoplay; fullscreen; picture-in-picture; encrypted-media';
				ifr.setAttribute('allowfullscreen', '');
				ifr.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
				frame.appendChild(ifr);
				modal.classList.add('is-open');
				modal.setAttribute('aria-hidden', 'false');
				document.documentElement.classList.add('hmg-no-scroll');
				var cb = modal.querySelector('.hmg-video-close');
				if (cb) cb.focus();
			}

			function close() {
				modal.classList.remove('is-open');
				modal.setAttribute('aria-hidden', 'true');
				frame.innerHTML = ''; /* hapus iframe = video berhenti */
				document.documentElement.classList.remove('hmg-no-scroll');
			}

			document.addEventListener('click', function (e) {
				var btn = e.target && e.target.closest ? e.target.closest('[data-hmg-video]') : null;
				if (btn) {
					e.preventDefault();
					open(btn.getAttribute('data-hmg-video'));
					return;
				}
				if (modal.classList.contains('is-open')) {
					var closer = e.target && e.target.closest ? e.target.closest('[data-hmg-video-close]') : null;
					if (closer || e.target === modal) close();
				}
			});

			document.addEventListener('keydown', function (e) {
				if (e.key === 'Escape' && modal.classList.contains('is-open')) close();
			});
		})();
