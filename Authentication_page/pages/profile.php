<?php
require_once __DIR__ . '/../config/config.php';
requireLogin();

$user = getCurrentUser();
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } else {
        $db = Database::getInstance()->getConnection();
        
        if (isset($_POST['action']) && $_POST['action'] === 'update_profile') {
            $fullName = sanitizeInput($_POST['full_name']);
            $phone = sanitizeInput($_POST['phone']);
            
            $stmt = $db->prepare("UPDATE users SET full_name = ?, phone = ? WHERE id = ?");
            if ($stmt->execute([$fullName, $phone, $user['id']])) {
                setFlashMessage('Profile updated successfully!', 'success');
                redirect($_SERVER['PHP_SELF']);
            } else {
                $errors[] = 'Failed to update profile.';
            }
        }
        
        if (isset($_POST['action']) && $_POST['action'] === 'change_password') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
            
            $stmt = $db->prepare("SELECT password_hash FROM users WHERE id = ?");
            $stmt->execute([$user['id']]);
            $userData = $stmt->fetch();
            
            if (!password_verify($currentPassword, $userData['password_hash'])) {
                $errors[] = 'Current password is incorrect.';
            } elseif (strlen($newPassword) < PASSWORD_MIN_LENGTH) {
                $errors[] = 'New password must be at least ' . PASSWORD_MIN_LENGTH . ' characters.';
            } elseif ($newPassword !== $confirmPassword) {
                $errors[] = 'New passwords do not match.';
            } else {
                $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
                $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                if ($stmt->execute([$newHash, $user['id']])) {
                    setFlashMessage('Password changed successfully!', 'success');
                    redirect($_SERVER['PHP_SELF']);
                }
            }
        }
        
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = uploadProfileImage($_FILES['profile_image'], $user['id']);
            if ($uploadResult['success']) {
                $stmt = $db->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
                $stmt->execute([$uploadResult['filename'], $user['id']]);
                setFlashMessage('Profile image updated!', 'success');
                redirect($_SERVER['PHP_SELF']);
            } else {
                $errors[] = $uploadResult['message'];
            }
        }
    }
}

$pageTitle = 'My Profile';
include __DIR__ . '/../includes/header.php';
?>

<div class="profile-page">
    <div class="container">
        <div class="page-header">
            <h1>My Profile</h1>
            <p>Manage your account settings and preferences</p>
        </div>
        
        <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="profile-grid">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <?php
                    $avatarPath = SITE_URL . '/uploads/' . htmlspecialchars($user['profile_image']);
                    if (!file_exists(__DIR__ . '/../uploads/' . $user['profile_image'])) {
                        $avatarPath = 'https://ui-avatars.com/api/?name=' . urlencode($user['username']) . '&size=200&background=2563eb&color=fff';
                    }
                    ?>
                    <img src="<?php echo $avatarPath; ?>" alt="Profile">
                </div>
                <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
                <span class="badge badge-<?php echo $user['subscription_status'] === 'active' ? 'success' : 'secondary'; ?>">
                    <?php echo ucfirst($user['subscription_status']); ?>
                </span>
                
                <form method="POST" enctype="multipart/form-data" class="upload-form">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <label for="profile_image" class="btn btn-secondary btn-sm">
                        <i class="fas fa-camera"></i> Change Photo
                    </label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" style="display:none" onchange="this.form.submit()">
                </form>
            </div>
            
            <div class="profile-content">
                <div class="profile-section">
                    <h2>Personal Information</h2>
                    <form method="POST" class="profile-form">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="form-control" disabled>
                            <small>Username cannot be changed</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control" disabled>
                            <small>Contact admin to change email</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" 
                                   value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" class="form-control" 
                                   value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </form>
                </div>
                
                <div class="profile-section">
                    <h2>Change Password</h2>
                    <form method="POST" class="profile-form">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <input type="hidden" name="action" value="change_password">
                        
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
