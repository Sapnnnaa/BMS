<?php
session_start();
include 'database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (empty($_POST['email'])) {
            throw new Exception("Email is required");
        }
        if (empty($_POST['password'])) {
            throw new Exception("Password is required");
        }

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM bank_employees WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            throw new Exception("Invalid credentials");
        }

        // Login success
        $_SESSION['user_id'] = $user['employee_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['loggedin'] = true;

        header("Location: dashboard.php");
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PrimeTrust Bank | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(108, 98, 142, 0.9), rgba(0, 0, 0, 0.9));
            z-index: -1;
        }

        .login-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .bank-logo {
            width: 60px;
            margin-bottom: 1.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            opacity: 0.6;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">PrimeTrust Bank</a>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-card">
            <div class="text-center mb-4">
                <img src="https://img.icons8.com/color/96/000000/bank-building.png" alt="Bank Logo" class="bank-logo">
                <h4 class="h5 mb-3">Login</h4>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-sm" id="email" required placeholder="name@example.com">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-sm" id="password" required placeholder="••••••••">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-sm">Sign In</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="fixed-bottom bg-dark text-white py-3">
        <div class="container text-center small">
            <p class="mb-0">&copy; 2024 PrimeTrust Bank. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
