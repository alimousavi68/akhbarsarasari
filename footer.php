    <!-- Footer -->
    <?php if ( get_theme_mod( 'iran_footer_show_all', true ) ) : ?>
    <footer class="bg-[#1a1a1a] text-gray-400 pt-12 pb-4 lg:pb-6 border-t border-gray-800">
        <div class="container-custom">
            <div class="flex flex-col gap-10 lg:flex-row lg:items-start lg:justify-between">
               
                <?php if ( get_theme_mod( 'iran_footer_show_logo', true ) || get_theme_mod( 'iran_footer_show_desc', true ) ) : ?>
                <div class="hidden lg:flex flex-col lg:flex-1 gap-4">
                    <?php if ( get_theme_mod( 'iran_footer_show_logo', true ) ) : ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="block">
                            <?php
                            $footer_logo = get_theme_mod( 'iran_footer_logo' );
                            if ( ! empty( $footer_logo ) ) {
                                echo '<img src="' . esc_url( $footer_logo ) . '" alt="' . get_bloginfo( 'name' ) . '" class="h-16 w-auto">';
                            } else {
                                $custom_logo_id = get_theme_mod( 'custom_logo' );
                                $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                                if ( has_custom_logo() ) {
                                    echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="h-16 w-auto">';
                                } else {
                                    echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ) . '" alt="' . get_bloginfo( 'name' ) . '" class="h-16 w-auto">';
                                }
                            }
                            ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( get_theme_mod( 'iran_footer_show_desc', true ) ) : ?>
                        <h3 class="text-white font-medium text-lg">
                            <?php echo esc_html( get_theme_mod( 'iran_footer_title', 'اخبار سراسری' ) ); ?>
                        </h3>
                        <p class="text-sm text-gray-400 leading-loose">
                            <?php echo wp_kses_post( get_theme_mod( 'iran_footer_description', 'اخبار سراسری، مرجع مستقل و پیشرو در ارائه تازه‌ترین خبرها و تحلیل‌های روز ایران و جهان. ما متعهد به ارائه اخبار دقیق و بی‌طرفانه هستیم.' ) ); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Footer Menu Column -->
                <?php if ( get_theme_mod( 'iran_footer_show_menu', true ) ) : ?>
                <div class="hidden lg:block lg:flex-1">
                    <h3 class="text-white font-medium text-lg mb-4">دسترسی سریع</h3>
                    <?php
                    if ( has_nav_menu( 'footer-menu' ) ) {
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer-menu',
                                'container'      => false,
                                'menu_class'     => 'flex flex-col space-y-3 text-sm text-gray-400 [&_a]:hover:text-brand [&_a]:transition-colors',
                                'fallback_cb'    => false,
                            )
                        );
                    } else {
                        echo '<p class="text-xs text-gray-500">فهرست "منوی فوتر" را از بخش نمایش > فهرست‌ها تنظیم کنید.</p>';
                    }
                    ?>
                </div>
                <?php endif; ?>

                <!-- Footer Sidebar Column -->
                <?php if ( get_theme_mod( 'iran_footer_show_widgets', true ) && is_active_sidebar( 'footer-sidebar' ) ) : ?>
                    <div class="w-full lg:flex-1">
                        <?php dynamic_sidebar( 'footer-sidebar' ); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="pt-4 mt-4 border-t border-gray-800 text-center text-xs text-gray-500">
                <p>طراحی و توسعه: <a href="http://ihasht.ir/" class="text-brand hover:underline transition-all">هشت بهشت</a></p>
            </div>
        </div>
    </footer>
    <?php endif; ?>

   
    <!-- Mobile Sidebar Menu -->
    <div id="mobile-menu"
        class="fixed inset-0 z-[120] bg-white dark:bg-black translate-x-full transition-transform duration-500 lg:hidden overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8 border-b border-gray-100 dark:border-gray-800 pb-6">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-2xl font-medium tracking-tighter">
                    <span class="text-brand"><?php echo explode(' ', get_bloginfo('name'))[0]; ?></span><span> </span><span class="text-secondary"><?php echo implode(' ', array_slice(explode(' ', get_bloginfo('name')), 1)); ?></span>
                </a>
                <button id="close-menu-btn" class="p-2 bg-gray-50 dark:bg-gray-900 rounded-xl">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <nav class="flex flex-col divide-y divide-gray-50 dark:divide-gray-900">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-1',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'fallback_cb'    => false,
                        'walker'         => new Iran_News_Mobile_Walker_Nav_Menu(),
                    )
                );
                ?>
            </nav>

        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-20 lg:bottom-8 left-8 z-50 p-3 border border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-black/80 backdrop-blur-md text-gray-900 dark:text-white rounded-full shadow-sm opacity-0 translate-y-10 transition-all duration-300 hover:border-brand hover:text-brand cursor-pointer">
        <i data-lucide="arrow-up" class="w-5 h-5"></i>
    </button>

    <?php wp_footer(); ?>
</body>
</html>
