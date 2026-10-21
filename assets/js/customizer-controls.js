/**
 * Customizer controls interactions (e.g. Reset Defaults button).
 */
(function($) {
    $(document).ready(function() {
        // Handle Factory Reset button click
        $(document).on('click', '#iran-reset-colors-btn', function(e) {
            e.preventDefault();
            if (!confirm('آیا مطمئن هستید که می‌خواهید تمام رنگ‌ها را به تنظیمات اولیه بازنشانی کنید؟')) {
                return;
            }

            var defaults = {
                'iran_color_brand': '#cc4345',
                'iran_color_secondary': '#94a3b8',
                'iran_color_bg': '#ffffff',
                'iran_color_text': '#111827',
                'iran_color_header_bg': '#ffffff',
                'iran_color_footer_bg': '#1a1a1a',
                'iran_color_footer_text': '#9ca3af'
            };

            // Set each setting to its default and trigger change
            $.each(defaults, function(settingId, defaultVal) {
                var apiSetting = wp.customize(settingId);
                if (apiSetting) {
                    apiSetting.set(defaultVal);
                    // Update input value in the control UI
                    var control = wp.customize.control(settingId);
                    if (control) {
                        control.container.find('.color-picker-hex').wpColorPicker('color', defaultVal);
                    }
                }
            });
        });
    });
})(jQuery);
