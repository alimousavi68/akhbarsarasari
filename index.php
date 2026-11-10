<?php
get_header();
?>

    <main class="lg:pt-6 pb-8">
        <?php if ( get_theme_mod( 'iran_show_hero', true ) ) : ?>
        <!-- Classic Reliable Hero Section -->
        <section class="container-custom mt-6 mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <?php
                $hero_cat = get_theme_mod( 'iran_hero_category', 0 );
                $hero_posts_desktop = (int) get_theme_mod( 'iran_hero_posts_desktop', 5 );
                $hero_posts_mobile  = (int) get_theme_mod( 'iran_hero_posts_mobile', 3 );
                $max_hero_posts     = max( $hero_posts_desktop, $hero_posts_mobile, 1 );

                $hero_args = array(
                    'posts_per_page' => $max_hero_posts,
                    'post_status'    => 'publish',
                );

                if ( $hero_cat > 0 ) {
                    $hero_args['cat'] = $hero_cat;
                }

                $hero_query = new WP_Query( $hero_args );

                if ( $hero_query->have_posts() ) :
                    $count = 0;
                    while ( $hero_query->have_posts() ) : $hero_query->the_post();
                        $count++;

                        // Handle responsive visibility based on customizer counts
                        $classes = array();
                        if ( $count > $hero_posts_desktop && $count > $hero_posts_mobile ) {
                            continue; // Skip rendering if it exceeds both
                        } elseif ( $count > $hero_posts_desktop ) {
                            $classes[] = 'lg:hidden'; // Only visible on mobile/tablet
                        } elseif ( $count > $hero_posts_mobile ) {
                            $classes[] = 'hidden lg:block'; // Only visible on desktop
                        }

                        if ( $count === 1 ) :
                ?>
                <!-- Main Big Post (Right on Desktop) -->
                <div class="lg:col-span-8 group cursor-pointer relative overflow-hidden rounded-xl shadow-md h-[380px] sm:h-[440px] lg:h-[500px] <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
                    <a href="<?php the_permalink(); ?>" class="block h-full">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'iran-large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 right-0 p-6 lg:p-8 w-full">
                            <h1 class="text-xl lg:text-3xl font-black text-white leading-tight">
                                <?php the_title(); ?>
                            </h1>
                        </div>
                    </a>
                </div>

                <?php if ( $hero_query->post_count > 1 ) : ?>
                <!-- Side Grid (Left on Desktop) -->
                <div class="<?php echo ( $hero_posts_mobile <= 1 ) ? 'hidden lg:grid' : 'grid'; ?> lg:col-span-4 grid-cols-2 gap-3 sm:gap-4 h-[380px] sm:h-[440px] lg:h-[500px]">
                <?php endif; ?>

                <?php else : ?>
                    <!-- Small Hero Item (Posts 2+) -->
                    <div class="group cursor-pointer relative overflow-hidden rounded-xl shadow-md h-full min-h-[140px] <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
                        <a href="<?php the_permalink(); ?>" class="block h-full relative">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'iran-medium', array( 'class' => 'absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                            <div class="absolute bottom-0 right-0 p-3 sm:p-4 w-full">
                                <h3 class="text-xs sm:text-sm font-bold text-white leading-snug line-clamp-2">
                                    <?php the_title(); ?>
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php endwhile; wp_reset_postdata(); ?>
                <?php if ( $count > 1 ) : ?>
                </div> <!-- end col-span-4 -->
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; // End iran_show_hero ?>
        <hr class="mb-8 lg:border-b lg:border-gray-200 lg:dark:border-gray-800" >
        
        <!-- Main Content Area -->
        <section class="container-custom ">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">
                <!-- Latest News List -->
                <div class="lg:col-span-8 lg:border-l lg:border-gray-200 lg:dark:border-gray-800 lg:pl-10">
                    <h2 class="text-2xl font-medium mb-1 flex items-center gap-3">
                        <span class="w-2 h-8 bg-brand rounded-full"></span>
                        <div id="latest-news-title" class="flex items-center gap-1">
                            <?php echo get_theme_mod( 'iran_latest_news_title', '<span class="text-brand">آخرین</span><span class="text-secondary"> اخبار</span>' ); ?>
                        </div>
                    </h2>
                    <?php
                    $latest_cat  = get_theme_mod( 'iran_latest_news_category', 0 );
                    $latest_count = get_theme_mod( 'iran_latest_news_count', 10 );
                    $scroll_mode  = get_theme_mod( 'iran_infinite_scroll_mode', 'button_after_n' );
                    $auto_pages   = get_theme_mod( 'iran_infinite_scroll_auto_pages', 3 );
                    
                    $latest_args = array(
                        'posts_per_page' => $latest_count,
                        'post_status'    => 'publish',
                    );

                    if ( $latest_cat > 0 ) {
                        $latest_args['cat'] = $latest_cat;
                    }

                    $latest_query = new WP_Query( $latest_args );
                    $max_pages    = $latest_query->max_num_pages;
                    ?>
                    <div id="latest-news-container"
                        class="flex flex-col min-h-[400px] divide-y divide-gray-200 dark:divide-gray-800"
                        data-current-page="1"
                        data-max-pages="<?php echo esc_attr( $max_pages ); ?>"
                        data-category="<?php echo esc_attr( $latest_cat ); ?>"
                        data-scroll-mode="<?php echo esc_attr( $scroll_mode ); ?>"
                        data-auto-pages="<?php echo esc_attr( $auto_pages ); ?>">
                        <?php
                        if ( $latest_query->have_posts() ) :
                            while ( $latest_query->have_posts() ) : $latest_query->the_post();
                                get_template_part( 'template-parts/content-latest-news' );
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="py-8 text-gray-500 text-center">خبری یافت نشد.</p>';
                        endif;
                        ?>
                    </div>

                    <!-- Infinite Scroll Sentinel & Status Indicator -->
                    <div id="latest-news-sentinel" class="py-6 text-center <?php echo ( $max_pages <= 1 ) ? 'hidden' : ''; ?>" aria-live="polite">
                        <!-- Load More Button (Scenario 2: Button after N pages) -->
                        <button id="latest-news-load-more-btn"
                            type="button"
                            class="hidden inline-flex items-center justify-center gap-2 px-8 py-3 rounded-xl border border-gray-200 dark:border-gray-800 bg-white hover:bg-brand hover:border-brand hover:text-white dark:bg-gray-900 dark:hover:bg-brand dark:hover:border-brand text-gray-700 dark:text-gray-300 font-medium text-sm transition-all duration-300 shadow-sm hover:shadow-md cursor-pointer group">
                            <span>مشاهده اخبار بیشتر</span>
                            <svg class="w-4 h-4 transform group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Loading Spinner -->
                        <div id="latest-news-loader" class="hidden flex items-center justify-center gap-3 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                            <svg class="animate-spin h-5 w-5 text-brand" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>در حال بارگذاری اخبار بیشتر...</span>
                        </div>
                        
                        <!-- End of Content Message -->
                        <div id="latest-news-end" class="hidden py-4 text-xs font-medium text-gray-400 dark:text-gray-500 flex items-center justify-center gap-2">
                            <span class="w-8 h-px bg-gray-200 dark:bg-gray-800"></span>
                            <span>تمام اخبار بارگذاری شدند</span>
                            <span class="w-8 h-px bg-gray-200 dark:bg-gray-800"></span>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <?php get_sidebar(); ?>
            </div>
        </section>

        <!-- Social Media Section -->
        <?php get_template_part( 'template-parts/content', 'social' ); ?>

        <!-- Display Ad Banner -->
        <?php if ( is_active_sidebar( 'home-banner-ad' ) ) : ?>
            <?php dynamic_sidebar( 'home-banner-ad' ); ?>
        <?php endif; ?>
    </main>

<?php
get_footer();
?>
