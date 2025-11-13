<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Form</title>
    <link rel="stylesheet" href="../../public/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">⚡</div>
                <h2>Login</h2>
                <p>Acesse sua conta</p>
            </div>

            <form class="login-form" id="loginForm" novalidate>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required autocomplete="email">
                        <label for="email">E-mail</label>
                        <span class="input-line"></span>
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                        <label for="password">Senha</label>
                        <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                            <span class="toggle-icon">👁️</span>
                        </button>
                        <span class="input-line"></span>
                    </div>
                    <span class="error-message" id="passwordError"></span>
                </div>

                <div class="form-options">
                    <div class="remember-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" class="checkbox-label">
                            <span class="custom-checkbox"></span>
                            Lembrar-me
                        </label>
                    </div>
                    <a href="#" class="forgot-password">Esqueceu a senha?</a>
                </div>

                <button type="submit" class="login-btn btn" id="submitBtn">
                    <span class="btn-text">Entrar</span>
                    <span class="btn-loader" aria-hidden="true"></span>
                    <span class="btn-glow" aria-hidden="true"></span>
                </button>
            </form>

            <div class="divider">
                <span>or</span>
            </div>

            <div class="social-login">
                <button type="button" class="social-btn google-btn">
                    <span class="social-icon google-icon"></span>
                    <span>Continue with Google</span>
                </button>
                <button type="button" class="social-btn apple-btn">
                    <span class="social-icon apple-icon"></span>
                    <span>Continue with Apple</span>
                </button>
            </div>

            <div class="signup-link">
                <p>New here? <a href="#">Create an account</a></p>
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
    <script src="/js/login.js"></script>
</body>
</html>
