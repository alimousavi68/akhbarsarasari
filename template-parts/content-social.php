<?php
/**
 * Social Media Section Template Part
 */

$show_home     = get_theme_mod( 'iran_social_show_home', true );
$show_internal = get_theme_mod( 'iran_social_show_internal', true );

// Determine visibility
$is_home = is_front_page() || is_home();
if ( $is_home && ! $show_home ) return;
if ( ! $is_home && ! $show_internal ) return;

$title = get_theme_mod( 'iran_social_title', 'با ما در <span class="text-brand">ارتباط</span> باشید' );
$desc  = get_theme_mod( 'iran_social_desc', 'آخرین اخبار و تحلیل‌ها را در شبکه‌های اجتماعی دنبال کنید.' );
$items_json = get_theme_mod( 'iran_social_items' );
$items = json_decode( $items_json, true );

if ( empty( $items ) ) return;
?>
<!-- Social Media Section -->
<section class="container-custom mt-20 mb-12 print:hidden" aria-labelledby="social-section-title">
    <div class="flex flex-col lg:flex-row gap-8 items-center lg:items-stretch">
        <!-- Left: Title Content -->
        <div class="lg:w-1/3 flex flex-col justify-center text-center lg:text-right">
            <h2 id="social-section-title" class="text-3xl lg:text-4xl font-black text-gray-900 dark:text-white mb-4 leading-tight">
                <?php echo wp_kses_post( $title ); ?>
            </h2>
            <div class="text-gray-500 text-sm leading-relaxed mb-6">
                <?php echo wp_kses_post( wpautop( $desc ) ); ?>
            </div>
            <div class="flex items-center justify-center lg:justify-start gap-4" aria-hidden="true">
                <div class="w-12 h-1 bg-brand rounded-full"></div>
            </div>
        </div>

        <!-- Right: Social Cards -->
        <div class="lg:w-2/3 grid grid-cols-2 lg:grid-cols-3 gap-6 w-full">
            <?php foreach ( $items as $item ) : 
                $target = ! empty( $item['new_tab'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
                $aria_label = sprintf( __( 'دنبال کردن ما در %s', 'iran' ), $item['label'] );
                $icon_type = isset($item['icon_type']) ? $item['icon_type'] : 'lucide';
                $svg_size = isset($item['svg_size']) ? $item['svg_size'] : 32;
                $svg_color = isset($item['svg_color']) ? $item['svg_color'] : '#ffffff';
                $icon_style = sprintf('width:%dpx; height:%dpx; color:%s; fill:%s;', $svg_size, $svg_size, $svg_color, $svg_color);
            ?>
            <a href="<?php echo esc_url( $item['url'] ); ?>" 
               class="social-gradient-border border border-gray-200 dark:border-gray-800 rounded-2xl p-6 flex flex-col items-center text-center group social-card-pulse"
               <?php echo $target; ?>
               aria-label="<?php echo esc_attr( $aria_label ); ?>">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white mb-4 relative z-10 shadow-lg group-hover:scale-110 transition-transform duration-500 <?php echo esc_attr( $item['bg'] ); ?>" aria-hidden="true">
                    <?php if ( $icon_type === 'custom_svg' && ! empty($item['custom_svg_url']) ) : ?>
                        <?php 
                        // Try to get SVG content for better styling, fallback to img tag
                        $svg_path = get_attached_file($item['custom_svg_id']);
                        if ($svg_path && file_exists($svg_path)) {
                            $svg_content = file_get_contents($svg_path);
                            // Inject style into SVG tag
                            echo str_replace('<svg', '<svg style="' . $icon_style . '"', $svg_content);
                        } else {
                            echo '<img src="' . esc_url($item['custom_svg_url']) . '" style="' . $icon_style . '" alt="' . esc_attr($item['label']) . '" loading="lazy">';
                        }
                        ?>
                    <?php else : ?>
                        <?php if ( ! empty($item['icon']) ) : ?>
                            <i data-lucide="<?php echo esc_attr( $item['icon'] ); ?>" style="<?php echo $icon_style; ?>"></i>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <span class="block text-base font-black text-gray-900 dark:text-white mb-1"><?php echo esc_html( $item['label'] ); ?></span>
                <div class="mt-4 flex items-center gap-2 text-[10px] lg:text-[11px] font-medium py-1.5 px-3 lg:px-4 rounded-full border border-gray-200 dark:border-gray-800 transition-all whitespace-nowrap social-btn-gradient">
                    <span><?php echo esc_html( $item['btn_text'] ); ?></span>
                    <i data-lucide="chevron-left" class="w-3 h-3" aria-hidden="true"></i>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
