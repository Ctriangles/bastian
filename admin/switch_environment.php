<?php
/**
 * Environment Switcher Script
 * Since only sandbox API is valid, both local and production will use:
 * https://api.eat-sandbox.co/concierge/v2
 */

session_start();

if ($_POST['action'] ?? '' === 'switch') {
    $target_env = $_POST['environment'] ?? 'auto';
    
    // Read current config
    $config_content = file_get_contents('application/config/config.php');
    
    if ($target_env === 'local') {
        // Force local environment
        $config_content = preg_replace(
            '/\$config\[\'environment\'\]\s*=\s*[\'"]production[\'"];/',
            '$config[\'environment\'] = \'local\';',
            $config_content
        );
        // Always sandbox
        $config_content = preg_replace(
            '/\$config\[\'eatapp_api_url\'\]\s*=\s*[\'"].*[\'"];/',
            '$config[\'eatapp_api_url\'] = \'https://api.eat-sandbox.co/concierge/v2\';',
            $config_content
        );
        $message = "Switched to LOCAL environment (sandbox API)";
    } elseif ($target_env === 'production') {
        // Force production environment
        $config_content = preg_replace(
            '/\$config\[\'environment\'\]\s*=\s*[\'"]local[\'"];/',
            '$config[\'environment\'] = \'production\';',
            $config_content
        );
        // Still sandbox
        $config_content = preg_replace(
            '/\$config\[\'eatapp_api_url\'\]\s*=\s*[\'"].*[\'"];/',
            '$config[\'eatapp_api_url\'] = \'https://api.eat-sandbox.co/concierge/v2\';',
            $config_content
        );
        $message = "Switched to PRODUCTION environment (but still sandbox API)";
    } else {
        $message = "Using AUTO environment detection (sandbox API)";
    }
    
    // Write back to config
    file_put_contents('application/config/config.php', $config_content);
    
    $_SESSION['message'] = $message;
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Get current environment
$config_content = file_get_contents('application/config/config.php');

// Detect environment
$is_sandbox = strpos($config_content, 'https://api.eat-sandbox.co') !== false;
$is_local = strpos($config_content, "['environment'] = 'local'") !== false;
$is_production = strpos($config_content, "['environment'] = 'production'") !== false;

if ($is_local) {
    $current_env = 'local';
} elseif ($is_production) {
    $current_env = 'production';
} else {
    $current_env = 'auto';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Environment Switcher</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 600px; margin: 0 auto; }
        .status { padding: 15px; margin: 20px 0; border-radius: 5px; }
        .status.local { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .status.production { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .status.auto { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        select, button { padding: 10px; font-size: 16px; }
        button { background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .message { padding: 15px; margin: 20px 0; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Environment Switcher</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?php echo $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <div class="status <?php echo $current_env; ?>">
            <strong>Current Environment:</strong> <?php echo strtoupper($current_env); ?>
            <br>Using Sandbox API (api.eat-sandbox.co)
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="environment">Switch to Environment:</label>
                <select name="environment" id="environment">
                    <option value="auto">Auto-detect (Recommended)</option>
                    <option value="local">Local</option>
                    <option value="production">Production</option>
                </select>
            </div>
            
            <button type="submit" name="action" value="switch">Switch Environment</button>
        </form>
        
        <hr>
        
        <h3>Current Configuration</h3>
        <p><strong>Config File:</strong> application/config/config.php</p>
        <p><strong>API URL:</strong> https://api.eat-sandbox.co/concierge/v2 (Sandbox only)</p>
        
        <h3>Note</h3>
        <ul>
            <li>Both Local and Production will use the sandbox API.</li>
            <li>Environment flag is for internal config only, not for changing API URL.</li>
        </ul>
    </div>
</body>
</html>
