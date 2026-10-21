<?php
/**
 * Iran News functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Iran_News
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Custom widgets for this theme.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

function iran_news_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes
	add_image_size( 'iran-large', 850, 500, true ); // Hero Main, Post Featured
	add_image_size( 'iran-medium', 400, 250, true ); // Hero Sidebar Overlay
	add_image_size( 'iran-thumbnail', 200, 150, true ); // Hero Small, Archive, Most Visited
	add_image_size( 'iran-square', 150, 150, true ); // Latest News, Related News

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary Menu', 'iran' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'iran' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'iran_news_setup' );

/**
 * Trim attribute text safely for HTML attributes.
 *
 * @param string $text Raw text.
 * @param int    $max_length Maximum length.
 * @return string
 */
function iran_news_trim_attribute_text( $text, $max_length ) {
	return wp_html_excerpt( wp_strip_all_tags( (string) $text ), $max_length, '' );
}

/**
 * Build header logo data from WordPress settings.
 *
 * @return array<string, string>
 */
function iran_news_get_header_logo_data() {
	$site_name        = get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description' );
	$logo_alt         = $site_description ? $site_description : $site_name;
	$custom_logo_id   = get_theme_mod( 'custom_logo' );
	$logo_url         = '';

	if ( $custom_logo_id ) {
		$logo_src = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		if ( ! empty( $logo_src[0] ) ) {
			$logo_url = $logo_src[0];
		}
	}

	return array(
		'site_name' => $site_name,
		'title'     => iran_news_trim_attribute_text( $site_name, 70 ),
		'alt'       => iran_news_trim_attribute_text( $logo_alt, 125 ),
		'logo_url'  => $logo_url,
	);
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function iran_news_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'سایدبار اصلی', 'iran' ),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'ابزارک‌های خود را اینجا قرار دهید.', 'iran' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s mb-12">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="text-2xl font-medium mb-6 flex items-center gap-3"><span class="w-2 h-8 bg-brand rounded-full"></span><div class="flex items-center gap-1">',
			'after_title'   => '</div></h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'سایدبار نوشته‌ها', 'iran' ),
			'id'            => 'post-sidebar',
			'description'   => esc_html__( 'ابزارک‌های مخصوص صفحات نوشته.', 'iran' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s space-y-6">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="text-2xl font-medium mb-6 flex items-center gap-3"><span class="w-2 h-8 bg-brand rounded-full"></span><div class="flex items-center gap-1">',
			'after_title'   => '</div></h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'فوتر', 'iran' ),
			'id'            => 'footer-sidebar',
			'description'   => esc_html__( 'ابزارک‌های بخش فوتر.', 'iran' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s w-full lg:w-auto">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="text-white text-lg font-medium mb-5 text-center lg:text-right">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'تبلیغات بنری صفحه اصلی', 'iran' ),
			'id'            => 'home-banner-ad',
			'description'   => esc_html__( 'جایگاه بنر عریض در پایین صفحه اصلی.', 'iran' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s container-custom my-10">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="hidden">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'زیر نوشته (Single)', 'iran' ),
			'id'            => 'post-bottom-ad',
			'description'   => esc_html__( 'جایگاه ابزارک در انتهای محتوای نوشته.', 'iran' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s mb-12">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="text-xl font-bold mb-6 flex items-center gap-3"><span class="w-1.5 h-6 bg-brand rounded-full"></span>',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'زیر شبکه‌های اجتماعی (Single)', 'iran' ),
			'id'            => 'post-after-social-ad',
			'description'   => esc_html__( 'جایگاه ابزارک در پایین بخش اشتراک‌گذاری نوشته.', 'iran' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s mb-12">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="text-xl font-bold mb-6 flex items-center gap-3"><span class="w-1.5 h-6 bg-brand rounded-full"></span>',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'iran_news_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function iran_news_scripts() {
	// Enqueue main stylesheet
	wp_enqueue_style( 'iran-news-style', get_stylesheet_uri(), array(), '1.0.0' );
	wp_enqueue_style( 'iran-news-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0' );

	// Enqueue scripts
	wp_enqueue_script( 'lucide', get_template_directory_uri() . '/assets/js/lucide.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'iran-news-main', get_template_directory_uri() . '/assets/js/main.js', array('lucide'), '1.0.0', true );

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'iran-news-comments', get_template_directory_uri() . '/assets/js/comments.js', array('lucide'), '1.0.0', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_front_page() || is_home() ) {
		wp_enqueue_script( 'iran-news-infinite-scroll', get_template_directory_uri() . '/assets/js/infinite-scroll.js', array( 'lucide' ), '1.0.0', true );
		wp_localize_script( 'iran-news-infinite-scroll', 'iranAjax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'iran_news_ajax_nonce' ),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'iran_news_scripts' );

/**
 * Add custom attributes to scripts
 */
function iran_news_script_loader_tag($tag, $handle, $src) {
    if ('iran-news-main' === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'iran_news_script_loader_tag', 10, 3);

/**
 * Render themed pagination links.
 *
 * @return void
 */
function iran_news_render_pagination() {
	$links = paginate_links(
		array(
			'type'      => 'array',
			'mid_size'  => 1,
			'end_size'  => 1,
			'prev_text' => '<i data-lucide="chevron-right" class="w-4 h-4"></i>',
			'next_text' => '<i data-lucide="chevron-left" class="w-4 h-4"></i>',
		)
	);

	if ( empty( $links ) || ! is_array( $links ) ) {
		return;
	}
	?>
	<nav class="mt-10 flex items-center justify-center" aria-label="<?php esc_attr_e( 'صفحه‌بندی نوشته‌ها', 'iran' ); ?>">
		<div class="flex flex-wrap items-center justify-center gap-2 rounded-2xl border border-gray-200 bg-white p-2 shadow-sm dark:border-gray-700 dark:bg-slate-900">
			<?php foreach ( $links as $link ) : ?>
				<?php
				$link = str_replace(
					'page-numbers',
					'page-numbers inline-flex min-w-10 h-10 items-center justify-center rounded-xl border border-transparent px-3 text-sm font-medium text-gray-600 transition-colors hover:border-brand/20 hover:bg-brand hover:text-white dark:text-gray-300 dark:hover:border-brand/30',
					$link
				);
				$link = str_replace(
					'current',
					'current border-brand bg-brand text-white shadow-sm',
					$link
				);
				$link = str_replace(
					'dots',
					'dots pointer-events-none text-gray-400 dark:text-gray-500',
					$link
				);

				echo wp_kses_post( $link );
				?>
			<?php endforeach; ?>
		</div>
	</nav>
	<?php
}

/**
 * Custom Walker for Navigation Menu
 */
class Iran_News_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"submenu\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        
        $is_active = in_array('current-menu-item', $classes);
        
        if ($depth === 0) {
            $link_class = $is_active ? 'nav-link-active' : 'nav-link';
            if ($has_children) {
                $output .= '<div class="submenu-container group flex items-center">';
                $output .= '<a href="' . esc_url($item->url) . '" class="' . $link_class . ' flex items-center gap-1">' . apply_filters('the_title', $item->title, $item->ID) . ' <i data-lucide="chevron-down" class="w-4 h-4 opacity-50"></i></a>';
            } else {
                $output .= '<a href="' . esc_url($item->url) . '" class="' . $link_class . '">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
            }
        } else {
            $output .= '<a href="' . esc_url($item->url) . '" class="submenu-item">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        if ($depth === 0 && $has_children) {
            $output .= '</div>';
        }
    }
}

/**
 * Custom Walker for Mobile Navigation Menu
 */
class Iran_News_Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"mobile-submenu hidden flex-col pr-4 bg-gray-50/50 dark:bg-gray-900/50 rounded-xl mt-1 mb-2\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        $is_active = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);

        if ($has_children) {
            $output .= '<div class="mobile-submenu-container flex flex-col py-1">';
            $output .= '<div class="flex items-center justify-between w-full">';
            $output .= '<a href="' . esc_url($item->url) . '" class="mobile-nav-item flex-1 ' . ($is_active ? 'mobile-nav-item-active font-bold text-brand' : '') . '">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
            $output .= '<button class="mobile-submenu-toggle p-4 text-gray-400 hover:text-brand transition-all cursor-pointer"><i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300"></i></button>';
            $output .= '</div>';
        } else {
            $class_base = $depth > 0 ? 'mobile-sub-nav-item' : 'mobile-nav-item';
            $padding = $depth > 0 ? 'py-3' : 'py-4';
            $border = $depth === 0 ? 'border-b border-gray-50 dark:border-gray-900 last:border-0' : '';
            
            $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_base . ' ' . $padding . ' ' . $border . ' ' . ($is_active ? 'mobile-nav-item-active font-bold text-brand' : '') . '">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $output .= '</div>';
        }
    }
}

/**
 * Custom Comment Callback
 */
function iran_news_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class('py-6'); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>" class="flex gap-4">
            <div class="shrink-0">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full overflow-hidden border-2 border-white dark:border-gray-800 shadow-sm">
                    <?php echo get_avatar($comment, $args['avatar_size']); ?>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">
                        <?php echo get_comment_author_link(); ?>
                    </h4>
                    <span class="text-[10px] text-gray-400">
                        <?php printf(__('%s پیش', 'iran'), human_time_diff(get_comment_time('U'), current_time('timestamp'))); ?>
                    </span>
                </div>
                
                <?php if ($comment->comment_approved == '0') : ?>
                    <p class="text-[11px] text-brand italic mb-2"><?php _e('دیدگاه شما در انتظار تایید مدیریت است.', 'iran'); ?></p>
                <?php endif; ?>

                <div class="text-[13px] text-gray-600 dark:text-gray-400 leading-relaxed mb-3">
                    <?php comment_text(); ?>
                </div>

                <div class="flex items-center gap-4">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'reply_text' => '<span class="flex items-center gap-1 text-[11px] font-bold text-brand hover:underline"><i data-lucide="reply" class="w-3 h-3"></i> ' . __('پاسخ', 'iran') . '</span>',
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth']
                    )));
                    ?>
                    <?php edit_comment_link('<span class="text-[11px] text-gray-400 hover:text-brand">' . __('ویرایش', 'iran') . '</span>', '  ', ''); ?>
                </div>
            </div>
        </div>
    <?php
}

/**
 * Advanced SEO & AI Optimization for Header
 */
function akhabreiran_advanced_seo_tags() {	
    // 1. Resource Hints for Performance (Core Web Vitals)
    ?>
    <link rel="preconnect" href="<?php echo esc_url( home_url() ); ?>">
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    
    <?php // Preload Critical Font to improve LCP ?>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/arad/AradFDVF.woff2" as="font" type="font/woff2" crossorigin>

    <?php
    // 2. AI & Crawler Specific Tags
    // Allow indexing but prevent some AI bots from training if desired (optional)
    // <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    ?>
    <meta name="news_keywords" content="<?php echo esc_attr( get_the_tags() ? implode(',', wp_list_pluck(get_the_tags(), 'name')) : get_bloginfo('name') ); ?>">

    <?php
    // 3. News Specific Structured Data (Speakable)
    if ( is_single() ) {
        ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebPage",
          "speakable": {
            "@type": "SpeakableSpecification",
            "xpath": [
              "/html/head/title",
              "//*[@id='post-content']" 
            ]
          }
        }
        </script>
        <?php
    }
}
add_action( 'wp_head', 'akhabreiran_advanced_seo_tags', 1 ); // Priority 1 to load before plugin tags

/**
 * Safe Google Site Name Schema & Open Graph Tags
 * Automatically bypassed if Rank Math, Yoast SEO or AIOSEO is active.
 */
function iran_news_google_site_name_schema() {
    if ( defined( 'RANK_MATH_FILE' ) || defined( 'WPSEO_VERSION' ) || defined( 'AIOSEO_VERSION' ) ) {
        return;
    }

    $site_name = get_bloginfo( 'name' );
    $site_url  = home_url( '/' );

    // 1. Open Graph Site Name
    echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";

    // 2. Google WebSite Structured Data (Homepage only)
    if ( is_front_page() || is_home() ) {
        $schema = array(
            '@context'        => 'https://schema.org',
            '@type'           => 'WebSite',
            'name'            => $site_name,
            'alternateName'   => array( 'Vaghaye Zamaneh', 'وقایع زمانه' ),
            'url'             => $site_url,
            'potentialAction' => array(
                '@type'       => 'SearchAction',
                'target'      => array(
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => esc_url( trailingslashit( $site_url ) ) . '?s={search_term_string}',
                ),
                'query-input' => 'required name=search_term_string',
            ),
        );

        echo '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'iran_news_google_site_name_schema', 2 );

/**
 * Output dynamic CSS styles based on customizer choices.
 */
function iran_news_dynamic_css() {
    $brand = get_theme_mod( 'iran_color_brand', '#cc4345' );
    $secondary = get_theme_mod( 'iran_color_secondary', '#94a3b8' );
    $bg = get_theme_mod( 'iran_color_bg', '#ffffff' );
    $text = get_theme_mod( 'iran_color_text', '#111827' );
    $header_bg = get_theme_mod( 'iran_color_header_bg', '#ffffff' );
    $footer_bg = get_theme_mod( 'iran_color_footer_bg', '#1a1a1a' );
    $footer_text = get_theme_mod( 'iran_color_footer_text', '#9ca3af' );

    ?>
    <style id="iran-dynamic-colors">
        :root {
            --color-brand: <?php echo esc_attr( $brand ); ?> !important;
            --color-secondary: <?php echo esc_attr( $secondary ); ?> !important;
        }
        body:not(.dark) {
            background-color: <?php echo esc_attr( $bg ); ?> !important;
            color: <?php echo esc_attr( $text ); ?> !important;
        }
        .sticky-nav:not(.dark) {
            background-color: <?php echo esc_attr( $header_bg ); ?> !important;
        }
        footer.bg-\[\#1a1a1a\] {
            background-color: <?php echo esc_attr( $footer_bg ); ?> !important;
        }
        footer, footer p, footer a, footer h3 {
            color: <?php echo esc_attr( $footer_text ); ?> !important;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'iran_news_dynamic_css', 150 );

/**
 * Enqueue live preview Customizer JS
 */
function iran_news_customizer_preview_scripts() {
    wp_enqueue_script(
        'iran-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array( 'customize-preview', 'jquery' ),
        '1.0.0',
        true
    );
}
add_action( 'customize_preview_init', 'iran_news_customizer_preview_scripts' );

/**
 * Enqueue customizer controls JS
 */
function iran_news_customizer_controls_scripts() {
    wp_enqueue_script(
        'iran-customizer-controls',
        get_template_directory_uri() . '/assets/js/customizer-controls.js',
        array( 'customize-controls', 'jquery' ),
        '1.0.0',
        true
    );
}
add_action( 'customize_controls_enqueue_scripts', 'iran_news_customizer_controls_scripts' );

/**
 * AJAX Handler for Infinite Scroll (Latest News)
 */
function iran_news_load_more_latest_posts() {
    check_ajax_referer( 'iran_news_ajax_nonce', 'nonce' );

    $paged = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
    $cat   = isset( $_POST['category'] ) ? absint( $_POST['category'] ) : 0;
    $count = get_theme_mod( 'iran_latest_news_count', 10 );

    $args = array(
        'post_status'    => 'publish',
        'paged'          => $paged,
        'posts_per_page' => $count,
    );

    if ( $cat > 0 ) {
        $args['cat'] = $cat;
    }

    $query = new WP_Query( $args );

    ob_start();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/content-latest-news' );
        }
        wp_reset_postdata();
    }
    $html = ob_get_clean();

    wp_send_json_success( array(
        'html'      => $html,
        'max_pages' => (int) $query->max_num_pages,
        'paged'     => $paged,
    ) );
}
add_action( 'wp_ajax_iran_news_load_more', 'iran_news_load_more_latest_posts' );
add_action( 'wp_ajax_nopriv_iran_news_load_more', 'iran_news_load_more_latest_posts' );

