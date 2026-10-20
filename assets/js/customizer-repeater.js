/**
 * Repeater generik (Hamago) di Customizer — layanan & testimoni tak terbatas.
 * Konfigurasi field dibaca dari atribut data-fields / data-keys.
 * Tipe field: text, textarea, url, select, image.
 */
/* global jQuery, wp */
(function ($) {
	'use strict';

	function esc(v) {
		return String(v == null ? '' : v)
			.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;');
	}

	function fieldHtml(key, cfg, val) {
		val = val == null ? '' : val;
		var html = '<div class="hmg-rp-field hmg-rp-field--' + cfg.type + '">';
		if (cfg.label) {
			html += '<label class="hmg-rp-label">' + esc(cfg.label) + '</label>';
		}
		if (cfg.type === 'textarea') {
			html += '<textarea class="hmg-rp-input" data-key="' + key + '" rows="3" placeholder="' + esc(cfg.placeholder || '') + '">' + esc(val) + '</textarea>';
		} else if (cfg.type === 'select') {
			html += '<select class="hmg-rp-input" data-key="' + key + '">';
			var opts = cfg.options || {};
			Object.keys(opts).forEach(function (k) {
				html += '<option value="' + esc(k) + '"' + (String(val) === String(k) ? ' selected' : '') + '>' + esc(opts[k]) + '</option>';
			});
			html += '</select>';
		} else if (cfg.type === 'image') {
			html += '<div class="hmg-rp-media" data-media="' + key + '">' +
				(val ? '<img src="' + esc(val) + '" alt=""/>' : '<span class="hmg-rp-empty">—</span>') +
				'</div>' +
				'<div class="hmg-rp-line">' +
				'<button type="button" class="button hmg-rp-pick">' + (val ? 'Ganti Gambar' : 'Pilih Gambar') + '</button> ' +
				'<button type="button" class="button-link hmg-rp-unpick" style="' + (val ? '' : 'display:none;') + '">hapus gambar</button>' +
				'</div>';
		} else { /* text & url */
			var type = cfg.type === 'url' ? 'url' : 'text';
			html += '<input type="' + type + '" class="hmg-rp-input" data-key="' + key + '" placeholder="' + esc(cfg.placeholder || '') + '" value="' + esc(val) + '" />';
		}
		html += '</div>';
		return html;
	}

	function rowHtml(keys, fields, data, idx) {
		data = data || {};
		var title = data[keys[2]] || data[keys[0]] || ''; /* kolom judul/utama */
		var html = '<div class="hmg-rp-row">' +
			'<div class="hmg-rp-row-head">' +
			'<span class="hmg-rp-idx">' + (idx + 1) + '.</span> <span class="hmg-rp-row-title">' + esc(title) + '</span>' +
			'<button type="button" class="button-link hmg-rp-toggle" title="Buka/tutup">▾</button>' +
			'</div>' +
			'<div class="hmg-rp-row-body">';
		keys.forEach(function (key, i) {
			html += fieldHtml(key, fields[i], data[key]);
		});
		html += '</div>' +
			'<button type="button" class="button-link hmg-rp-remove" title="Hapus item">✕ Hapus</button>' +
			'</div>';
		return html;
	}

	function init($box) {
		var keys = [];
		var fields = [];
		try {
			keys = JSON.parse($box.attr('data-keys') || '[]');
			fields = JSON.parse($box.attr('data-fields') || '[]');
		} catch (e) { return; }

		var $rows = $box.find('.hmg-rp-rows');
		var $val = $box.find('.hmg-rp-value');
		var addLabel = $box.attr('data-add-label') || '+ Tambah Item';

		function sync() {
			var items = [];
			$rows.find('.hmg-rp-row').each(function () {
				var $r = $(this);
				var item = {};
				keys.forEach(function (key) {
					var $f = $r.find('[data-key="' + key + '"]');
					if ($f.is('select')) {
						item[key] = $f.val();
					} else if ($f.length) {
						item[key] = $f.val() || '';
					}
				});
				/* image via data-media */
				$r.find('[data-media]').each(function () {
					item[$(this).attr('data-media')] = $(this).find('img').attr('src') || '';
				});
				items.push(item);
			});
			$val.val(JSON.stringify(items)).trigger('change');
		}

		function renumber() {
			$rows.find('.hmg-rp-row').each(function (i) {
				$(this).find('.hmg-rp-idx').text((i + 1) + '.');
			});
		}

		function render(data) {
			$rows.empty();
			(data || []).forEach(function (d, i) {
				$rows.append(rowHtml(keys, fields, d, i));
			});
			if (!(data || []).length) {
				$rows.append(rowHtml(keys, fields, {}, 0));
			}
			sync();
		}

		var parsed = [];
		try {
			parsed = JSON.parse($val.val() || '[]');
		} catch (e) {
			parsed = [];
		}
		render(parsed);

		/* Tambah baris. */
		$box.on('click', '.hmg-rp-add', function () {
			var $row = $(rowHtml(keys, fields, {}, $rows.children().length));
			$rows.append($row);
			$row.addClass('is-open');
			$row.find('.hmg-rp-input').first().trigger('focus');
			renumber();
			sync();
		});

		/* Hapus baris. */
		$box.on('click', '.hmg-rp-remove', function () {
			$(this).closest('.hmg-rp-row').remove();
			renumber();
			sync();
		});

		/* Buka/tutup baris. */
		$box.on('click', '.hmg-rp-toggle', function () {
			$(this).closest('.hmg-rp-row').toggleClass('is-open');
		});

		/* Sinkron saat ketik / pilih. */
		$box.on('change input', '.hmg-rp-input', function () {
			var $row = $(this).closest('.hmg-rp-row');
			/* Perbarui judul ringkas baris dari field judul (kolom ke-3 umumnya judul). */
			var titleKey = keys[2] || keys[0];
			$row.find('.hmg-rp-row-title').text($row.find('[data-key="' + titleKey + '"]').val() || '');
			sync();
		});

		/* Media picker. */
		$box.on('click', '.hmg-rp-pick', function (e) {
			e.preventDefault();
			var $btn = $(this);
			var $media = $btn.closest('.hmg-rp-row').find('[data-media]').first();
			var frame = wp.media({
				title: 'Pilih Gambar',
				multiple: false,
				library: { type: 'image' }
			});
			frame.on('select', function () {
				var att = frame.state().get('selection').first().toJSON();
				var url = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
				$media.html('<img src="' + url + '" alt=""/>');
				$btn.text('Ganti Gambar');
				$btn.siblings('.hmg-rp-unpick').show();
				sync();
			});
			frame.open();
		});

		$box.on('click', '.hmg-rp-unpick', function (e) {
			e.preventDefault();
			var $btn = $(this);
			var $media = $btn.closest('.hmg-rp-row').find('[data-media]').first();
			$media.html('<span class="hmg-rp-empty">—</span>');
			$btn.siblings('.hmg-rp-pick').text('Pilih Gambar');
			$btn.hide();
			sync();
		});
	}

	$(function () {
		$('.hmg-rp').each(function () {
			init($(this));
		});
	});

	/* Re-init saat panel Customizer dirender ulang (section pindah dsb). */
	$(document).on('expanded', '.accordion-section', function () {
		var $box = $(this).find('.hmg-rp');
		if ($box.length && !$box.find('.hmg-rp-rows').children().length) {
			init($box);
		}
	});
})(jQuery);
