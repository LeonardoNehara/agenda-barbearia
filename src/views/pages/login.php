<?php $render('header'); ?>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">✂️</div>
                <h2>Login</h2>
                <p>Acesse sua conta</p>
            </div>

            <form class="login-form" id="loginForm" method="POST" action="<?= $base ?>/logar" novalidate>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" id="login" name="login" required autocomplete="Usuario">
                        <label for="login">Usuario</label>
                        <span class="input-line"></span>
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                        <label for="password">Senha</label>
                        <button type="button" class="password-toggle" id="passwordToggle">
                            <span class="toggle-icon">👁️</span>
                        </button>
                        <span class="input-line"></span>
                    </div>
                    <span class="error-message" id="passwordError"></span>
                </div>

                <button type="submit" class="login-btn btn" id="submitBtn">
                    <span class="btn-text">Entrar</span>
                </button>
            </form>

            <div class="divider">
                <span>ou</span>
            </div>

            <div class="social-login">
                <button type="button" class="social-btn google-btn">
                    <span class="social-icon google-icon"></span>
                    <span>Continar com Google</span>
                </button>
                <button type="button" class="social-btn apple-btn">
                    <span class="social-icon apple-icon"></span>
                    <span>Continar com Apple</span>
                </button>
            </div>

            <div class="signup-link">
                <p>Novo aqui? <a href="#">Crie uma conta.</a></p>
            </div>

            <div class="success-message" id="successMessage" aria-hidden="true">
                <div class="success-icon">✓</div>
                <h3>Welcome back!</h3>
                <p>Redirecting to your dashboard...</p>
            </div>
        </div>

        <div class="background-effects">
            <div class="glow-orb glow-orb-1"></div>
            <div class="glow-orb glow-orb-2"></div>
            <div class="glow-orb glow-orb-3"></div>
        </div>
    </div>
    <script src="js/login.js"></script>