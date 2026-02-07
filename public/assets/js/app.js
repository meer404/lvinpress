/**
 * LVINPress - Main JavaScript
 * Luxury News Platform
 */
(function() {
    'use strict';

    // ============================================
    // THEME TOGGLE (Dark/Light)
    // ============================================
    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    if (themeToggle) {
        const icon = themeToggle.querySelector('i');
        if (icon) icon.className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        
        themeToggle.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            document.cookie = 'theme=' + next + ';path=/;max-age=31536000';
            localStorage.setItem('theme', next);
            const i = themeToggle.querySelector('i');
            if (i) i.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        });
    }

    // ============================================
    // MOBILE MENU
    // ============================================
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mainNav');
    
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            mobileToggle.classList.toggle('active');
        });
    }

    // ============================================
    // SEARCH OVERLAY
    // ============================================
    const searchToggle = document.getElementById('searchToggle');
    const searchOverlay = document.getElementById('searchOverlay');
    const searchClose = document.getElementById('searchClose');
    const searchInput = document.getElementById('searchInput');
    
    if (searchToggle && searchOverlay) {
        searchToggle.addEventListener('click', (e) => {
            e.preventDefault();
            searchOverlay.classList.add('active');
            setTimeout(() => searchInput?.focus(), 300);
        });
        
        if (searchClose) {
            searchClose.addEventListener('click', () => searchOverlay.classList.remove('active'));
        }
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') searchOverlay.classList.remove('active');
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchOverlay.classList.add('active');
                setTimeout(() => searchInput?.focus(), 300);
            }
        });
    }

    // ============================================
    // STICKY HEADER
    // ============================================
    const header = document.querySelector('.header');
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            if (currentScroll > 100) {
                header.classList.add('scrolled');
                if (currentScroll > lastScroll && currentScroll > 300) {
                    header.style.transform = 'translateY(-100%)';
                } else {
                    header.style.transform = 'translateY(0)';
                }
            } else {
                header.classList.remove('scrolled');
                header.style.transform = 'translateY(0)';
            }
            lastScroll = currentScroll;
        }, { passive: true });
    }

    // ============================================
    // BACK TO TOP
    // ============================================
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('visible', window.pageYOffset > 400);
        }, { passive: true });
        
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ============================================
    // NEWSLETTER SUBSCRIBE
    // ============================================
    window.subscribeNewsletter = async function(e) {
        e.preventDefault();
        const form = e.target;
        const email = form.querySelector('input[name="email"]').value;
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;
        
        try {
            const res = await fetch(APP_BASE + '/api/newsletter/subscribe', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            });
            const data = await res.json();
            
            if (data.success) {
                btn.innerHTML = '<i class="fas fa-check"></i> ✓';
                btn.style.background = '#2ecc71';
                form.querySelector('input[name="email"]').value = '';
                setTimeout(() => { btn.innerHTML = originalText; btn.style.background = ''; btn.disabled = false; }, 3000);
            } else {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert(data.message || 'Error');
            }
        } catch(err) {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
        return false;
    };

    // ============================================
    // COMMENT SUBMISSION
    // ============================================
    window.submitComment = async function(e) {
        e.preventDefault();
        const form = document.getElementById('commentForm');
        const msgEl = document.getElementById('commentMessage');
        const formData = new FormData(form);
        const data = {};
        formData.forEach((v, k) => data[k] = v);
        
        try {
            const res = await fetch(APP_BASE + '/api/comment', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await res.json();
            
            if (result.success) {
                msgEl.textContent = result.message || 'Comment submitted!';
                msgEl.className = 'flash-message flash-success';
                msgEl.style.display = 'block';
                form.reset();
                setTimeout(() => msgEl.style.display = 'none', 5000);
            } else {
                msgEl.textContent = result.message || 'Error';
                msgEl.className = 'flash-message flash-error';
                msgEl.style.display = 'block';
            }
        } catch(err) {
            msgEl.textContent = 'Connection error';
            msgEl.className = 'flash-message flash-error';
            msgEl.style.display = 'block';
        }
        return false;
    };

    // ============================================
    // BOOKMARK TOGGLE
    // ============================================
    window.toggleBookmark = async function(articleId) {
        const btn = document.getElementById('bookmarkBtn');
        try {
            const res = await fetch(APP_BASE + '/api/bookmark', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ article_id: articleId })
            });
            const data = await res.json();
            if (data.success) {
                const icon = btn.querySelector('i');
                icon.className = data.bookmarked ? 'fas fa-bookmark' : 'far fa-bookmark';
            }
        } catch(err) {}
    };

    // ============================================
    // POLL VOTING
    // ============================================
    window.votePoll = async function(pollId, optionIndex) {
        try {
            const res = await fetch(APP_BASE + '/api/poll/vote', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ poll_id: pollId, option: optionIndex })
            });
            const data = await res.json();
            
            if (data.success) {
                // Reload page to show results
                window.location.reload();
            } else {
                alert(data.message || 'Already voted');
            }
        } catch(err) {}
    };

    // ============================================
    // LAZY LOADING IMAGES
    // ============================================
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        }, { rootMargin: '100px' });
        
        document.querySelectorAll('img[data-src], img[loading="lazy"]').forEach(img => imageObserver.observe(img));
    }

    // ============================================
    // READING PROGRESS BAR (Article Page)
    // ============================================
    const articleContent = document.querySelector('.article-page__content');
    if (articleContent) {
        const progressBar = document.createElement('div');
        progressBar.style.cssText = 'position:fixed;top:0;left:0;height:3px;background:var(--gold);z-index:9999;transition:width 0.1s;width:0%;';
        document.body.appendChild(progressBar);
        
        window.addEventListener('scroll', () => {
            const rect = articleContent.getBoundingClientRect();
            const total = articleContent.offsetHeight;
            const progress = Math.min(100, Math.max(0, (-rect.top / (total - window.innerHeight)) * 100));
            progressBar.style.width = progress + '%';
        }, { passive: true });
    }

    // ============================================
    // FOCUS MODE (Article Page)
    // ============================================
    document.addEventListener('keydown', (e) => {
        if (e.key === 'f' && !e.ctrlKey && !e.metaKey && !e.altKey && 
            !['INPUT','TEXTAREA','SELECT'].includes(document.activeElement?.tagName)) {
            document.body.classList.toggle('focus-mode');
        }
    });

    // ============================================
    // FLASH MESSAGES AUTO-DISMISS
    // ============================================
    document.querySelectorAll('.flash-message').forEach(msg => {
        setTimeout(() => {
            msg.style.opacity = '0';
            msg.style.transform = 'translateY(-10px)';
            setTimeout(() => msg.remove(), 300);
        }, 5000);
    });

    // ============================================
    // SMOOTH SCROLL FOR ANCHORS
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const target = document.querySelector(anchor.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ============================================
    // LIVE SEARCH SUGGESTIONS
    // ============================================
    let searchTimeout;
    const searchSuggestions = document.getElementById('searchSuggestions');
    
    if (searchInput && searchSuggestions) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const q = this.value.trim();
            if (q.length < 2) { searchSuggestions.innerHTML = ''; return; }
            
            searchTimeout = setTimeout(async () => {
                try {
                    const res = await fetch(APP_BASE + '/api/articles/search?q=' + encodeURIComponent(q));
                    const data = await res.json();
                    if (data.articles?.length) {
                        searchSuggestions.innerHTML = data.articles.map(a => 
                            `<a href="${a.url}" class="search-suggestion">${a.title}</a>`
                        ).join('');
                    } else {
                        searchSuggestions.innerHTML = '<p class="text-muted text-center" style="padding:1rem;">No results</p>';
                    }
                } catch(e) {}
            }, 300);
        });
    }

    // ============================================
    // APP_BASE for API calls
    // ============================================
    const scripts = document.querySelectorAll('script[src]');
    let base = '';
    scripts.forEach(s => {
        if (s.src.includes('/assets/js/app.js')) {
            base = s.src.split('/assets/js/app.js')[0].replace('/public', '');
        }
    });
    window.APP_BASE = base || window.location.origin + '/vinnew';

    // ============================================
    // PRINT ARTICLE
    // ============================================
    window.printArticle = function() {
        window.print();
    };

    // ============================================
    // COPY TO CLIPBOARD
    // ============================================
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Show brief notification
            const toast = document.createElement('div');
            toast.textContent = 'Copied!';
            toast.style.cssText = 'position:fixed;bottom:2rem;left:50%;transform:translateX(-50%);background:var(--gold);color:#1a1a2e;padding:0.5rem 1.5rem;border-radius:var(--radius-full);font-size:0.875rem;z-index:9999;animation:fadeIn 0.3s ease;';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        });
    };

    // ============================================
    // ANIMATE ON SCROLL
    // ============================================
    if ('IntersectionObserver' in window) {
        const animObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    animObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.article-card, .sidebar__widget, .section-header').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            animObserver.observe(el);
        });
    }

    // Add CSS for animated elements
    const style = document.createElement('style');
    style.textContent = `.animate-in { opacity: 1 !important; transform: translateY(0) !important; }
        .focus-mode .header, .focus-mode .footer, .focus-mode .sidebar, 
        .focus-mode .ticker, .focus-mode .share-buttons, .focus-mode .author-bio,
        .focus-mode .comments, .focus-mode .article-page__meta { display: none !important; }
        .focus-mode .content-layout { grid-template-columns: 1fr !important; max-width: 750px !important; margin: 0 auto !important; }
        .focus-mode .article-page__content { font-size: 1.2rem; line-height: 2; }`;
    document.head.appendChild(style);

})();
