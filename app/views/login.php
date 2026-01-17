<!DOCTYPE html>
<html lang="<?php echo I18n::getLang(); ?>" dir="<?php echo I18n::isRtl() ? 'rtl' : 'ltr'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CFSYS CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #4f46e5 0%, #111827 100%);
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
        }

        .error-box {
            background: #fee2e2;
            color: #b91c1c;
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <h2>CFSYS CRM</h2>
            <p style="color: #6b7280; margin-top: 0.5rem;">Sign in to your account</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-box">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?route=login" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generate(); ?>">
            <div class="form-group">
                <label class="form-label">
                    <?php echo __('username'); ?>
                </label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">
                    <?php echo __('password'); ?>
                </label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-full" style="justify-content: center; margin-top: 1rem;">
                <?php echo __('login'); ?>
            </button>
        </form>

        <div style="margin-top: 2rem; text-align: center; font-size: 0.875rem;">
            <div class="lang-switch" style="justify-content: center;">
                <a href="index.php?route=set_lang&lang=en"
                    class="lang-btn <?php echo I18n::getLang() === 'en' ? 'active' : ''; ?>">English</a>
                <a href="index.php?route=set_lang&lang=ar"
                    class="lang-btn <?php echo I18n::getLang() === 'ar' ? 'active' : ''; ?>">العربية</a>
            </div>
        </div>
    </div>
</body>

</html>