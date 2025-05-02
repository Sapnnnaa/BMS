<?php
require 'database.php';

header('Content-Type: application/json');

try {
    $search = $_POST['search'] ?? '';
    $searchTerm = "%$search%";

    $stmt = $pdo->prepare("
        SELECT id, first_name, last_name 
        FROM customers 
        WHERE id LIKE :search 
           OR CONCAT(first_name, ' ', last_name) LIKE :search
        ORDER BY id DESC
        LIMIT 10
    ");

    $stmt->bindParam(':search', $searchTerm);
    $stmt->execute();

    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $customers
    ]);

} catch(PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>