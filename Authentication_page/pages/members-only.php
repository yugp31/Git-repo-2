<?php
require_once __DIR__ . '/../config/config.php';
requireSubscription();

$user = getCurrentUser();
$pageTitle = 'Members Only Area';
include __DIR__ . '/../includes/header.php';
?>

<div class="members-page">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-crown"></i> Members Only Content</h1>
            <p>Exclusive resources and content for premium members</p>
        </div>
        
        <div class="subscription-status">
            <div class="status-card">
                <i class="fas fa-check-circle"></i>
                <h3>Active Membership</h3>
                <p><?php echo getSubscriptionDaysRemaining($user['subscription_end']); ?> days remaining</p>
                <p>Expires: <?php echo formatDate($user['subscription_end']); ?></p>
            </div>
        </div>
        
        <div class="content-grid">
            <div class="content-card">
                <div class="content-thumbnail">
                    <i class="fas fa-video fa-3x"></i>
                </div>
                <h3>Premium Video Series</h3>
                <p>Exclusive video tutorials and masterclasses available only to members.</p>
                <a href="#" class="btn btn-primary">Watch Now</a>
            </div>
            
            <div class="content-card">
                <div class="content-thumbnail">
                    <i class="fas fa-file-pdf fa-3x"></i>
                </div>
                <h3>Downloadable Resources</h3>
                <p>Access our library of premium PDFs, templates, and guides.</p>
                <a href="#" class="btn btn-primary">Download</a>
            </div>
            
            <div class="content-card">
                <div class="content-thumbnail">
                    <i class="fas fa-comments fa-3x"></i>
                </div>
                <h3>Private Community</h3>
                <p>Join discussions with other premium members in our exclusive forum.</p>
                <a href="#" class="btn btn-primary">Join Discussion</a>
            </div>
            
            <div class="content-card">
                <div class="content-thumbnail">
                    <i class="fas fa-graduation-cap fa-3x"></i>
                </div>
                <h3>Online Courses</h3>
                <p>Complete access to all premium courses and certification programs.</p>
                <a href="#" class="btn btn-primary">Start Learning</a>
            </div>
            
            <div class="content-card">
                <div class="content-thumbnail">
                    <i class="fas fa-headset fa-3x"></i>
                </div>
                <h3>Priority Support</h3>
                <p>Get fast, dedicated support from our expert team.</p>
                <a href="#" class="btn btn-primary">Contact Support</a>
            </div>
            
            <div class="content-card">
                <div class="content-thumbnail">
                    <i class="fas fa-tools fa-3x"></i>
                </div>
                <h3>Premium Tools</h3>
                <p>Access exclusive tools and software reserved for members.</p>
                <a href="#" class="btn btn-primary">Explore Tools</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
