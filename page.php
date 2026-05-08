<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Iran_News
 */

get_header();
?>

    <main class="py-8 lg:py-12">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">
                
                <!-- Page Content (Col 8) -->
                <div class="lg:col-span-8 lg:pl-10">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                    ?>
                        <!-- Breadcrumbs -->
                        <nav class="flex items-center gap-2 text-[10px] text-gray-400 mb-6" aria-label="Breadcrumb">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-brand transition-colors">خانه</a>
                            <i data-lucide="chevron-left" class="w-2.5 h-2.5"></i>
                            <span class="text-gray-500"><?php the_title(); ?></span>
                        </nav>

                        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 lg:p-10 shadow-sm'); ?>>
                            <header class="mb-8 border-b border-gray-100 dark:border-gray-800 pb-6">
                                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
                                    <?php the_title(); ?>
                                </h1>
                            </header>

                            <div class="post-content">
                                <?php
                                the_content();

                                wp_link_pages(
                                    array(
                                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'iran' ),
                                        'after'  => '</div>',
                                    )
                                );
                                ?>
                            </div>
                        </article>

                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;

                    endwhile; // End of the loop.
                    ?>
                </div>

                <!-- Sidebar (Col 4) -->
                <aside class="lg:col-span-4 print:hidden">
                    <div class="sticky top-8 space-y-12">
                        <?php get_sidebar(); ?>
                    </div>
                </aside>

            </div>
        </div>
    </main>

<?php
get_footer();
