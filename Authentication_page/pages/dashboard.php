<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();

$user = getCurrentUser();
$db = Database::getInstance()->getConnection();

// Get recent activities
$stmt = $db->prepare("SELECT * FROM activity_logs WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt->execute([$user['id']]);
$activities = $stmt->fetchAll();

$pageTitle = 'Dashboard';
include __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-page">
    <div class="container">
        <div class="page-header">
            <h1>Welcome back, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <p>Manage your account and access exclusive content</p>
        </div>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon"><i class="fas fa-user"></i></div>
                <h3>Account Status</h3>
                <p class="card-value"><?php echo ucfirst($user['subscription_status']); ?></p>
                <small>Member since <?php echo formatDate($user['created_at']); ?></small>
            </div>
            
            <div class="dashboard-card">
                <div class="card-icon"><i class="fas fa-calendar"></i></div>
                <h3>Subscription</h3>
                <p class="card-value">
                    <?php 
                    if ($user['subscription_status'] === 'active' && $user['subscription_end']) {
                        echo getSubscriptionDaysRemaining($user['subscription_end']) . ' days';
                    } else {
                        echo 'No active subscription';
                    }
                    ?>
                </p>
                <small><?php echo $user['subscription_end'] ? 'Expires ' . formatDate($user['subscription_end']) : 'Upgrade to premium'; ?></small>
            </div>
            
            <div class="dashboard-card">
                <div class="card-icon"><i class="fas fa-clock"></i></div>
                <h3>Last Login</h3>
                <p class="card-value"><?php echo timeAgo($user['last_login']); ?></p>
                <small><?php echo formatDate($user['last_login'], 'M d, Y g:i A'); ?></small>
            </div>
        </div>
        
        <div class="dashboard-sections">
            <div class="dashboard-section">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="<?php echo SITE_URL; ?>/pages/profile.php" class="btn btn-primary">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a>
                    <a href="<?php echo SITE_URL; ?>/pages/members-only.php" class="btn btn-secondary">
                        <i class="fas fa-lock"></i> Members Area
                    </a>
                    <a href="<?php echo SITE_URL; ?>/payment/subscribe.php" class="btn btn-outline">
                        <i class="fas fa-crown"></i> Upgrade Plan
                    </a>
                </div>
            </div>
            
            <div class="dashboard-section">
                <h2>Recent Activity</h2>
                <div class="activity-list">
                    <?php if (empty($activities)): ?>
                        <p>No recent activity</p>
                    <?php else: ?>
                        <?php foreach ($activities as $activity): ?>
                            <div class="activity-item">
                                <i class="fas fa-circle"></i>
                                <div class="activity-details">
                                    <strong><?php echo htmlspecialchars($activity['action']); ?></strong>
                                    <p><?php echo htmlspecialchars($activity['description']); ?></p>
                                    <small><?php echo timeAgo($activity['created_at']); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
