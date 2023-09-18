<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["token"])) {
    $resetToken = $_GET["token"];

    // TODO: Validate the reset token and check if it has expired
    // Example pseudocode:
    // $tokenValid = validateResetToken($resetToken); // Implement this function
    // $tokenExpired = checkTokenExpiry($resetToken); // Implement this function

    if (!$tokenValid || $tokenExpired) {
        // Token is invalid or expired, show an error message or redirect
        // You might want to redirect the user to an error page or the login page
        header("Location: login.php");
        exit();
    }
} else {
    // Invalid or missing token, redirect
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Validate the new password and confirmation
    if ($newPassword === $confirmPassword) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // TODO: Update the user's password in the database
        // Example pseudocode:
        // $userEmail = getUserEmailByResetToken($resetToken); // Implement this function
        // updatePasswordInDatabase($userEmail, $hashedPassword); // Implement this function

        // Password updated, redirect to the login page
        header("Location: login.php");
        exit();
    } else {
        // Passwords don't match, show an error message
        $errorMessage = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <?php if (isset($errorMessage)) { ?>
        <div><?php echo $errorMessage; ?></div>
    <?php } ?>
    <form action="" method="post">
        <input type="hidden" name="reset_token" value="<?php echo $_GET['token']; ?>">
        <div>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <div>
            <button type="submit">Reset Password</button>
        </div>
    </form>
</body>
</html>
