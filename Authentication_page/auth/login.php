<?php
require_once __DIR__ . '/../config/config.php';

if (isLoggedIn()) {
    redirect(SITE_URL . '/pages/dashboard.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } else {
        $email = sanitizeInput($_POST['email']);
        $password = $_POST['password'];
        
        $result = loginUser($email, $password);
        
        if ($result['success']) {
            $redirect = $_SESSION['redirect_after_login'] ?? SITE_URL . '/pages/dashboard.php';
            unset($_SESSION['redirect_after_login']);
            redirect($redirect);
        } else {
            $errors[] = $result['message'];
        }
    }
}

$pageTitle = 'Login';
include __DIR__ . '/../includes/header.php';
?>

<div class="auth-page">
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <h1>Welcome Back</h1>
                <p class="auth-subtitle">Log in to access your account</p>
                
                <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="auth-form">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> Log In
                    </button>
                </form>
                
                <div class="auth-footer">
                    <p>Don't have an account? <a href="<?php echo SITE_URL; ?>/auth/register.php">Sign up</a></p>
                </div>
                
                <div class="test-credentials">
                    <p><strong>Test Accounts:</strong></p>
                    <p>Admin: admin@example.com / Admin@123</p>
                    <p>Member: member@example.com / Member@123</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
