<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class('antialiased'); ?>>
    <?php wp_body_open(); ?>
    <?php $iran_news_logo = iran_news_get_header_logo_data(); ?>

    <!-- Header -->
    <header class="bg-white dark:bg-black border-b border-gray-100 dark:border-gray-800 shadow-sm z-[100]">
        <!-- Desktop Header (Hidden on Mobile) -->
        <div class="hidden lg:block">
            <!-- Top Row: Logo & Info -->
            <div class="container-custom py-2 flex items-center justify-between">
                <!-- Right: Logo -->
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex flex-col items-start group" title="<?php echo esc_attr( $iran_news_logo['title'] ); ?>">
                    <div class="text-4xl font-medium tracking-tighter leading-none">
                        <?php if ( $iran_news_logo['logo_url'] ) : ?>
                            <img src="<?php echo esc_url( $iran_news_logo['logo_url'] ); ?>" alt="<?php echo esc_attr( $iran_news_logo['alt'] ); ?>" title="<?php echo esc_attr( $iran_news_logo['title'] ); ?>" class="h-14 w-auto" loading="eager">
                        <?php else : ?>
                            <span class="text-gray-900 dark:text-white"><?php echo esc_html( $iran_news_logo['site_name'] ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-[0.2em]">news and analytics
                    </div>
                </a>

                <!-- Left: Date, Time & Icons -->
                <div class="flex flex-col items-end gap-2">
                    <div id="persian-date-time"
                        class="text-[11px]  text-gray-500 flex flex-col items-end leading-tight">
                        <span id="current-date"></span>
                        <span id="current-time"></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="search-btn" class="text-gray-400 hover:text-brand transition-colors cursor-pointer"
                            aria-label="جستجو">
                            <i data-lucide="search" class="w-4 h-4" stroke-width="2"></i>
                        </button>
                        <a href="<?php echo esc_url( get_feed_link() ); ?>" class="text-gray-400 hover:text-brand transition-colors cursor-pointer"
                            aria-label="RSS" title="خوراک RSS سایت" rel="alternate" type="application/rss+xml">
                            <i data-lucide="rss" class="w-4 h-4" stroke-width="2"></i>
                        </a>
                        <button id="dark-mode-toggle"
                            class="text-gray-400 hover:text-brand transition-colors cursor-pointer"
                            aria-label="تغییر تم">
                            <i data-lucide="moon" class="w-4 h-4 dark:hidden" stroke-width="2"></i>
                            <i data-lucide="sun" class="w-4 h-4 hidden dark:block" stroke-width="2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Navigation Bar -->
            <div class="container-custom relative z-50 -mb-5">
                <div class="brand-nav-bar flex items-center">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                            'container'      => 'nav',
                            'container_class'=> 'flex items-center',
                            'items_wrap'     => '%3$s',
                            'fallback_cb'    => false,
                            'walker'         => new Iran_News_Walker_Nav_Menu(),
                        )
                    );
                    ?>
                </div>
            </div>
        </div>

        <!-- Mobile Header (Simple & Minimal) -->
        <div class="lg:hidden container-custom py-2 flex items-center justify-between">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex flex-col items-start" title="<?php echo esc_attr( $iran_news_logo['title'] ); ?>">
                <div class="text-2xl font-medium tracking-tighter leading-none">
                    <?php if ( $iran_news_logo['logo_url'] ) : ?>
                        <img src="<?php echo esc_url( $iran_news_logo['logo_url'] ); ?>" alt="<?php echo esc_attr( $iran_news_logo['alt'] ); ?>" title="<?php echo esc_attr( $iran_news_logo['title'] ); ?>" class="h-8 w-auto" loading="eager">
                    <?php else : ?>
                        <span class="text-gray-900 dark:text-white"><?php echo esc_html( $iran_news_logo['site_name'] ); ?></span>
                    <?php endif; ?>
                </div>
                <div class="text-[7px] font-bold text-gray-400 mt-0.5 uppercase tracking-[0.1em]">news and analytics
                </div>
            </a>
            <div class="flex items-center gap-3">
                <button id="search-btn-mobile" class="text-gray-400 hover:text-brand transition-colors cursor-pointer"
                    aria-label="جستجو">
                    <i data-lucide="search" class="w-6 h-6" stroke-width="1.5"></i>
                </button>
                <button id="dark-mode-toggle-mobile"
                    class="text-gray-400 hover:text-brand transition-colors cursor-pointer" aria-label="تغییر تم">
                    <i data-lucide="moon" class="w-6 h-6 dark:hidden" stroke-width="1.5"></i>
                    <i data-lucide="sun" class="w-6 h-6 hidden dark:block" stroke-width="1.5"></i>
                </button>
                <button id="mobile-menu-btn"
                    class="p-1 text-gray-400 hover:text-brand transition-colors cursor-pointer">
                    <i data-lucide="menu" class="w-6 h-6" stroke-width="1.5"></i>
                </button>
            </div>
        </div>

    </header>

    <!-- Spotlight Search Modal -->
    <div id="spotlight-search" class="spotlight-overlay">
        <div class="spotlight-content">
            <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center gap-4">
                <i data-lucide="search" class="w-6 h-6 text-brand"></i>
                <form role="search" method="get" class="flex-1 flex items-center" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" id="spotlight-input" placeholder="جستجو در بین اخبار..." name="s"
                        class="flex-1 bg-transparent border-none outline-none text-xl font-bold placeholder:text-gray-400">
                </form>
                <button id="close-spotlight"
                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                    <i data-lucide="x" class="w-6 h-6 text-gray-400"></i>
                </button>
            </div>
        </div>
    </div>
