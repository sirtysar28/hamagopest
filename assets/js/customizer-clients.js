/**
 * Repeater klien (Hamago) di Customizer.
 * Baris: Nama | Logo (upload) | Link URL | hapus. Tak terbatas.
 */
/* global jQuery, wp */
(function ($) {
	'use strict';

	function rowHtml(d) {
		d = d || {};
		return (
			'<div class="hmg-cr-row">' +
			'<div class="hmg-cr-logo" data-hmg-logo>' + (d.logo ? '<img src="' + d.logo + '" alt=""/>' : '<span class="hmg-cr-empty">—</span>') + '</div>' +
			'<div class="hmg-cr-fields">' +
			'<input type="text" class="hmg-cr-name" placeholder="Nama klien" value="' + (d.name || '') + '" />' +
			'<div class="hmg-cr-line">' +
			'<button type="button" class="button hmg-cr-pick">' + (d.logo ? 'Ganti Logo' : 'Pilih Logo') + '</button> ' +
			'<button type="button" class="button-link hmg-cr-unpick" style="' + (d.logo ? '' : 'display:none;') + '">hapus logo</button>' +
			'</div>' +
			'<input type="url" class="hmg-cr-url" placeholder="https:// (link opsional)" value="' + (d.url || '') + '" />' +
			'</div>' +
			'<button type="button" class="button-link hmg-cr-remove" title="Hapus klien">✕</button>' +
			'</div>'
		);
	}

	function init($box) {
		var $rows = $box.find('.hmg-cr-rows');
		var $val = $box.find('.hmg-cr-value');

		function render(data) {
			$rows.empty();
			(data || []).forEach(function (d) {
				$rows.append(rowHtml(d));
			});
			sync();
		}

		function sync() {
			var items = [];
			$rows.find('.hmg-cr-row').each(function () {
				var $r = $(this);
				items.push({
					name: $r.find('.hmg-cr-name').val(),
					logo: $r.find('[data-hmg-logo] img').attr('src') || '',
					url: $r.find('.hmg-cr-url').val()
				});
			});
			$val.val(JSON.stringify(items)).trigger('change');
		}

		var parsed = [];
		try {
			parsed = JSON.parse($val.val() || '[]');
		} catch (e) {
			parsed = [];
		}
		render(parsed);

		/* Tambah baris. */
		$box.on('click', '.hmg-cr-add', function () {
			$rows.append(rowHtml({}));
			$rows.find('.hmg-cr-row:last .hmg-cr-name').trigger('focus');
			sync();
		});

		/* Hapus baris. */
		$box.on('click', '.hmg-cr-remove', function () {
			$(this).closest('.hmg-cr-row').remove();
			sync();
		});

		/* Sinkron saat ketik. */
		$box.on('change input', '.hmg-cr-name, .hmg-cr-url', sync);

		/* Pilih logo via media library. */
		$box.on('click', '.hmg-cr-pick', function (e) {
			e.preventDefault();
			var $btn = $(this);
			var frame = wp.media({
				title: 'Pilih Logo Klien',
				multiple: false,
				library: { type: 'image' }
			});
			frame.on('select', function () {
				var att = frame.state().get('selection').first().toJSON();
				var url = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
				var $row = $btn.closest('.hmg-cr-row');
				$row.find('[data-hmg-logo]').html('<img src="' + url + '" alt=""/>');
				$btn.text('Ganti Logo');
				$row.find('.hmg-cr-unpick').show();
				sync();
			});
			frame.open();
		});

		/* Hapus logo. */
		$box.on('click', '.hmg-cr-unpick', function () {
			var $row = $(this).closest('.hmg-cr-row');
			$row.find('[data-hmg-logo]').html('<span class="hmg-cr-empty">—</span>');
			$row.find('.hmg-cr-pick').text('Pilih Logo');
			$(this).hide();
			sync();
		});
	}

	$(function () {
		$('.hmg-cr').each(function () {
			init($(this));
		});
		/* Re-init saat section di-expand (Customizer lazy-render control). */
		if (window.wp && wp.customize) {
			wp.customize.bind('ready', function () {
				$('.hmg-cr').each(function () {
					if (!$(this).find('.hmg-cr-row, .hmg-cr-add').data('hmg-init')) {
						$(this).find('.hmg-cr-add').data('hmg-init', 1);
						if (!$(this).find('.hmg-cr-rows').children().length) {
							init($(this));
						}
					}
				});
			});
		}
	});
})(jQuery);
