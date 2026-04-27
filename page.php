<?php
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
?>

    <main class="py-8 lg:py-12">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">
                <!-- Page Content (Col 8) -->
                <div class="lg:col-span-8">
                    <!-- Page Header -->
                    <header class="mb-10 text-right">
                        <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6" aria-label="Breadcrumb">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-brand transition-colors">خانه</a>
                            <i data-lucide="chevron-left" class="w-3 h-3"></i>
                            <span class="text-gray-500"><?php the_title(); ?></span>
                        </nav>

                        <h1 class="text-3xl lg:text-[40px] font-black text-gray-900 dark:text-white leading-tight mb-8">
                            <?php the_title(); ?>
                        </h1>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="relative rounded-3xl overflow-hidden shadow-lg group mb-12">
                                <?php the_post_thumbnail( 'iran-large', array( 'class' => 'w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
                            </div>
                        <?php endif; ?>
                    </header>

                    <!-- Page Content -->
                    <article class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-6 lg:p-12 shadow-sm">
                        <div class="post-content">
                            <?php the_content(); ?>
                        </div>

                        <?php get_template_part( 'template-parts/content', 'social' ); ?>

                        <?php
                        // Display comments if enabled
                        if ( comments_open() || get_comments_number() ) :
                            echo '<div class="mt-16 pt-10 border-t border-gray-100 dark:border-gray-800">';
                            comments_template();
                            echo '</div>';
                        endif;
                        ?>
                    </article>
                </div>

                <!-- Sidebar (Col 4) -->
                <?php get_sidebar(); ?>
            </div>
        </div>
    </main>

<?php
    endwhile;
endif;

get_footer();
?>
