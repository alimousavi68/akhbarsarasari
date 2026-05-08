document.addEventListener("DOMContentLoaded", () => {
    // Accordion Logic for Comments
    const toggles = document.querySelectorAll('.accordion-toggle');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const targetId = toggle.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const icon = toggle.querySelector('[data-lucide="chevron-down"]');
            
            if (content) {
                const isHidden = content.classList.contains('hidden');
                
                // Toggle Content
                content.classList.toggle('hidden');
                
                // Rotate Icon
                if (icon) {
                    if (isHidden) {
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
                
                // Optional: Smooth transition if needed
                // For now, simple toggle is fine as per "compact" request
            }
        });
    });

    // Handle reply link click to open form if closed
    const replyLinks = document.querySelectorAll('.comment-reply-link');
    const formContent = document.getElementById('comment-form-content');
    const formToggle = document.querySelector('[data-target="comment-form-content"]');

    replyLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (formContent && formContent.classList.contains('hidden')) {
                formContent.classList.remove('hidden');
                const icon = formToggle.querySelector('[data-lucide="chevron-down"]');
                if (icon) icon.style.transform = 'rotate(180deg)';
            }
        });
    });
});
