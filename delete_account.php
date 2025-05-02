<?php
header("Content-Type: application/json");
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON input']);
        exit;
    }
    
    if (!isset($input['account_number'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Account number is required']);
        exit;
    }

    $accountNumber = $input['account_number'];

    try {
        $pdo->beginTransaction();

        
        $stmt = $pdo->prepare("SELECT balance, customer_id FROM accounts WHERE account_number = ?");
        $stmt->execute([$accountNumber]);
        $account = $stmt->fetch();

        if (!$account) {
            throw new Exception("Account not found");
        }

        if ($account['balance'] != 0) {
            throw new Exception("Cannot delete account with non-zero balance");
        }

        
        $stmt = $pdo->prepare("DELETE FROM accounts WHERE account_number = ?");
        $stmt->execute([$accountNumber]);

        $pdo->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Account deleted successfully',
            'customer_id' => $account['customer_id']
        ]);

    } catch (PDOException $e) {
        $pdo->rollBack();  
        http_response_code(500);
        echo json_encode([
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(400);
        echo json_encode([
            'error' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>