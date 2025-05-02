<?php
include 'database.php';

header('Content-Type: application/json');

try {
    // Get all counts in single query for better performance
    $stmt = $pdo->query("
        SELECT 
            (SELECT COUNT(*) FROM customers) AS total_customers,
            (SELECT COUNT(*) FROM accounts) AS total_accounts,
            (SELECT COUNT(*) FROM transactions) AS total_transactions,
             (SELECT COUNT(*) FROM accounts WHERE status = 'active') AS active_accounts,
            (SELECT COALESCE(SUM(balance), 0) FROM accounts) AS total_balance
    ");
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'total_customers' => $result['total_customers'],
        'total_accounts' => $result['total_accounts'],
        'total_transactions' => $result['total_transactions'],
        'active_accounts' => $result['active_accounts'],
        'total_balance' => $result['total_balance']
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>