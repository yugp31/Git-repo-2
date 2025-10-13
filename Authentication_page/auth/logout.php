<?php
require_once __DIR__ . '/../config/config.php';
logoutUser();
setFlashMessage('You have been logged out successfully.', 'success');
redirect(SITE_URL . '/index.php');
?>
