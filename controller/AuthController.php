<?php
// Controller.php (Controller)
class AuthController
{
    private $model;
    private $view;
    private $db;
    private $user;

    public function __construct($model, $view)
    {
        $this->db = new DatabaseConnection();
        $this->model = $model;
        $this->view = $view;
    }

    public function handleRequest()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'home';

        switch ($action) {
            case 'home':
                $this->handleHome();
                break;
            case 'register':
                $this->handleRegistration();
                break;
            case 'login':
                $this->handleLogin();
                break;
            case 'logout':
                $this->handleLogout();
                break;
            case 'dashboard':
                $this->handleDashboard();
                break;
            default:
                $this->view->showLoginForm();
        }
    }

    private function handleHome()
    {
        $walletModel = new WalletModel($this->db);
        $userController = new WalletController($walletModel);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['type']) && $_POST['type'] === 'deposit') {
                $depositAmount = $_POST['nominal'];
                $type = $_POST['type'];
                $userController->deposit($depositAmount, $type);
                $this->view->showHome($walletModel);
            } else if (isset($_POST['type']) && $_POST['type'] === 'withdraw') {
                $withdrawAmount = $_POST['nominal'];
                $type = $_POST['type'];
                $res =  $userController->withdraw($withdrawAmount, $type);
                if ($res === false) {
                    $this->view->showSuccessMessage('Your balance is insufficient');
                }
                $this->view->showHome($walletModel);
            }
        } else {
            $this->view->showHome($walletModel);
        }
    }

    private function handleDashboard()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            $users = $_SESSION['user'];
            $walletModel = new WalletUserModel($this->db);
            $userController = new WalletUserController($walletModel);
            $id = $users['id'];
            $user = $this->model->getData($users['id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['type']) && $_POST['type'] === 'deposit') {
                    $depositAmount = $_POST['nominal'];
                    $type = $_POST['type'];
                    $userController->deposit($depositAmount, $type, $id);
                    $this->view->showDasboard($users, $walletModel, $this->model);
                    $this->view->showLogoutForm();
                } else if (isset($_POST['type']) && $_POST['type'] === 'withdraw') {
                    $withdrawAmount = $_POST['nominal'];
                    $type = $_POST['type'];
                    $res =  $userController->withdraw($withdrawAmount, $type, $id);
                    if ($res === false) {
                        $this->view->showSuccessMessage('Your balance is insufficient');
                    }
                    $this->view->showDasboard($users, $walletModel, $this->model);
                    $this->view->showLogoutForm();
                } else if (isset($_POST['type']) && $_POST['type'] === 'transfer') {
                    $transferAmount = $_POST['nominal'];
                    $type = $_POST['type'];
                    $to = $_POST['tf_to'];
                    $from = $_POST['id'];
                    $res =  $userController->transfer($transferAmount, $type, $to, $from);
                    if ($res === false) {
                        $this->view->showSuccessMessage('Your balance is insufficient');
                    }
                    $this->view->showDasboard($users, $walletModel, $this->model);
                    $this->view->showLogoutForm();
                }
            } else {
                $this->view->showDasboard($users, $walletModel, $this->model);
                $this->view->showLogoutForm();
            }
        } else {
            $this->view->showSuccessMessage('Your session has expired. Please login.');
            $this->view->showLoginForm();
        }
    }

    private function handleRegistration()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $name = $_POST['name'];

            // Perform validation if needed

            $this->model->register($username, $password, $name);
            $this->view->showSuccessMessage('Registration successful. Please login.');
        } else {
            $this->view->showRegistrationForm();
        }
    }

    private function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->model->login($username, $password);
            $this->user = $user;
            if ($user) {
                session_start();
                $walletModel = new WalletUserModel($this->db);
                $this->view->showSuccessMessage('Login successful. Welcome, ' . $user['name']);
                $this->view->showDasboard($user, $walletModel, $this->model);
                $_SESSION["user"] = $user;
                $this->view->showLogoutForm();
            } else {
                $this->view->showErrorMessage('Invalid username or password.');
                $this->view->showLoginForm();
            }
        } else {
            $this->view->showLoginForm();
        }
    }

    private function handleLogout()
    {
        // Perform necessary logout actions, e.g., destroy session variables
        session_start();
        session_destroy();
        $this->view->showSuccessMessage('Logout successful.');
        $this->view->showLoginForm();
    }
}
