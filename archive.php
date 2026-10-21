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
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-brand transition-colors">خانه</a>
                        <i data-lucide="chevron-left" class="w-2.5 h-2.5"></i>
                        <span class="text-gray-500">آرشیو موضوعی</span>
                    </nav>
                    <h1 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <span class="w-1.5 h-8 bg-brand rounded-full"></span>
                        <div class="flex items-center gap-2">
                            <span class="text-brand">آرشیو:</span>
                            <span class="text-secondary font-medium"><?php the_archive_title('', ''); ?></span>
                        </div>
                    </h1>
                </div>

                <div id="latest-news-container" class="flex flex-col divide-y divide-gray-200 dark:divide-gray-800">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                    ?>
                            <div class="flex gap-4 py-8 group cursor-pointer animate-fade-in border-b border-gray-100 dark:border-gray-800 last:border-0">
                                <a href="<?php the_permalink(); ?>" class="flex gap-4 w-full">
                                    <div class="post-thumb-circle w-24 h-24 sm:w-28 sm:h-28 overflow-hidden rounded-full aspect-square shrink-0 shadow-sm">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('iran-square', array('class' => 'w-full h-full object-cover rounded-full group-hover:scale-105 transition-transform duration-700')); ?>
                                        <?php else : ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover rounded-full group-hover:scale-105 transition-transform duration-700">
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-base lg:text-xl font-bold group-hover:text-brand transition-colors line-clamp-2 leading-snug mb-2">
                                            <?php the_title(); ?>
                                        </h3>
                                        <p class="text-[11px] lg:text-xs text-gray-500 line-clamp-2 leading-relaxed hidden sm:block">
                                            <?php echo wp_trim_words(get_the_excerpt(), 35); ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                    <?php
                        endwhile;
                        iran_news_render_pagination();
                    else :
                        echo '<p>خبری در این بخش یافت نشد.</p>';
                    endif;
                    ?>
                </div>
            </div>



            <!-- Sidebar (Col 3) -->
            <aside class="lg:col-span-4 print:hidden dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 md:p-6 shadow-sm">
                <div class="sticky top-8 space-y-12">
                    <!-- Sidebar -->
                    <?php get_sidebar(); ?>
                </div>
            </aside>

        </div>
    </div>
</main>

<?php
get_footer();
?>