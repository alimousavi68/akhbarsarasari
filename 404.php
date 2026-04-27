<?php
get_header();
?>

    <main class="py-20 lg:py-32">
        <div class="container-custom">
            <div class="max-w-2xl mx-auto text-center">
                <div class="mb-10">
                    <h1 class="text-8xl lg:text-9xl font-black text-gray-100 dark:text-gray-800 leading-none">404</h1>
                    <div class="relative -mt-12 lg:-mt-16">
                        <h2 class="text-2xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">صفحه مورد نظر یافت نشد!</h2>
                        <div class="w-16 h-1 bg-brand rounded-full mx-auto mb-8"></div>
                    </div>
                </div>

                <p class="text-gray-500 text-lg leading-relaxed mb-12">
                    متأسفانه صفحه‌ای که به دنبال آن بودید یافت نشد. ممکن است آدرس را اشتباه وارد کرده باشید یا صفحه حذف شده باشد.
                </p>

                <div class="bg-gray-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">جستجو در اخبار</h3>
                    <form role="search" method="get" class="flex items-center gap-2 bg-white dark:bg-black border border-gray-200 dark:border-gray-800 rounded-2xl p-2 focus-within:border-brand transition-all" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" placeholder="کلمه کلیدی را وارد کنید..." name="s"
                            class="flex-1 bg-transparent border-none outline-none px-4 py-2 text-gray-900 dark:text-white">
                        <button type="submit" class="bg-brand text-white p-3 rounded-xl hover:bg-brand/90 transition-all shadow-md shadow-brand/20">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>

                <div class="mt-12 flex flex-wrap items-center justify-center gap-4">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-2xl font-bold hover:bg-brand dark:hover:bg-brand dark:hover:text-white transition-all shadow-lg">
                        بازگشت به صفحه اصلی
                    </a>
                    <a href="javascript:history.back()" class="px-8 py-4 border border-gray-200 dark:border-gray-800 text-gray-600 dark:text-gray-400 rounded-2xl font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                        صفحه قبلی
                    </a>
                </div>
            </div>
        </div>
    </main>

<?php
get_footer();
?>
