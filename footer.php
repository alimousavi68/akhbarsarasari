    <!-- Footer -->
    <footer class="bg-[#1a1a1a] text-gray-400 pt-12 pb-24 lg:pb-12 border-t border-gray-800">
        <div class="container-custom">
            <div class="flex flex-col gap-10 lg:flex-row lg:items-start lg:justify-between">
               
                <div class="hidden lg:block max-w-[420px]  gap-2">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="block">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php bloginfo( 'name' ); ?>" class="h-16 w-auto">
                    </a>
                    <p class="text-sm text-gray-400 leading-loose">
                        <?php bloginfo( 'description' ); ?>
                    </p>
                </div>
                <?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-sidebar' ); ?>
                <?php else : ?>
                <div class="w-full lg:w-auto">
                    <h4 class="text-white text-lg font-medium mb-5 text-center lg:text-right">مجوزها</h4>
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/eresaneh.png" alt="مجوز رسانه" class="h-[85px] w-auto object-contain" width="100" height="85" loading="lazy">
                        </div>
                        <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/rezi.webp" alt="نماد اعتماد رسانه" class="h-[85px] w-auto object-contain" width="100" height="85" loading="lazy">
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="pt-8 mt-8 border-t border-gray-800 text-center text-xs text-gray-500">
                <p>طراحی و توسعه: <a href="#" class="text-brand hover:underline transition-all">هشت بهشت</a></p>
            </div>
        </div>
    </footer>

   
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
