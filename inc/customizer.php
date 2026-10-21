<?php
/**
 * Iran News Customizer functionality
 *
 * @package Iran_News
 */

function iran_news_customize_register( $wp_customize ) {
    // Add Theme Options Panel
    $wp_customize->add_panel( 'iran_theme_options', array(
        'title'       => __( 'مدیریت قالب', 'iran' ),
        'priority'    => 10,
        'capability'  => 'edit_theme_options',
    ) );

    // Add Hero Section
    $wp_customize->add_section( 'iran_hero_section', array(
        'title'       => __( 'تنظیمات هیروسکشن', 'iran' ),
        'panel'       => 'iran_theme_options',
        'priority'    => 10,
    ) );

    // Setting: Show/Hide Hero
    $wp_customize->add_setting( 'iran_show_hero', array(
        'default'           => true,
        'sanitize_callback' => 'iran_news_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'iran_show_hero', array(
        'label'    => __( 'نمایش هیروسکشن در صفحه اصلی', 'iran' ),
        'section'  => 'iran_hero_section',
        'type'     => 'checkbox',
    ) );

    // Setting: Hero Category
    $wp_customize->add_setting( 'iran_hero_category', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ) );

    $categories = get_categories();
    $cat_options = array( 0 => __( 'همه دسته‌ها', 'iran' ) );
    foreach ( $categories as $cat ) {
        $cat_options[ $cat->term_id ] = $cat->name;
    }

    $wp_customize->add_control( 'iran_hero_category', array(
        'label'    => __( 'انتخاب دسته بندی هیروسکشن', 'iran' ),
        'section'  => 'iran_hero_section',
        'type'     => 'select',
        'choices'  => $cat_options,
    ) );

    // --- Latest News Section ---
    $wp_customize->add_section( 'iran_latest_news_section', array(
        'title'    => __( 'تنظیمات آخرین اخبار', 'iran' ),
        'panel'    => 'iran_theme_options',
        'priority' => 15,
    ) );

    // Setting: Latest News Title
    $wp_customize->add_setting( 'iran_latest_news_title', array(
        'default'           => '<span class="text-brand">آخرین</span><span class="text-secondary"> اخبار</span>',
        'sanitize_callback' => 'wp_kses_post',
    ) );

    $wp_customize->add_control( 'iran_latest_news_title', array(
        'label'    => __( 'عنوان بخش آخرین اخبار', 'iran' ),
        'section'  => 'iran_latest_news_section',
        'type'     => 'text',
    ) );

    // Setting: Latest News Count
    $wp_customize->add_setting( 'iran_latest_news_count', array(
        'default'           => 10,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'iran_latest_news_count', array(
        'label'    => __( 'تعداد اخبار برای نمایش', 'iran' ),
        'section'  => 'iran_latest_news_section',
        'type'     => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 50 ),
    ) );

    // Setting: Latest News Category
    $wp_customize->add_setting( 'iran_latest_news_category', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'iran_latest_news_category', array(
        'label'    => __( 'انتخاب دسته بندی (یا آخرین اخبار)', 'iran' ),
        'section'  => 'iran_latest_news_section',
        'type'     => 'select',
        'choices'  => $cat_options, // Using the same categories list as hero
    ) );

    // Setting: Infinite Scroll Mode
    $wp_customize->add_setting( 'iran_infinite_scroll_mode', array(
        'default'           => 'button_after_n',
        'sanitize_callback' => 'iran_news_sanitize_scroll_mode',
    ) );

    $wp_customize->add_control( 'iran_infinite_scroll_mode', array(
        'label'    => __( 'حالت بارگذاری اخبار بیشتر (Infinite Scroll)', 'iran' ),
        'section'  => 'iran_latest_news_section',
        'type'     => 'select',
        'choices'  => array(
            'infinite'       => __( 'اسکرول بی‌نهایت خودکار (پیوسته)', 'iran' ),
            'button_after_n' => __( 'اسکرول تا تعداد مشخصی صفحه و سپس دکمه', 'iran' ),
        ),
    ) );

    // Setting: Auto Scroll Pages Count
    $wp_customize->add_setting( 'iran_infinite_scroll_auto_pages', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'iran_infinite_scroll_auto_pages', array(
        'label'       => __( 'تعداد صفحات اسکرول خودکار قبل از دکمه', 'iran' ),
        'description' => __( 'در صورت انتخاب حالت دوم، پس از لود این تعداد صفحه، دکمه «مشاهده اخبار بیشتر» نمایش داده می‌شود.', 'iran' ),
        'section'     => 'iran_latest_news_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 20, 'step' => 1 ),
    ) );

    // --- Social Networks Section ---
    $wp_customize->add_section( 'iran_social_section', array(
        'title'    => __( 'مدیریت شبکه‌های اجتماعی', 'iran' ),
        'panel'    => 'iran_theme_options',
        'priority' => 20,
    ) );

    // Visibility: Home
    $wp_customize->add_setting( 'iran_social_show_home', array(
        'default'           => true,
        'sanitize_callback' => 'iran_news_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'iran_social_show_home', array(
        'label'   => __( 'نمایش در صفحه اصلی', 'iran' ),
        'section' => 'iran_social_section',
        'type'    => 'checkbox',
    ) );

    // Visibility: Internal
    $wp_customize->add_setting( 'iran_social_show_internal', array(
        'default'           => true,
        'sanitize_callback' => 'iran_news_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'iran_social_show_internal', array(
        'label'   => __( 'نمایش در صفحات داخلی', 'iran' ),
        'section' => 'iran_social_section',
        'type'    => 'checkbox',
    ) );

    // Section Title
    $wp_customize->add_setting( 'iran_social_title', array(
        'default'           => 'با ما در <span class="text-brand">ارتباط</span> باشید',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'iran_social_title', array(
        'label'   => __( 'عنوان بخش', 'iran' ),
        'section' => 'iran_social_section',
        'type'    => 'text',
        'input_attrs' => array( 'maxlength' => 120 ),
    ) );

    // Section Description
    $wp_customize->add_setting( 'iran_social_desc', array(
        'default'           => 'آخرین اخبار و تحلیل‌ها را در شبکه‌های اجتماعی دنبال کنید.',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'iran_social_desc', array(
        'label'   => __( 'توضیحات بخش', 'iran' ),
        'section' => 'iran_social_section',
        'type'    => 'textarea',
        'input_attrs' => array( 'maxlength' => 500 ),
    ) );

    // Custom Social Repeater Control
    class Iran_Social_Repeater_Control extends WP_Customize_Control {
        public $type = 'iran-social-repeater';

        public function enqueue() {
            wp_enqueue_media();
            wp_enqueue_style( 'iran-customizer-social', get_template_directory_uri() . '/assets/css/customizer-social.css', array(), '1.1.0' );
            wp_enqueue_script( 'iran-customizer-social', get_template_directory_uri() . '/assets/js/customizer-social.js', array( 'jquery', 'customize-controls', 'jquery-ui-sortable' ), '1.1.0', true );
        }

        public function render_content() {
            $values = json_decode( $this->value(), true );
            if ( ! is_array( $values ) ) $values = array();
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <div class="iran-social-items-list">
                <?php foreach ( $values as $item ) : ?>
                    <?php $this->render_item( $item ); ?>
                <?php endforeach; ?>
            </div>
            <button class="button button-secondary add-social-item-btn"><?php _e( '+ افزودن شبکه جدید', 'iran' ); ?></button>
            
            <div class="iran-social-item-template hidden">
                <?php $this->render_item(); ?>
            </div>
            <input type="hidden" class="iran-social-items-collector" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>">
            <?php
        }

        private function render_item( $item = array() ) {
            $item = wp_parse_args( $item, array(
                'id' => '',
                'label' => '',
                'url' => '',
                'btn_text' => '',
                'new_tab' => true,
                'icon_type' => 'lucide', // 'lucide' or 'custom_svg'
                'icon' => '',
                'custom_svg_id' => '',
                'custom_svg_url' => '',
                'svg_size' => 32,
                'svg_color' => '#ffffff',
                'bg' => 'bg-brand'
            ) );
            ?>
            <div class="iran-social-item">
                <div class="iran-social-item-header">
                    <span class="item-title"><?php echo $item['label'] ? esc_html($item['label']) : __( 'شبکه جدید', 'iran' ); ?></span>
                    <div class="actions">
                        <span class="toggle-item dashicons dashicons-arrow-down-alt2"></span>
                        <span class="remove-item dashicons dashicons-trash"></span>
                    </div>
                </div>
                <div class="iran-social-item-content">
                    <input type="hidden" class="item-id" value="<?php echo esc_attr( $item['id'] ); ?>">
                    
                    <label><?php _e( 'نام شبکه:', 'iran' ); ?></label>
                    <input type="text" class="item-label" value="<?php echo esc_attr( $item['label'] ); ?>">

                    <label><?php _e( 'آدرس (URL):', 'iran' ); ?></label>
                    <input type="url" class="item-url" value="<?php echo esc_url( $item['url'] ); ?>" placeholder="https://...">

                    <label><?php _e( 'متن دکمه:', 'iran' ); ?></label>
                    <input type="text" class="item-btn_text" value="<?php echo esc_attr( $item['btn_text'] ); ?>">

                    <div class="checkbox-row">
                        <input type="checkbox" class="item-new-tab" <?php checked( $item['new_tab'] ); ?>>
                        <label><?php _e( 'باز شدن در تب جدید', 'iran' ); ?></label>
                    </div>

                    <label><?php _e( 'نوع آیکون:', 'iran' ); ?></label>
                    <select class="item-icon-type">
                        <option value="lucide" <?php selected( $item['icon_type'], 'lucide' ); ?>><?php _e( 'کتابخانه Lucide', 'iran' ); ?></option>
                        <option value="custom_svg" <?php selected( $item['icon_type'], 'custom_svg' ); ?>><?php _e( 'SVG سفارشی (آپلود)', 'iran' ); ?></option>
                    </select>

                    <div class="icon-lucide-fields" style="<?php echo ($item['icon_type'] === 'lucide') ? '' : 'display:none;'; ?>">
                        <label><?php _e( 'آیکون (Lucide):', 'iran' ); ?></label>
                        <input type="text" class="item-icon" value="<?php echo esc_attr( $item['icon'] ); ?>" placeholder="e.g. instagram">
                    </div>

                    <div class="icon-custom-svg-fields" style="<?php echo ($item['icon_type'] === 'custom_svg') ? '' : 'display:none;'; ?>">
                        <label><?php _e( 'فایل SVG:', 'iran' ); ?></label>
                        <div class="custom-svg-preview mb-2" style="max-width: 50px;">
                            <?php if ($item['custom_svg_url']) : ?>
                                <img src="<?php echo esc_url($item['custom_svg_url']); ?>" style="width:100%; height:auto; background:#eee; padding:5px; border-radius:4px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" class="item-custom-svg-id" value="<?php echo esc_attr( $item['custom_svg_id'] ); ?>">
                        <input type="hidden" class="item-custom-svg-url" value="<?php echo esc_url( $item['custom_svg_url'] ); ?>">
                        <button type="button" class="button select-svg-btn"><?php _e( 'انتخاب/آپلود SVG', 'iran' ); ?></button>
                        <button type="button" class="button remove-svg-btn <?php echo $item['custom_svg_url'] ? '' : 'hidden'; ?>"><?php _e( 'حذف', 'iran' ); ?></button>
                    </div>

                    <div class="item-style-fields mt-4 pt-4 border-t border-gray-100">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label><?php _e( 'اندازه آیکون (px):', 'iran' ); ?></label>
                                <input type="number" class="item-svg-size" value="<?php echo esc_attr( $item['svg_size'] ); ?>" min="16" max="120">
                            </div>
                            <div class="flex-1">
                                <label><?php _e( 'رنگ آیکون:', 'iran' ); ?></label>
                                <input type="color" class="item-svg-color" value="<?php echo esc_attr( $item['svg_color'] ); ?>">
                            </div>
                        </div>
                    </div>

                    <label class="mt-4"><?php _e( 'کلاس پس‌زمینه (CSS):', 'iran' ); ?></label>
                    <input type="text" class="item-bg" value="<?php echo esc_attr( $item['bg'] ); ?>">
                </div>
            </div>
            <?php
        }
    }

    // Social Items List (Serialized JSON)
    $default_socials = array(
        array( 'id' => 'instagram', 'label' => 'اینستاگرام', 'url' => '#', 'btn_text' => 'مشاهده صفحه', 'new_tab' => true, 'icon_type' => 'lucide', 'icon' => 'instagram', 'bg' => 'social-instagram-bg' ),
        array( 'id' => 'telegram', 'label' => 'تلگرام', 'url' => '#', 'btn_text' => 'عضویت در کانال', 'new_tab' => true, 'icon_type' => 'lucide', 'icon' => 'send', 'bg' => 'social-telegram-bg' ),
        array( 'id' => 'whatsapp', 'label' => 'واتساپ', 'url' => '#', 'btn_text' => 'ارسال پیام', 'new_tab' => true, 'icon_type' => 'lucide', 'icon' => 'whatsapp', 'bg' => 'social-whatsapp-bg' ),
        array( 'id' => 'eitaa', 'label' => 'ایتا', 'url' => '#', 'btn_text' => 'مشاهده کانال', 'new_tab' => true, 'icon_type' => 'lucide', 'icon' => 'eitaa', 'bg' => 'social-eitaa-bg' ),
        array( 'id' => 'bale', 'label' => 'بله', 'url' => '#', 'btn_text' => 'مشاهده کانال', 'new_tab' => true, 'icon_type' => 'lucide', 'icon' => 'bale', 'bg' => 'social-bale-bg' ),
        array( 'id' => 'rubika', 'label' => 'روبیکا', 'url' => '#', 'btn_text' => 'مشاهده صفحه', 'new_tab' => true, 'icon_type' => 'lucide', 'icon' => 'rubika', 'bg' => 'social-rubika-bg' ),
    );

    $wp_customize->add_setting( 'iran_social_items', array(
        'default'           => json_encode($default_socials),
        'sanitize_callback' => 'iran_news_sanitize_social_items',
    ) );

    $wp_customize->add_control( new Iran_Social_Repeater_Control( $wp_customize, 'iran_social_items', array(
        'label'   => __( 'مدیریت و ترتیب شبکه‌های اجتماعی', 'iran' ),
        'section' => 'iran_social_section',
    ) ) );

    // --- Related Posts Section ---
    $wp_customize->add_section( 'iran_related_posts_section', array(
        'title'    => __( 'تنظیمات اخبار مرتبط', 'iran' ),
        'panel'    => 'iran_theme_options',
        'priority' => 25,
    ) );

    // Setting: Related Posts Count
    $wp_customize->add_setting( 'iran_related_posts_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'iran_related_posts_count', array(
        'label'    => __( 'تعداد اخبار مرتبط', 'iran' ),
        'section'  => 'iran_related_posts_section',
        'type'     => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 12 ),
    ) );

    // Setting: Related Posts Query Type
    $wp_customize->add_setting( 'iran_related_posts_query_type', array(
        'default'           => 'category',
        'sanitize_callback' => 'sanitize_key',
    ) );

    $wp_customize->add_control( 'iran_related_posts_query_type', array(
        'label'    => __( 'نوع کوئری اخبار مرتبط', 'iran' ),
        'section'  => 'iran_related_posts_section',
        'type'     => 'select',
        'choices'  => array(
            'category' => __( 'بر اساس دسته بندی', 'iran' ),
            'tag'      => __( 'بر اساس تگ', 'iran' ),
            'both'     => __( 'دسته بندی + تگ', 'iran' ),
        ),
    ) );
    // --- Dynamic Colors Section ---
    $wp_customize->add_section( 'iran_color_section', array(
        'title'    => __( 'رنگ‌بندی پویا', 'iran' ),
        'panel'    => 'iran_theme_options',
        'priority' => 30,
    ) );

    // Brand Color
    $wp_customize->add_setting( 'iran_color_brand', array(
        'default'           => '#cc4345',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'iran_color_brand', array(
        'label'    => __( 'رنگ اصلی / برند', 'iran' ),
        'section'  => 'iran_color_section',
    ) ) );

    // Secondary Color
    $wp_customize->add_setting( 'iran_color_secondary', array(
        'default'           => '#94a3b8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'iran_color_secondary', array(
        'label'    => __( 'رنگ ثانویه', 'iran' ),
        'section'  => 'iran_color_section',
    ) ) );

    // Body Background
    $wp_customize->add_setting( 'iran_color_bg', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'iran_color_bg', array(
        'label'    => __( 'رنگ پس‌زمینه سایت', 'iran' ),
        'section'  => 'iran_color_section',
    ) ) );

    // Body Text
    $wp_customize->add_setting( 'iran_color_text', array(
        'default'           => '#111827',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'iran_color_text', array(
        'label'    => __( 'رنگ متن سایت', 'iran' ),
        'section'  => 'iran_color_section',
    ) ) );

    // Header Background
    $wp_customize->add_setting( 'iran_color_header_bg', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'iran_color_header_bg', array(
        'label'    => __( 'رنگ پس‌زمینه هدر', 'iran' ),
        'section'  => 'iran_color_section',
    ) ) );

    // Footer Background
    $wp_customize->add_setting( 'iran_color_footer_bg', array(
        'default'           => '#1a1a1a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'iran_color_footer_bg', array(
        'label'    => __( 'رنگ پس‌زمینه فوتر', 'iran' ),
        'section'  => 'iran_color_section',
    ) ) );

    // Footer Text Color
    $wp_customize->add_setting( 'iran_color_footer_text', array(
        'default'           => '#9ca3af',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'iran_color_footer_text', array(
        'label'    => __( 'رنگ متن فوتر', 'iran' ),
        'section'  => 'iran_color_section',
    ) ) );

    // Reset Control
    class Iran_Reset_Colors_Control extends WP_Customize_Control {
        public $type = 'iran-reset-colors';
        public function render_content() {
            ?>
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
                <button type="button" id="iran-reset-colors-btn" class="button button-secondary" style="width: 100%; text-align: center; justify-content: center;">
                    <?php _e( 'بازنشانی به تنظیمات کارخانه', 'iran' ); ?>
                </button>
            </div>
            <?php
        }
    }
    $wp_customize->add_setting( 'iran_color_reset', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    $wp_customize->add_control( new Iran_Reset_Colors_Control( $wp_customize, 'iran_color_reset', array(
        'section' => 'iran_color_section',
        'settings' => 'iran_color_reset'
    ) ) );


    // --- Footer Section ---
    $wp_customize->add_section( 'iran_footer_section', array(
        'title'    => __( 'مدیریت فوتر', 'iran' ),
        'panel'    => 'iran_theme_options',
        'priority' => 35,
    ) );

    // Show/hide entire footer
    $wp_customize->add_setting( 'iran_footer_show_all', array(
        'default'           => true,
        'sanitize_callback' => 'iran_news_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'iran_footer_show_all', array(
        'label'    => __( 'فعال بودن نمایش کامل فوتر', 'iran' ),
        'section'  => 'iran_footer_section',
        'type'     => 'checkbox',
    ) );

    // Footer Logo
    $wp_customize->add_setting( 'iran_footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'iran_footer_logo', array(
        'label'    => __( 'لوگوی فوتر', 'iran' ),
        'section'  => 'iran_footer_section',
    ) ) );

    // Show/hide logo
    $wp_customize->add_setting( 'iran_footer_show_logo', array(
        'default'           => true,
        'sanitize_callback' => 'iran_news_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'iran_footer_show_logo', array(
        'label'    => __( 'نمایش لوگوی فوتر', 'iran' ),
        'section'  => 'iran_footer_section',
        'type'     => 'checkbox',
    ) );

    // Footer Title
    $wp_customize->add_setting( 'iran_footer_title', array(
        'default'           => 'وقایع زمانه',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'iran_footer_title', array(
        'label'    => __( 'عنوان اصلی فوتر', 'iran' ),
        'section'  => 'iran_footer_section',
        'type'     => 'text',
    ) );

    // Footer Description
    $wp_customize->add_setting( 'iran_footer_description', array(
        'default'           => 'وقایع زمانه، مرجع مستقل و پیشرو در ارائه تازه‌ترین خبرها و تحلیل‌های روز ایران و جهان. ما متعهد به ارائه اخبار دقیق و بی‌طرفانه هستیم.',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'iran_footer_description', array(
        'label'    => __( 'توضیحات تکمیلی سایت', 'iran' ),
        'section'  => 'iran_footer_section',
        'type'     => 'textarea',
    ) );

    // Show/hide description
    $wp_customize->add_setting( 'iran_footer_show_desc', array(
        'default'           => true,
        'sanitize_callback' => 'iran_news_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'iran_footer_show_desc', array(
        'label'    => __( 'نمایش توضیحات فوتر', 'iran' ),
        'section'  => 'iran_footer_section',
        'type'     => 'checkbox',
    ) );

    // Show/hide menu
    $wp_customize->add_setting( 'iran_footer_show_menu', array(
        'default'           => true,
        'sanitize_callback' => 'iran_news_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'iran_footer_show_menu', array(
        'label'    => __( 'نمایش منوی فوتر (دسترسی سریع)', 'iran' ),
        'section'  => 'iran_footer_section',
        'type'     => 'checkbox',
    ) );

    // Show/hide widgets
    $wp_customize->add_setting( 'iran_footer_show_widgets', array(
        'default'           => true,
        'sanitize_callback' => 'iran_news_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'iran_footer_show_widgets', array(
        'label'    => __( 'نمایش بخش ابزارک‌های فوتر', 'iran' ),
        'section'  => 'iran_footer_section',
        'type'     => 'checkbox',
    ) );
}
add_action( 'customize_register', 'iran_news_customize_register' );

/**
 * Sanitize social items JSON with HTTPS validation.
 */
function iran_news_sanitize_social_items( $input ) {
    $decoded = json_decode( $input, true );
    if ( ! is_array( $decoded ) ) return json_encode(array());
    
    $sanitized = array();
    foreach ( $decoded as $item ) {
        $url = esc_url_raw( $item['url'] );
        // Basic HTTPS validation: if not empty and doesn't start with https, force it or leave empty if invalid
        if ( ! empty( $url ) && strpos( $url, 'https://' ) !== 0 && strpos( $url, '#' ) !== 0 ) {
            $url = ''; 
        }

        $sanitized[] = array(
            'id'             => sanitize_key( $item['id'] ),
            'label'          => sanitize_text_field( $item['label'] ),
            'url'            => $url,
            'btn_text'       => sanitize_text_field( $item['btn_text'] ),
            'new_tab'        => (bool) $item['new_tab'],
            'icon_type'      => in_array($item['icon_type'], array('lucide', 'custom_svg')) ? $item['icon_type'] : 'lucide',
            'icon'           => sanitize_key( $item['icon'] ),
            'custom_svg_id'  => absint( $item['custom_svg_id'] ),
            'custom_svg_url' => esc_url_raw( $item['custom_svg_url'] ),
            'svg_size'       => absint( $item['svg_size'] ),
            'svg_color'      => sanitize_hex_color( $item['svg_color'] ),
            'bg'             => sanitize_key( $item['bg'] )
        );
    }
    return json_encode( $sanitized );
}

/**
 * Sanitize checkbox.
 */
function iran_news_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Allow SVG Uploads
 */
function iran_news_allow_svg_uploads( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'iran_news_allow_svg_uploads' );

/**
 * Sanitize Infinite Scroll Mode
 */
function iran_news_sanitize_scroll_mode( $input ) {
    $valid = array( 'infinite', 'button_after_n' );
    return in_array( $input, $valid, true ) ? $input : 'button_after_n';
}

