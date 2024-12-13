<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="loginStyle.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <img src="images/TESL_logo.png" alt="Logo">
            </div>
            <form action="login_db.php" method="post">
                <div class="input-group">
                    <input type="text" name="userId" placeholder="User ID" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <i class="toggle-password" id="togglePassword">👁‍🗨️</i>
                </div>
                <div class="options">
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>
    <div data-include-footer></div>
    <script src="includeFooter.js" defer></script>
    <script src="loginScript.js"></script>
</body>
</html>