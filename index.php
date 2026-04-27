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
                $hero_args = array(
                    'posts_per_page' => 4,
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
                        if ( $count == 1 ) :
                ?>
                <!-- Main Big Post (Right on Desktop) -->
                <div class="lg:col-span-8 group cursor-pointer relative overflow-hidden rounded-xl shadow-md h-[400px] lg:h-[500px]">
                    <a href="<?php the_permalink(); ?>" class="block h-full">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'iran-large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 right-0 p-6 lg:p-8 w-full">
                            <h1 class="text-xl lg:text-3xl font-black text-white leading-tight group-hover:text-brand transition-colors">
                                <?php the_title(); ?>
                            </h1>
                        </div>
                    </a>
                </div>

                <!-- Side Sidebar (Left on Desktop) -->
                <div class="lg:col-span-4 hidden lg:flex flex-col gap-4">
                    <?php elseif ( $count == 2 ) : ?>
                    <!-- Top Sidebar Item (Overlay Style) -->
                    <div class="group cursor-pointer relative overflow-hidden rounded-xl shadow-md h-[192px] lg:flex-1">
                        <a href="<?php the_permalink(); ?>" class="block h-full">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'iran-medium', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>
                            <div class="absolute bottom-0 right-0 p-5 w-full">
                                <h2 class="text-base lg:text-lg font-bold text-white leading-tight group-hover:text-brand transition-colors line-clamp-2">
                                    <?php the_title(); ?>
                                </h2>
                            </div>
                        </a>
                    </div>

                    <!-- Bottom Sidebar Items (Horizontal Layout) -->
                    <div class="grid grid-cols-2 gap-4 h-[192px] lg:flex-1">
                    <?php elseif ( $count >= 3 ) : ?>
                        <!-- Small Item -->
                        <div class="group cursor-pointer relative overflow-hidden rounded-xl shadow-md">
                            <a href="<?php the_permalink(); ?>" class="block h-full">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'iran-medium', array( 'class' => 'absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-0 right-0 p-3 w-full">
                                    <h3 class="text-[12px] lg:text-sm font-black text-white leading-snug group-hover:text-brand transition-colors line-clamp-2">
                                        <?php the_title(); ?>
                                    </h3>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                    </div> <!-- end grid-cols-2 -->
                </div> <!-- end col-span-4 -->
                <?php endif; ?>
            </div>
        </section>
        <?php endif; // End iran_show_hero ?>
        <hr class="mb-8" style="color: #ebe6e7;">
        
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
                    <div id="latest-news-container"
                        class="flex flex-col min-h-[400px] divide-y divide-gray-200 dark:divide-gray-800">
                        <?php
                        $latest_cat = get_theme_mod( 'iran_latest_news_category', 0 );
                        $latest_count = get_theme_mod( 'iran_latest_news_count', 10 );
                        
                        $latest_args = array(
                            'posts_per_page' => $latest_count,
                            'post_status'    => 'publish',
                        );

                        if ( $latest_cat > 0 ) {
                            $latest_args['cat'] = $latest_cat;
                        }

                        $latest_query = new WP_Query( $latest_args );

                        if ( $latest_query->have_posts() ) :
                            while ( $latest_query->have_posts() ) : $latest_query->the_post();
                        ?>
                        <div class="flex gap-3 py-6 px-0 hover:bg-gray-50 dark:hover:bg-gray-900 transition-all group cursor-pointer animate-fade-in">
                            <a href="<?php the_permalink(); ?>" class="flex gap-3 w-full">
                                <div class="w-24 h-24 sm:w-32 sm:h-32 overflow-hidden rounded-lg shrink-0">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'iran-square', array( 'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500' ) ); ?>
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1">
                                    <div class="text-[10px] text-gray-400 mb-1">
                                        <?php
                                        $categories = get_the_category();
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
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p>خبری یافت نشد.</p>';
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <?php get_sidebar(); ?>
            </div>
        </section>

        <!-- Social Media Section -->
        <?php get_template_part( 'template-parts/content', 'social' ); ?>

        <!-- Display Ad Banner -->
        <section class="container-custom my-10">
            <div class="relative group overflow-hidden rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-800 aspect-[9/3] lg:aspect-[9/1] flex items-center justify-center bg-gray-50/50 dark:bg-gray-900/50">
                <div class="text-center">
                    <i data-lucide="image" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">محل تبلیغات شما</span>
                </div>
            </div>
        </section>
    </main>

<?php
get_footer();
?>
