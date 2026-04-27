<?php
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
?>

    <main class="py-8 lg:py-12">
        <div class="container-custom">
            <!-- Print Only Header -->
            <div class="hidden print-header">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php bloginfo( 'name' ); ?>">
                <h1 class="print-title"><?php the_title(); ?></h1>
                <p class="print-date">تاریخ انتشار: <?php echo get_the_date(); ?></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-4">

                <!-- Post Content (Col 9) -->
                <article class="lg:col-span-8 print:col-span-12 lg:pl-4">
                    <!-- Breadcrumbs & Social Row -->
                    <div class="flex items-center justify-between pb-4 print:hidden">
                        <!-- Breadcrumbs (Top Right) -->
                        <nav class="flex items-center gap-2 text-xs text-gray-500 overflow-x-auto no-scrollbar whitespace-nowrap"
                            aria-label="Breadcrumb">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-brand">خانه</a>
                            <i data-lucide="chevron-left" class="w-3 h-3 text-gray-300"></i>
                            <?php
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) {
                                echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="hover:text-brand">' . esc_html( $categories[0]->name ) . '</a>';
                            }
                            ?>
                        </nav>

                        <!-- Social Sharing (Top Left) -->
                        <div class="flex items-center gap-2">
                            <a href="https://wa.me/?text=<?php echo urlencode( get_the_permalink() ); ?>"
                                class="w-8 h-8 rounded-full border border-[#e0e0e0] flex items-center justify-center text-gray-400 hover:text-brand hover:border-brand transition-all"
                                title="واتساپ" target="_blank">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                            </a>
                            <a href="https://t.me/share/url?url=<?php echo urlencode( get_the_permalink() ); ?>"
                                class="w-8 h-8 rounded-full border border-[#e0e0e0] flex items-center justify-center text-gray-400 hover:text-brand hover:border-brand transition-all"
                                title="تلگرام" target="_blank">
                                <i data-lucide="send" class="w-4 h-4"></i>
                            </a>

                            <button id="print-post-btn"
                                class="w-8 h-8 rounded-full border border-[#e0e0e0] flex items-center justify-center text-gray-400 hover:text-brand hover:border-brand transition-all cursor-pointer"
                                title="چاپ">
                                <i data-lucide="printer" class="w-4 h-4"></i>
                            </button>
                            <button id="copy-link-btn-top"
                                class="w-8 h-8 rounded-full border border-[#e0e0e0] flex items-center justify-center text-gray-400 hover:text-brand hover:border-brand transition-all cursor-pointer"
                                title="کپی لینک">
                                <i data-lucide="link" class="w-4 h-4"></i>
                            </button>
                            <a href="#comments"
                                class="w-8 h-8 rounded-full border border-[#e0e0e0] flex items-center justify-center text-gray-400 hover:text-brand hover:border-brand transition-all"
                                title="نظرات">
                                <i data-lucide="message-square" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Post Header -->
                    <header class="mb-10 gap-6 md:gap-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 md:p-6 shadow-sm">
                        <?php if ( get_post_meta( get_the_ID(), 'kicker', true ) ) : ?>
                            <div class="mb-2 text-gray-400 text-[11px] font-bold"><?php echo esc_html( get_post_meta( get_the_ID(), 'kicker', true ) ); ?></div>
                        <?php endif; ?>

                        <h1 class="text-3xl lg:text-[34px] font-bold text-gray-900 dark:text-white leading-[1.3] mb-4">
                            <?php the_title(); ?>
                        </h1>

                        <div class="flex items-center gap-4 text-gray-400 text-[11px] mb-6">
                            <span class="flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3 h-3"></i>
                                <?php echo get_the_date(); ?>
                            </span>
                        </div>

                        <?php if ( has_excerpt() ) : ?>
                            <p class="text-[15px] font-normal text-gray-600 dark:text-gray-400 leading-[1.8] mb-10">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="relative rounded-2xl overflow-hidden shadow-sm group">
                                <?php the_post_thumbnail( 'iran-large', array( 'class' => 'w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
                            </div>
                        <?php endif; ?>
                    </header>

                    <!-- Post Content Area -->
                    <div class="post-content mb-12">
                        <?php the_content(); ?>
                    </div>

                    <!-- Post Footer (Tags, Shortlink) -->
                    <footer class="mb-12 print:hidden border-t border-[#e0e0e0] pt-10">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
                            <div class="flex flex-wrap items-center gap-2">
                                <?php
                                $tags = get_the_tags();
                                if ( $tags ) :
                                    echo '<span class="text-gray-400 text-xs ml-2">برچسب‌ها:</span>';
                                    foreach ( $tags as $tag ) :
                                ?>
                                    <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
                                        class="bg-gray-100 dark:bg-gray-800 text-gray-500 px-3 py-1.5 rounded-lg text-[11px] lg:text-xs hover:bg-brand hover:text-white transition-all">
                                        <?php echo esc_html( $tag->name ); ?>
                                    </a>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 rounded-xl p-3 lg:p-4 flex items-center gap-3 max-w-xs lg:max-w-sm">
                                <div class="flex items-center gap-2 text-gray-500 shrink-0">
                                    <i data-lucide="link" class="w-3.5 h-3.5"></i>
                                    <span class="text-[11px] font-medium hidden sm:inline">لینک کوتاه:</span>
                                </div>
                                <div class="relative flex-1 flex items-center bg-white dark:bg-black border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-1.5">
                                    <div class="text-[11px] font-mono text-gray-500 dark:text-gray-400 truncate" id="short-link-text"><?php echo wp_get_shortlink(); ?></div>
                                    <button id="copy-link-btn"
                                        class="mr-2 text-gray-400 hover:text-brand transition-colors">
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </footer>

                    <!-- Related News -->
                    <?php
                    $related_count = get_theme_mod( 'iran_related_posts_count', 4 );
                    $query_type    = get_theme_mod( 'iran_related_posts_query_type', 'category' );
                    
                    $args = array(
                        'posts_per_page' => $related_count,
                        'post__not_in'   => array( get_the_ID() ),
                        'post_status'    => 'publish',
                    );

                    if ( $query_type === 'tag' ) {
                        $tags = wp_get_post_tags( get_the_ID() );
                        if ( $tags ) {
                            $tag_ids = array();
                            foreach( $tags as $tag ) $tag_ids[] = $tag->term_id;
                            $args['tag__in'] = $tag_ids;
                        } else {
                            // Fallback to category if no tags
                            $args['category__in'] = wp_get_post_categories( get_the_ID() );
                        }
                    } elseif ( $query_type === 'both' ) {
                        $tags = wp_get_post_tags( get_the_ID() );
                        $cat_ids = wp_get_post_categories( get_the_ID() );
                        
                        $args['tax_query'] = array(
                            'relation' => 'OR',
                            array(
                                'taxonomy' => 'category',
                                'field'    => 'term_id',
                                'terms'    => $cat_ids,
                            )
                        );
                        
                        if ( $tags ) {
                            $tag_ids = array();
                            foreach( $tags as $tag ) $tag_ids[] = $tag->term_id;
                            $args['tax_query'][] = array(
                                'taxonomy' => 'post_tag',
                                'field'    => 'term_id',
                                'terms'    => $tag_ids,
                            );
                        }
                    } else {
                        // Default: category
                        $args['category__in'] = wp_get_post_categories( get_the_ID() );
                    }

                    $related = new WP_Query( $args );

                    if ( $related->have_posts() ) :
                    ?>
                    <section class="mb-12 print:hidden border-t border-[#e0e0e0] pt-10">
                        <h2 class="text-2xl font-medium mb-6 flex items-center gap-3">
                            <span class="w-2 h-8 bg-brand rounded-full"></span>
                            <div class="flex items-center gap-1">
                                <span class="text-brand">اخبار</span><span class="text-secondary"> مرتبط</span>
                            </div>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="group block">
                                <div class="flex gap-4 items-start">
                                    <div class="w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'iran-square', array( 'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500' ) ); ?>
                                        <?php else : ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-sm font-bold text-gray-900 dark:text-white leading-relaxed mb-2 group-hover:text-brand transition-colors line-clamp-2">
                                            <?php the_title(); ?>
                                        </h3>
                                        <div class="flex items-center gap-2 text-[10px] text-gray-400">
                                            <i data-lucide="clock" class="w-3 h-3"></i>
                                            <span><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' پیش'; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- Social Media Section -->
                    <?php get_template_part( 'template-parts/content', 'social' ); ?>

                    <!-- Comments Section -->
                    <?php
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    ?>
                </article>

                <!-- Sidebar (Col 3) -->
                <aside class="lg:col-span-4 print:hidden dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 md:p-6 shadow-sm">
                    <div class="sticky top-8 space-y-12">
                        <?php dynamic_sidebar( 'post-sidebar' ); ?>
                    </div>
                </aside>
            </div>
        </div>
    </main>

<?php
    endwhile;
endif;

get_footer();
?>
