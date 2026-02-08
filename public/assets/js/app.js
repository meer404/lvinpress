/**
 * LVINPress - Main JavaScript
 * Luxury News Platform v2.0 — Advanced Interactions
 */
(function() {
    'use strict';

    // ============================================
    // TOAST NOTIFICATION SYSTEM
    // ============================================
    const toastContainer = document.createElement('div');
    toastContainer.style.cssText = 'position:fixed;bottom:2rem;left:50%;transform:translateX(-50%);z-index:99999;display:flex;flex-direction:column;gap:0.5rem;align-items:center;pointer-events:none;';
    document.body.appendChild(toastContainer);
    
    window.showToast = function(message, type = 'success', duration = 3000) {
        const toast = document.createElement('div');
        const icons = { success: 'fa-check-circle', error: 'fa-exclamation-circle', info: 'fa-info-circle', warning: 'fa-exclamation-triangle' };
        const colors = { success: '#22c55e', error: '#ef4444', info: '#3b82f6', warning: '#f59e0b' };
        toast.innerHTML = `<i class="fas ${icons[type] || icons.info}" style="color:${colors[type]}"></i> ${message}`;
        toast.style.cssText = `background:var(--bg-card, #1a1a2e);color:var(--text-primary, #fff);padding:0.75rem 1.5rem;border-radius:12px;font-size:0.875rem;box-shadow:0 10px 40px rgba(0,0,0,0.2);display:flex;align-items:center;gap:0.5rem;pointer-events:auto;border:1px solid ${colors[type]}33;opacity:0;transform:translateY(20px);transition:all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);backdrop-filter:blur(20px);`;
        toastContainer.appendChild(toast);
        requestAnimationFrame(() => { toast.style.opacity = '1'; toast.style.transform = 'translateY(0)'; });
        setTimeout(() => {
            toast.style.opacity = '0'; toast.style.transform = 'translateY(10px)';
            setTimeout(() => toast.remove(), 400);
        }, duration);
    };

    // ============================================
    // THEME TOGGLE (Dark/Light) - Enhanced
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
            if (i) {
                i.style.transform = 'rotate(180deg) scale(0)';
                setTimeout(() => {
                    i.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                    i.style.transform = 'rotate(0) scale(1)';
                }, 150);
            }
        });
    }

    // ============================================
    // MOBILE MENU - Handled inline in footer.php
    // ============================================

    // ============================================
    // SEARCH OVERLAY - Keyboard shortcuts
    // Open/close handled inline in footer.php
    // ============================================
    const searchOverlay = document.getElementById('searchOverlay');
    const searchInput = document.getElementById('searchInput');

    // ============================================
    // STICKY HEADER - Handled inline in footer.php
    // ============================================

    // ============================================
    // BACK TO TOP - Handled inline in footer.php
    // ============================================

    // ============================================
    // NEWSLETTER SUBSCRIBE - Enhanced feedback
    // ============================================
    window.subscribeNewsletter = async function(e) {
        e.preventDefault();
        const form = e.target;
        const email = form.querySelector('input[name="email"]').value;
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> ...';
        btn.disabled = true;
        btn.style.opacity = '0.7';
        
        try {
            const res = await fetch(APP_BASE + '/api/newsletter/subscribe', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            });
            const data = await res.json();
            
            if (data.success) {
                btn.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
                btn.style.background = 'linear-gradient(135deg, #22c55e, #16a34a)';
                btn.style.opacity = '1';
                form.querySelector('input[name="email"]').value = '';
                showToast('Successfully subscribed!', 'success');
                setTimeout(() => { btn.innerHTML = originalText; btn.style.background = ''; btn.disabled = false; }, 3000);
            } else {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.style.opacity = '1';
                showToast(data.message || 'Subscription failed', 'error');
            }
        } catch(err) {
            btn.innerHTML = originalText;
            btn.disabled = false;
            btn.style.opacity = '1';
            showToast('Connection error. Please try again.', 'error');
        }
        return false;
    };

    // ============================================
    // COMMENT SUBMISSION - Enhanced feedback
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
                if (msgEl) {
                    msgEl.textContent = result.message || 'Comment submitted!';
                    msgEl.className = 'flash-message flash-success';
                    msgEl.style.display = 'block';
                }
                form.reset();
                showToast(result.message || 'Comment submitted!', 'success');
                setTimeout(() => { if (msgEl) msgEl.style.display = 'none'; }, 5000);
            } else {
                if (msgEl) {
                    msgEl.textContent = result.message || 'Error';
                    msgEl.className = 'flash-message flash-error';
                    msgEl.style.display = 'block';
                }
                showToast(result.message || 'Error submitting comment', 'error');
            }
        } catch(err) {
            showToast('Connection error', 'error');
        }
        return false;
    };

    // ============================================
    // BOOKMARK TOGGLE - Enhanced with toast
    // ============================================
    window.toggleBookmark = async function(articleId) {
        const btn = document.getElementById('bookmarkBtn');
        if (!btn) return;
        btn.style.pointerEvents = 'none';
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
                btn.style.transform = 'scale(1.3)';
                setTimeout(() => btn.style.transform = 'scale(1)', 300);
                showToast(data.bookmarked ? 'Article bookmarked!' : 'Bookmark removed', 'success');
            }
        } catch(err) {
            showToast('Failed to update bookmark', 'error');
        } finally {
            btn.style.pointerEvents = '';
        }
    };

    // ============================================
    // POLL VOTING - Enhanced with toast
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
                showToast('Vote submitted!', 'success');
                setTimeout(() => window.location.reload(), 800);
            } else {
                showToast(data.message || 'Already voted', 'info');
            }
        } catch(err) {
            showToast('Failed to submit vote', 'error');
        }
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
    // READING PROGRESS BAR (Article Page) - Enhanced
    // ============================================
    const articleContent = document.querySelector('.article-body') || document.querySelector('.article-page__content');
    if (articleContent) {
        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress';
        document.body.appendChild(progressBar);
        
        let progressTicking = false;
        window.addEventListener('scroll', () => {
            if (!progressTicking) {
                window.requestAnimationFrame(() => {
                    const rect = articleContent.getBoundingClientRect();
                    const total = articleContent.offsetHeight;
                    const progress = Math.min(100, Math.max(0, (-rect.top / (total - window.innerHeight)) * 100));
                    progressBar.style.width = progress + '%';
                    progressTicking = false;
                });
                progressTicking = true;
            }
        }, { passive: true });
    }

    // ============================================
    // FOCUS MODE - Handled by global keyboard shortcuts below
    // ============================================

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
                            `<a href="${a.url}" class="block px-4 py-2.5 text-sm hover:bg-stone-100 dark:hover:bg-white/10 transition truncate">${a.title}</a>`
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
    // COPY TO CLIPBOARD - Enhanced with toast
    // ============================================
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Copied to clipboard!', 'success');
        }).catch(() => {
            showToast('Failed to copy', 'error');
        });
    };

    window.copyArticleLink = function() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            showToast('Link copied to clipboard!', 'success');
        }).catch(() => {
            showToast('Failed to copy link', 'error');
        });
    };

    // ============================================
    // ANIMATE ON SCROLL - Advanced with variants
    // ============================================
    if ('IntersectionObserver' in window) {
        const animObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    // Use element's own stagger delay or CSS variable --delay
                    const delay = parseInt(el.style.getPropertyValue('--delay') || '0', 10);
                    setTimeout(() => {
                        el.classList.add('animated');
                    }, delay);
                    animObserver.unobserve(el);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('[data-animate]').forEach(el => {
            animObserver.observe(el);
        });
    }

    // ============================================
    // SPOTLIGHT CARD - Mouse tracking effect
    // ============================================
    document.querySelectorAll('.spotlight-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--mouse-x', (e.clientX - rect.left) + 'px');
            card.style.setProperty('--mouse-y', (e.clientY - rect.top) + 'px');
        });
    });

    // ============================================
    // MAGNETIC BUTTON EFFECT
    // ============================================
    document.querySelectorAll('.magnetic-btn').forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = (e.clientX - rect.left - rect.width / 2) * 0.15;
            const y = (e.clientY - rect.top - rect.height / 2) * 0.15;
            btn.style.transform = `translate(${x}px, ${y}px)`;
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = '';
        });
    });

    // ============================================
    // COPY CODE BUTTON for article <pre> blocks
    // ============================================
    document.querySelectorAll('.article-body pre').forEach(pre => {
        const wrapper = document.createElement('div');
        wrapper.style.position = 'relative';
        pre.parentNode.insertBefore(wrapper, pre);
        wrapper.appendChild(pre);

        const copyBtn = document.createElement('button');
        copyBtn.innerHTML = '<i class="fas fa-copy"></i>';
        copyBtn.style.cssText = 'position:absolute;top:8px;right:8px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.1);color:#fff;padding:6px 10px;border-radius:8px;cursor:pointer;font-size:12px;opacity:0;transition:opacity 0.2s;z-index:2;';
        wrapper.appendChild(copyBtn);

        wrapper.addEventListener('mouseenter', () => { copyBtn.style.opacity = '1'; });
        wrapper.addEventListener('mouseleave', () => { copyBtn.style.opacity = '0'; });

        copyBtn.addEventListener('click', () => {
            const code = pre.querySelector('code') || pre;
            navigator.clipboard.writeText(code.textContent).then(() => {
                copyBtn.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(() => { copyBtn.innerHTML = '<i class="fas fa-copy"></i>'; }, 2000);
                if (typeof showToast === 'function') showToast('Code copied!', 'success');
            });
        });
    });

    // ============================================
    // COUNTER ANIMATION for data-count elements
    // ============================================
    if ('IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-count'), 10);
                    if (isNaN(target)) return;
                    const duration = 1500;
                    const start = performance.now();
                    const step = (now) => {
                        const progress = Math.min((now - start) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
                        el.textContent = Math.floor(eased * target).toLocaleString();
                        if (progress < 1) requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.3 });
        document.querySelectorAll('[data-count]').forEach(el => counterObserver.observe(el));
    }

    // ============================================
    // KEYBOARD SHORTCUTS - Global
    // ============================================
    document.addEventListener('keydown', (e) => {
        // Skip when typing in inputs
        const tag = document.activeElement?.tagName;
        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(tag)) return;

        // Escape — close overlays
        if (e.key === 'Escape') {
            if (searchOverlay && typeof closeSearch === 'function') closeSearch();
            // Close shortcuts panel if open
            const sp = document.getElementById('shortcutsPanel');
            if (sp && !sp.classList.contains('hidden')) sp.classList.add('hidden');
        }

        // Ctrl/Cmd+K — Command palette / search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (typeof openSearch === 'function') openSearch();
        }

        // ? — Toggle shortcuts panel
        if (e.key === '?' && !e.ctrlKey && !e.metaKey) {
            const sp = document.getElementById('shortcutsPanel');
            if (sp) sp.classList.toggle('hidden');
        }

        // D — Toggle dark mode
        if (e.key === 'd' || e.key === 'D') {
            if (!e.ctrlKey && !e.metaKey && !e.altKey) {
                const tt = document.getElementById('themeToggle');
                if (tt) tt.click();
            }
        }

        // F — Toggle focus mode (article pages)
        if (e.key === 'f' && !e.ctrlKey && !e.metaKey && !e.altKey) {
            if (document.querySelector('.article-body')) {
                document.body.classList.toggle('focus-mode');
            }
        }
    });

    // Add CSS for animated elements and focus mode
    const style = document.createElement('style');
    style.textContent = `
        .focus-mode #siteHeader, .focus-mode footer, .focus-mode aside,
        .focus-mode [data-ticker], .focus-mode [data-share], .focus-mode [data-author-bio],
        .focus-mode [data-comments], .focus-mode [data-meta], .focus-mode [data-newsletter],
        .focus-mode nav[aria-label="breadcrumb"] { display: none !important; }
        .focus-mode .article-body { font-size: 1.15rem; line-height: 2; }
        .theme-toggle i { transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94); display: inline-block; }
        @media (prefers-reduced-motion: reduce) { [data-animate] { opacity: 1 !important; transform: none !important; transition: none !important; } }`;
    document.head.appendChild(style);

})();
