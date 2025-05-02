<?php
include 'database.php';

$customerId = $_GET['id'];

try {
    $stmt = $pdo->prepare("
        SELECT c.*, a.account_number, a.account_type, a.opening_date, a.branch_id, a.initial_deposit, branch_name 
        FROM customers c
        LEFT JOIN accounts a ON c.id = a.customer_id
        LEFT JOIN branch b ON a.branch_id = b.branch_id
        WHERE c.id = ?
    ");
    $stmt->execute([$customerId]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($customer) {
        header('Content-Type: application/json');
        echo json_encode($customer);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Customer not found']);
    }
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>