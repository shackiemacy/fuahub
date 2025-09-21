// Modern JavaScript for Fua Hub

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('show');
            
            // Change hamburger to X
            const icon = this.querySelector('i');
            if (navMenu.classList.contains('show')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }
    
    // Modal functionality
    const modals = {
        signup: {
            modal: document.getElementById('signupModal'),
            openBtn: document.querySelector('a[href="signup.html"]'),
            closeBtn: document.getElementById('signupClose')
        },
        login: {
            modal: document.getElementById('loginModal'),
            openBtn: document.querySelector('a[href="login.html"]'),
            closeBtn: document.getElementById('loginClose')
        }
    };
    
    // Set up modal event listeners
    Object.keys(modals).forEach(modalName => {
        const modalObj = modals[modalName];
        
        if (modalObj.openBtn && modalObj.modal) {
            modalObj.openBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal(modalObj.modal);
            });
        }
        
        if (modalObj.closeBtn) {
            modalObj.closeBtn.addEventListener('click', function() {
                closeModal(modalObj.modal);
            });
        }
        
        if (modalObj.modal) {
            modalObj.modal.addEventListener('click', function(e) {
                if (e.target === modalObj.modal) {
                    closeModal(modalObj.modal);
                }
            });
        }
    });
    
    // Role selection in signup modal
    const clientBtn = document.getElementById('clientBtn');
    const providerBtn = document.getElementById('providerBtn');
    
    if (clientBtn) {
        clientBtn.addEventListener('click', function() {
            localStorage.setItem('selectedRole', 'client');
            window.location.href = 'signup.html?role=client';
        });
    }
    
    if (providerBtn) {
        providerBtn.addEventListener('click', function() {
            localStorage.setItem('selectedRole', 'provider');
            window.location.href = 'signup.html?role=provider';
        });
    }
    
    // Login form handling
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const email = this.querySelector('input[type="email"]').value;
            const password = this.querySelector('input[type="password"]').value;
            
            // Basic validation
            if (!email || !password) {
                showNotification('Please fill in all fields', 'error');
                return;
            }
            
            // For now, redirect to login.html for actual processing
            window.location.href = 'login.html';
        });
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add scroll effect to header
    let lastScrollTop = 0;
    const header = document.querySelector('.header');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down
            header.style.transform = 'translateY(-100%)';
        } else {
            // Scrolling up
            header.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });
    
    // Fade in animation for cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all cards
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});

// Helper functions
function openModal(modal) {
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modal) {
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span>${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Add to DOM
    document.body.appendChild(notification);
    
    // Style the notification
    Object.assign(notification.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        background: type === 'error' ? 'var(--danger-color)' : 'var(--success-color)',
        color: 'white',
        padding: '1rem',
        borderRadius: 'var(--radius-md)',
        boxShadow: 'var(--shadow-lg)',
        zIndex: '3000',
        transform: 'translateX(100%)',
        transition: 'transform 0.3s ease',
        maxWidth: '300px'
    });
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Close button
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Form validation helper
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    return password.length >= 8;
}

// Loading state helper
function setLoading(element, isLoading) {
    if (isLoading) {
        element.disabled = true;
        element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    } else {
        element.disabled = false;
        element.innerHTML = element.dataset.originalText || 'Submit';
    }
}
