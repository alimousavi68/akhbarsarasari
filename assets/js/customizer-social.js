(function($) {
    wp.customize.controlConstructor['iran-social-repeater'] = wp.customize.Control.extend({
        ready: function() {
            var control = this;
            var list = control.container.find('.iran-social-items-list');

            // Initialize Sortable
            list.sortable({
                handle: '.iran-social-item-header',
                update: function() {
                    control.updateValue();
                }
            });

            // Toggle Item
            control.container.on('click', '.toggle-item', function() {
                $(this).closest('.iran-social-item').toggleClass('expanded');
            });

            // Remove Item
            control.container.on('click', '.remove-item', function() {
                if (confirm('آیا از حذف این شبکه اجتماعی اطمینان دارید؟')) {
                    $(this).closest('.iran-social-item').remove();
                    control.updateValue();
                }
            });

            // Add Item
            control.container.on('click', '.add-social-item-btn', function(e) {
                e.preventDefault();
                var newItem = control.container.find('.iran-social-item-template').clone().removeClass('iran-social-item-template hidden');
                list.append(newItem);
                control.updateValue();
            });

            // Update Value on Change
            control.container.on('input change', '.iran-social-item-content input, .iran-social-item-content select', function() {
                var item = $(this).closest('.iran-social-item');
                
                if ($(this).hasClass('item-label')) {
                    item.find('.item-title').text($(this).val() || 'شبکه جدید');
                }

                if ($(this).hasClass('item-icon-type')) {
                    var type = $(this).val();
                    if (type === 'lucide') {
                        item.find('.icon-lucide-fields').show();
                        item.find('.icon-custom-svg-fields').hide();
                    } else {
                        item.find('.icon-lucide-fields').hide();
                        item.find('.icon-custom-svg-fields').show();
                    }
                }

                control.updateValue();
            });

            // Media Uploader for SVG
            control.container.on('click', '.select-svg-btn', function(e) {
                e.preventDefault();
                var btn = $(this);
                var item = btn.closest('.iran-social-item');
                
                var frame = wp.media({
                    title: 'انتخاب یا آپلود SVG',
                    button: { text: 'استفاده از این فایل' },
                    library: { type: 'image/svg+xml' },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    item.find('.item-custom-svg-id').val(attachment.id);
                    item.find('.item-custom-svg-url').val(attachment.url);
                    item.find('.custom-svg-preview').html('<img src="' + attachment.url + '" style="width:100%; height:auto; background:#eee; padding:5px; border-radius:4px;">');
                    item.find('.remove-svg-btn').removeClass('hidden');
                    control.updateValue();
                });

                frame.open();
            });

            // Remove SVG
            control.container.on('click', '.remove-svg-btn', function(e) {
                e.preventDefault();
                var item = $(this).closest('.iran-social-item');
                item.find('.item-custom-svg-id').val('');
                item.find('.item-custom-svg-url').val('');
                item.find('.custom-svg-preview').empty();
                $(this).addClass('hidden');
                control.updateValue();
            });
        },

        updateValue: function() {
            var control = this;
            var items = [];
            var list = control.container.find('.iran-social-items-list .iran-social-item');

            list.each(function() {
                var item = $(this);
                items.push({
                    id: item.find('.item-id').val() || 'custom-' + Date.now(),
                    label: item.find('.item-label').val(),
                    url: item.find('.item-url').val(),
                    btn_text: item.find('.item-btn_text').val(),
                    new_tab: item.find('.item-new-tab').is(':checked'),
                    icon_type: item.find('.item-icon-type').val(),
                    icon: item.find('.item-icon').val(),
                    custom_svg_id: item.find('.item-custom_svg_id').val() || item.find('.item-custom-svg-id').val(),
                    custom_svg_url: item.find('.item-custom_svg_url').val() || item.find('.item-custom-svg-url').val(),
                    svg_size: item.find('.item-svg-size').val() || 32,
                    svg_color: item.find('.item-svg-color').val() || '#ffffff',
                    bg: item.find('.item-bg').val()
                });
            });

            control.setting.set(JSON.stringify(items));
        }
    });
})(jQuery);
