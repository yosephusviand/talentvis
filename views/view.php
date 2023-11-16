<?php
class View
{
    public function showLoginForm()
    {
        // Implement the login form
        include_once 'views/login.php';
    }

    public function showRegistrationForm()
    {
        // Implement the registration form
        include_once 'views/register.php';
    }

    public function showLogoutForm()
    {
        // Implement the logout form
        echo "<form method='post' action='index.php?action=logout'>
    <button type='submit' class='btn btn-danger'>Logout</button>
</form>";
    }

    public function showErrorMessage($message)
    {
        // Display error messages
        echo "<p style='color: red;'>$message</p>";
    }

    public function showSuccessMessage($message)
    {
        // Display success messages
        echo "<p style='color: green;'>$message</p>";
    }

    public function showHome($walletModel)
    {
        // Display home page
        include_once 'views/index.php';
    }

    public function showDasboard($user, $walletModel, $model)
    {   
        // Display home page
        include_once 'views/dashboard.php';
    }
}
