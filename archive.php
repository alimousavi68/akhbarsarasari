<?php
get_header();
?>

    <main class="py-8 lg:py-12">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">
                <!-- Archive News List -->
                <div class="lg:col-span-8  lg:pl-10">
                    <!-- Archive Header -->
                    <div id="archive-page-header" class="mb-8 bg-gray-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 shadow-sm">
                        <nav class="flex items-center gap-2 text-[10px] text-gray-400 mb-3" aria-label="Breadcrumb">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-brand transition-colors">خانه</a>
                            <i data-lucide="chevron-left" class="w-2.5 h-2.5"></i>
                            <span class="text-gray-500">آرشیو موضوعی</span>
                        </nav>
                        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            <span class="w-1.5 h-8 bg-brand rounded-full"></span>
                            <div class="flex items-center gap-2">
                                <span class="text-brand">آرشیو:</span>
                                <span class="text-secondary font-medium"><?php the_archive_title( '', '' ); ?></span>
                            </div>
                        </h1>
                    </div>

                    <div id="latest-news-container" class="flex flex-col divide-y divide-gray-200 dark:divide-gray-800">
                        <?php
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post();
                        ?>
                        <div class="flex gap-4 py-8 group cursor-pointer animate-fade-in border-b border-gray-100 dark:border-gray-800 last:border-0">
                            <a href="<?php the_permalink(); ?>" class="flex gap-4 w-full">
                                <div class="w-32 h-24 sm:w-48 sm:h-32 overflow-hidden rounded-xl shrink-0 shadow-sm">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'iran-thumbnail', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base lg:text-xl font-bold group-hover:text-brand transition-colors line-clamp-2 leading-snug mb-2">
                                        <?php the_title(); ?>
                                    </h3>
                                    <p class="text-[11px] lg:text-xs text-gray-500 line-clamp-2 leading-relaxed hidden sm:block">
                                        <?php echo wp_trim_words( get_the_excerpt(), 35 ); ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <?php
                            endwhile;
                            the_posts_pagination( array(
                                'prev_text' => '<i data-lucide="chevron-right" class="w-4 h-4"></i>',
                                'next_text' => '<i data-lucide="chevron-left" class="w-4 h-4"></i>',
                                'class'     => 'mt-12 flex items-center justify-center gap-2'
                            ) );
                        else :
                            echo '<p>خبری در این بخش یافت نشد.</p>';
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <?php get_sidebar(); ?>
            </div>
        </div>
    </main>

<?php
get_footer();
?>
