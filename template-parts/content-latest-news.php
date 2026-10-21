<?php
/**
 * Template part for displaying a single latest news item
 *
 * @package Iran_News
 */

$categories = get_the_category();
?>
<div class="flex gap-3 py-6 px-0 hover:bg-gray-50 dark:hover:bg-gray-900 transition-all group cursor-pointer animate-fade-in">
    <a href="<?php the_permalink(); ?>" class="flex gap-3 w-full">
        <div class="post-thumb-circle w-24 h-24 sm:w-28 sm:h-28 overflow-hidden rounded-full aspect-square shrink-0">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'iran-square', array( 'class' => 'w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500' ) ); ?>
            <?php else : ?>
                <div class="w-full h-full bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-400">
                    <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
            <?php endif; ?>
        </div>
        <div class="flex-1">
            <div class="text-[10px] text-gray-400 mb-1">
                <?php
                if ( ! empty( $categories ) ) {
                    echo 'گزارش اختصاصی از حوزه ' . esc_html( $categories[0]->name ) . ':';
                }
                ?>
            </div>
            <h3 class="text-[16px] lg:text-xl font-normal group-hover:text-brand transition-colors line-clamp-3 lg:line-clamp-2 leading-[1.6]">
                <?php the_title(); ?>
            </h3>
            <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed hidden lg:block">
                <?php echo wp_trim_words( get_the_excerpt(), 35 ); ?>
            </p>
        </div>
    </a>
</div>
