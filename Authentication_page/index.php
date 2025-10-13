<?php
require_once __DIR__ . '/config/config.php';
$pageTitle = 'Home';
include __DIR__ . '/includes/header.php';
?>

<div class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>Welcome to <?php echo SITE_NAME; ?></h1>
            <p class="hero-subtitle">Access exclusive content, connect with members, and unlock premium features</p>
            <?php if (!isLoggedIn()): ?>
                <div class="hero-buttons">
                    <a href="<?php echo SITE_URL; ?>/auth/register.php" class="btn btn-primary btn-lg">Get Started Free</a>
                    <a href="<?php echo SITE_URL; ?>/payment/subscribe.php" class="btn btn-secondary btn-lg">View Plans</a>
                </div>
            <?php else: ?>
                <a href="<?php echo SITE_URL; ?>/pages/dashboard.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="features-section">
    <div class="container">
        <h2 class="section-title">Why Join Us?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-lock"></i></div>
                <h3>Exclusive Content</h3>
                <p>Access premium articles, videos, and resources available only to members.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h3>Community Access</h3>
                <p>Connect with like-minded individuals and grow your network.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                <h3>Priority Support</h3>
                <p>Get fast responses and dedicated support from our team.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-gift"></i></div>
                <h3>Member Benefits</h3>
                <p>Enjoy special discounts, early access, and exclusive perks.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3>Mobile Friendly</h3>
                <p>Access your membership from anywhere, on any device.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Secure & Private</h3>
                <p>Your data is protected with industry-standard security.</p>
            </div>
        </div>
    </div>
</div>

<div class="cta-section">
    <div class="container">
        <h2>Ready to Get Started?</h2>
        <p>Join thousands of members already enjoying premium benefits</p>
        <?php if (!isLoggedIn()): ?>
            <a href="<?php echo SITE_URL; ?>/auth/register.php" class="btn btn-primary btn-lg">Create Your Account</a>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
