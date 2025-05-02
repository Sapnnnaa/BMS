<?php
session_start();
include 'database.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];


try {
    $required = ['first_name', 'last_name', 'email', 'password'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("All fields are required");
        }
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format");
    }

    // Check if email exists
    $stmt = $pdo->prepare("SELECT  employee_id FROM bank_employees WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception("Email already registered");
    }

    // Hash password
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    if (!$password_hash) {
        throw new Exception("Password hashing failed");
    }

    // Insert employee
    $stmt = $pdo->prepare("
        INSERT INTO bank_employees 
        (first_name, last_name, email, password_hash)
        VALUES (?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $password_hash
    ]);

    if (!$success) {
        throw new Exception("Registration failed due to database error");
    }

    $response['success'] = true;
    $response['message'] = "Registration successful!";

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>