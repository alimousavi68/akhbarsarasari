/**
 * Infinite Scroll for Latest News Section
 * Supports both pure Infinite Scroll and Hybrid (Auto-scroll until N pages, then Load More button)
 */
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('latest-news-container');
    const sentinel = document.getElementById('latest-news-sentinel');
    const loader = document.getElementById('latest-news-loader');
    const loadMoreBtn = document.getElementById('latest-news-load-more-btn');
    const endMsg = document.getElementById('latest-news-end');

    if (!container || !sentinel) return;

    let currentPage = parseInt(container.getAttribute('data-current-page') || '1', 10);
    let maxPages = parseInt(container.getAttribute('data-max-pages') || '1', 10);
    const category = parseInt(container.getAttribute('data-category') || '0', 10);
    const scrollMode = container.getAttribute('data-scroll-mode') || 'button_after_n';
    const autoPages = parseInt(container.getAttribute('data-auto-pages') || '3', 10);
    let isLoading = false;
    let observer = null;

    // Helper: update UI states
    function showLoader() {
        if (loadMoreBtn) loadMoreBtn.classList.add('hidden');
        if (loader) loader.classList.remove('hidden');
    }

    function hideLoader() {
        if (loader) loader.classList.add('hidden');
    }

    function showButton() {
        hideLoader();
        if (loadMoreBtn && currentPage < maxPages) {
            loadMoreBtn.classList.remove('hidden');
        }
    }

    function showEnd() {
        hideLoader();
        if (loadMoreBtn) loadMoreBtn.classList.add('hidden');
        if (endMsg) endMsg.classList.remove('hidden');
        if (observer) observer.disconnect();
    }

    // Check if only 1 page or none exists
    if (currentPage >= maxPages) {
        sentinel.classList.add('hidden');
        return;
    }

    async function loadMoreNews() {
        if (isLoading || currentPage >= maxPages) return;

        isLoading = true;
        showLoader();

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

                // Re-initialize Lucide icons
                if (window.lucide && typeof window.lucide.createIcons === 'function') {
                    window.lucide.createIcons();
                }

                // Decide next step based on state
                if (currentPage >= maxPages) {
                    showEnd();
                } else if (scrollMode === 'button_after_n' && currentPage >= autoPages) {
                    if (observer) observer.unobserve(sentinel);
                    showButton();
                } else {
                    hideLoader();
                }
            } else {
                showEnd();
            }
        } catch (error) {
            console.error('Error loading more news:', error);
            hideLoader();
            if (scrollMode === 'button_after_n' && currentPage >= autoPages) {
                showButton();
            }
        } finally {
            isLoading = false;
        }
    }

    // Setup Click listener on Load More button
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            if (!isLoading) {
                loadMoreNews();
            }
        });
    }

    // Setup IntersectionObserver for auto-scroll
    const shouldObserve = (scrollMode === 'infinite') || (scrollMode === 'button_after_n' && currentPage < autoPages);

    if (shouldObserve) {
        const observerOptions = {
            root: null,
            rootMargin: '250px 0px',
            threshold: 0.1,
        };

        observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && !isLoading && currentPage < maxPages) {
                    if (scrollMode === 'button_after_n' && currentPage >= autoPages) {
                        observer.unobserve(sentinel);
                        showButton();
                    } else {
                        loadMoreNews();
                    }
                }
            });
        }, observerOptions);

        observer.observe(sentinel);
    } else if (scrollMode === 'button_after_n' && currentPage >= autoPages && currentPage < maxPages) {
        showButton();
    }
});
