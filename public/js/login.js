class LoginForm2 {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.submitBtn = this.form.querySelector('.login-btn');
        this.passwordToggle = document.getElementById('passwordToggle');
        this.passwordInput = document.getElementById('password');
        this.successMessage = document.getElementById('successMessage');
        this.isSubmitting = false;
        
        this.validators = {
            email: FormUtils.validateEmail,
            password: FormUtils.validatePassword
        };
        
        this.init();
    }
    
    init() {
        this.addEventListeners();
        this.setupFloatingLabels();
        this.addInputAnimations();
        this.setupPasswordToggle();
        this.setupSocialButtons();
        this.addBackgroundEffects();
        FormUtils.addSharedAnimations();
    }
    
    addEventListeners() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        Object.keys(this.validators).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                field.addEventListener('blur', () => this.validateField(fieldName));
                field.addEventListener('input', () => this.clearError(fieldName));
            }
        });
        
        // Enhanced focus effects
        const inputs = this.form.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', (e) => this.handleFocus(e));
            input.addEventListener('blur', (e) => this.handleBlur(e));
        });
        
        const checkbox = document.getElementById('remember');
        if (checkbox) {
            checkbox.addEventListener('change', () => this.animateCheckbox());
        }
        
        const forgotLink = document.querySelector('.forgot-password');
        if (forgotLink) {
            forgotLink.addEventListener('click', (e) => this.handleForgotPassword(e));
        }
        
        const signupLink = document.querySelector('.signup-link a');
        if (signupLink) {
            signupLink.addEventListener('click', (e) => this.handleSignupLink(e));
        }
        
        this.setupKeyboardShortcuts();
    }
    
    setupFloatingLabels() {
        const inputs = this.form.querySelectorAll('input');
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                input.classList.add('has-value');
            }
            
            input.addEventListener('input', () => {
                if (input.value.trim() !== '') {
                    input.classList.add('has-value');
                } else {
                    input.classList.remove('has-value');
                }
            });
        });
    }
    
    addInputAnimations() {
        const inputs = this.form.querySelectorAll('input');
        inputs.forEach((input, index) => {
            input.style.opacity = '0';
            input.style.transform = 'translateX(-20px)';
            setTimeout(() => {
                input.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                input.style.opacity = '1';
                input.style.transform = 'translateX(0)';
            }, index * 200);
        });
    }
    
    setupPasswordToggle() {
        if (this.passwordToggle && this.passwordInput) {
            this.passwordToggle.addEventListener('click', () => {
                const isPassword = this.passwordInput.type === 'password';
                const toggleIcon = this.passwordToggle.querySelector('.toggle-icon');
                
                this.passwordInput.type = isPassword ? 'text' : 'password';
                toggleIcon.classList.toggle('show-password', isPassword);
                
                this.passwordToggle.style.boxShadow = '0 0 15px rgba(0, 255, 136, 0.5)';
                setTimeout(() => {
                    this.passwordToggle.style.boxShadow = '';
                }, 300);
                
                this.passwordInput.focus();
            });
        }
    }
    
    setupSocialButtons() {
        const socialButtons = document.querySelectorAll('.social-btn');
        socialButtons.forEach(btn => {
            btn.addEventListener('click', (e) => this.handleSocialLogin(e));
            
            // Add hover glow effect
            btn.addEventListener('mouseenter', () => {
                btn.style.boxShadow = '0 4px 20px rgba(0, 255, 136, 0.2)';
            });
            
            btn.addEventListener('mouseleave', () => {
                btn.style.boxShadow = '';
            });
        });
    }
    
    addBackgroundEffects() {
        document.addEventListener('mousemove', (e) => {
            const orbs = document.querySelectorAll('.glow-orb');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            orbs.forEach((orb, index) => {
                const speed = (index + 1) * 0.5;
                const moveX = (x - 0.5) * speed * 20;
                const moveY = (y - 0.5) * speed * 20;
                orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });
    }
    
    handleFocus(e) {
        const wrapper = e.target.closest('.input-wrapper');
        if (wrapper) {
            wrapper.classList.add('focused');
            const input = wrapper.querySelector('input');
            input.style.boxShadow = '0 0 20px rgba(0, 255, 136, 0.1)';
        }
    }
    
    handleBlur(e) {
        const wrapper = e.target.closest('.input-wrapper');
        if (wrapper) {
            wrapper.classList.remove('focused');
            const input = wrapper.querySelector('input');
            input.style.boxShadow = '';
        }
    }
    
    animateCheckbox() {
        const checkbox = document.querySelector('.custom-checkbox');
        if (checkbox) {
            checkbox.style.transform = 'scale(0.8)';
            checkbox.style.boxShadow = '0 0 15px rgba(0, 255, 136, 0.5)';
            setTimeout(() => {
                checkbox.style.transform = 'scale(1)';
                setTimeout(() => {
                    checkbox.style.boxShadow = '';
                }, 200);
            }, 150);
        }
    }
    
    handleForgotPassword(e) {
        e.preventDefault();
        const link = e.target;
        link.style.textShadow = '0 0 10px rgba(0, 255, 136, 0.8)';
        link.style.transform = 'scale(0.98)';
        setTimeout(() => {
            link.style.transform = 'scale(1)';
            setTimeout(() => {
                link.style.textShadow = '';
            }, 200);
        }, 150);
        
        FormUtils.showNotification('Password reset link would be sent to your email', 'info', this.form);
    }
    
    handleSignupLink(e) {
        e.preventDefault();
        const link = e.target;
        link.style.textShadow = '0 0 10px rgba(0, 153, 255, 0.8)';
        link.style.transform = 'scale(0.98)';
        setTimeout(() => {
            link.style.transform = 'scale(1)';
            setTimeout(() => {
                link.style.textShadow = '';
            }, 200);
        }, 150);
        
        FormUtils.showNotification('Redirecting to sign up page...', 'info', this.form);
    }
    
    handleSocialLogin(e) {
        const btn = e.currentTarget;
        const isGoogle = btn.classList.contains('google-btn');
        const provider = isGoogle ? 'Google' : 'Apple';
        
        btn.style.transform = 'scale(0.98)';
        btn.style.boxShadow = '0 0 25px rgba(0, 255, 136, 0.4)';
        btn.style.borderColor = 'var(--neon-primary)';
        
        setTimeout(() => {
            btn.style.transform = 'scale(1)';
            setTimeout(() => {
                btn.style.boxShadow = '';
                btn.style.borderColor = '';
            }, 300);
        }, 200);
        
        FormUtils.showNotification(`Connecting to ${provider}...`, 'info', this.form);
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        
        if (this.isSubmitting) return;
        
        const isValid = this.validateForm();
        
        if (isValid) {
            await this.submitForm();
        } else {
            this.shakeForm();
        }
    }
    
    validateForm() {
        let isValid = true;
        
        Object.keys(this.validators).forEach(fieldName => {
            if (!this.validateField(fieldName)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    validateField(fieldName) {
        const field = document.getElementById(fieldName);
        const validator = this.validators[fieldName];
        
        if (!field || !validator) return true;
        
        const result = validator(field.value.trim(), field);
        
        if (result.isValid) {
            this.clearError(fieldName);
            this.showSuccess(fieldName);
        } else {
            this.showError(fieldName, result.message);
        }
        
        return result.isValid;
    }
    
    showError(fieldName, message) {
        const formGroup = document.getElementById(fieldName).closest('.form-group');
        const errorElement = document.getElementById(fieldName + 'Error');
        
        formGroup.classList.add('error');
        errorElement.textContent = message;
        errorElement.classList.add('show');
        
        const field = document.getElementById(fieldName);
        field.style.animation = 'shake 0.5s ease-in-out';
        field.style.boxShadow = '0 0 15px rgba(255, 0, 128, 0.5)';
        setTimeout(() => {
            field.style.animation = '';
            field.style.boxShadow = '';
        }, 500);
    }
    
    clearError(fieldName) {
        const formGroup = document.getElementById(fieldName).closest('.form-group');
        const errorElement = document.getElementById(fieldName + 'Error');
        
        formGroup.classList.remove('error');
        errorElement.classList.remove('show');
        setTimeout(() => {
            errorElement.textContent = '';
        }, 300);
    }
    
    showSuccess(fieldName) {
        const field = document.getElementById(fieldName);
        const wrapper = field.closest('.input-wrapper');
        
        wrapper.style.borderColor = 'var(--neon-primary)';
        field.style.boxShadow = '0 0 10px rgba(0, 255, 136, 0.3)';
        setTimeout(() => {
            wrapper.style.borderColor = '';
            field.style.boxShadow = '';
        }, 2000);
    }
    
    shakeForm() {
        const card = document.querySelector('.login-card');
        card.style.animation = 'shake 0.5s ease-in-out';
        card.style.boxShadow = '0 0 30px rgba(255, 0, 128, 0.3)';
        setTimeout(() => {
            card.style.animation = '';
            card.style.boxShadow = '';
        }, 500);
    }
    
    async submitForm() {
        this.isSubmitting = true;
        this.submitBtn.classList.add('loading');
        
        this.submitBtn.style.boxShadow = '0 0 30px rgba(0, 255, 136, 0.6)';
        
        try {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            await FormUtils.simulateLogin(email, password);
            
            this.showSuccessMessage();
            
        } catch (error) {
            console.error('Login error:', error);
            this.showLoginError(error.message);
        } finally {
            this.isSubmitting = false;
            this.submitBtn.classList.remove('loading');
            this.submitBtn.style.boxShadow = '';
        }
    }
    
    showSuccessMessage() {
        this.form.style.opacity = '0';
        this.form.style.transform = 'translateY(-20px) scale(0.95)';
        
        const elementsToHide = ['.divider', '.social-login', '.signup-link'];
        elementsToHide.forEach(selector => {
            const element = document.querySelector(selector);
            if (element) {
                element.style.opacity = '0';
                element.style.transform = 'translateY(-20px) scale(0.95)';
            }
        });
        
        const card = document.querySelector('.login-card');
        card.style.boxShadow = '0 0 50px rgba(0, 255, 136, 0.4)';
        
        setTimeout(() => {
            this.form.style.display = 'none';
            elementsToHide.forEach(selector => {
                const element = document.querySelector(selector);
                if (element) element.style.display = 'none';
            });
            
            this.successMessage.classList.add('show');
            
            setTimeout(() => {
                this.simulateRedirect();
            }, 3000);
        }, 300);
    }
    
    simulateRedirect() {
        setTimeout(() => {
            this.resetForm();
        }, 2000);
    }
    
    showLoginError(message) {
        FormUtils.showNotification(message || 'Login failed. Please try again.', 'error', this.form);
        
        const card = document.querySelector('.login-card');
        card.style.animation = 'shake 0.5s ease-in-out';
        card.style.boxShadow = '0 0 40px rgba(255, 0, 128, 0.5)';
        setTimeout(() => {
            card.style.animation = '';
            card.style.boxShadow = '';
        }, 500);
    }
    
    resetForm() {
        this.successMessage.classList.remove('show');
        
        setTimeout(() => {
            const elementsToShow = ['.divider', '.social-login', '.signup-link'];
            this.form.style.display = 'block';
            elementsToShow.forEach(selector => {
                const element = document.querySelector(selector);
                if (element) {
                    element.style.display = 'block';
                }
            });
            
            this.form.reset();
            
            Object.keys(this.validators).forEach(fieldName => {
                this.clearError(fieldName);
            });
            
            this.form.style.opacity = '1';
            this.form.style.transform = 'translateY(0) scale(1)';
            
            elementsToShow.forEach(selector => {
                const element = document.querySelector(selector);
                if (element) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0) scale(1)';
                }
            });
            
            const card = document.querySelector('.login-card');
            card.style.boxShadow = '';

            const inputs = this.form.querySelectorAll('input');
            inputs.forEach(input => {
                input.classList.remove('has-value');
            });

            if (this.passwordInput) {
                this.passwordInput.type = 'password';
                const toggleIcon = this.passwordToggle?.querySelector('.toggle-icon');
                if (toggleIcon) {
                    toggleIcon.classList.remove('show-password');
                }
            }
        }, 300);
    }
    
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && e.target.closest('#loginForm')) {
                e.preventDefault();
                this.handleSubmit(e);
            }
            
            if (e.key === 'Escape') {
                Object.keys(this.validators).forEach(fieldName => {
                    this.clearError(fieldName);
                });
            }
        });
    }
    
    validate() {
        return this.validateForm();
    }
    
    getFormData() {
        const formData = new FormData(this.form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        return data;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const loginCard = document.querySelector('.login-card');
    if (loginCard) {
        loginCard.style.opacity = '0';
        loginCard.style.transform = 'translateY(30px) scale(0.9)';
        
        setTimeout(() => {
            loginCard.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            loginCard.style.opacity = '1';
            loginCard.style.transform = 'translateY(0) scale(1)';
        }, 200);
    }
    
    new LoginForm2();
});

document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') {
        const activeElement = document.activeElement;
        if (activeElement && activeElement.tagName !== 'INPUT') {
            const emailInput = document.querySelector('#email');
            if (emailInput && !emailInput.value) {
                setTimeout(() => emailInput.focus(), 100);
            }
        }
    }
});