/**
 * Infinite Scroll for Latest News Section
 * High-performance vanilla JavaScript using IntersectionObserver API
 */
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('latest-news-container');
    const sentinel = document.getElementById('latest-news-sentinel');
    const loader = document.getElementById('latest-news-loader');
    const endMsg = document.getElementById('latest-news-end');

    if (!container || !sentinel) return;

    let currentPage = parseInt(container.getAttribute('data-current-page') || '1', 10);
    let maxPages = parseInt(container.getAttribute('data-max-pages') || '1', 10);
    const category = parseInt(container.getAttribute('data-category') || '0', 10);
    let isLoading = false;

    // If there is only 1 page or none, show end message immediately and exit
    if (currentPage >= maxPages) {
        sentinel.classList.add('hidden');
        return;
    }

    async function loadMoreNews() {
        if (isLoading || currentPage >= maxPages) return;

        isLoading = true;
        if (loader) loader.classList.remove('hidden');

        const nextPage = currentPage + 1;
        const formData = new FormData();
        formData.append('action', 'iran_news_load_more');
        formData.append('nonce', (window.iranAjax && window.iranAjax.nonce) ? window.iranAjax.nonce : '');
        formData.append('page', nextPage);
        formData.append('category', category);

        try {
            const response = await fetch(window.iranAjax ? window.iranAjax.ajax_url : '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success && data.data && data.data.html) {
                // Parse and append new posts
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.data.html;

                while (tempDiv.firstChild) {
                    container.appendChild(tempDiv.firstChild);
                }

                currentPage = nextPage;
                container.setAttribute('data-current-page', currentPage);

                if (data.data.max_pages) {
                    maxPages = parseInt(data.data.max_pages, 10);
                    container.setAttribute('data-max-pages', maxPages);
                }

                // Re-initialize any Lucide icons if present
                if (window.lucide && typeof window.lucide.createIcons === 'function') {
                    window.lucide.createIcons();
                }

                // Check if all pages are loaded
                if (currentPage >= maxPages) {
                    observer.unobserve(sentinel);
                    if (loader) loader.classList.add('hidden');
                    if (endMsg) endMsg.classList.remove('hidden');
                }
            } else {
                // No more posts returned
                observer.unobserve(sentinel);
                if (loader) loader.classList.add('hidden');
                if (endMsg) endMsg.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error loading more news:', error);
        } finally {
            isLoading = false;
            if (loader && currentPage < maxPages) {
                loader.classList.add('hidden');
            }
        }
    }

    // Set up IntersectionObserver with threshold and rootMargin to preload smoothly
    const observerOptions = {
        root: null,
        rootMargin: '200px 0px', // Preload when 200px before reaching sentinel
        threshold: 0.1,
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !isLoading && currentPage < maxPages) {
                loadMoreNews();
            }
        });
    }, observerOptions);

    observer.observe(sentinel);
});
