<?php
require 'database.php';

header('Content-Type: application/json');

function generateReferenceNumber() {
    return 'TXN' . date('Ymd') . strtoupper(bin2hex(random_bytes(4)));
}

try {
    $required = ['account_number', 'amount'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) throw new Exception("Missing $field");
    }

    $amount = floatval($_POST['amount']);
    if ($amount <= 0) throw new Exception("Invalid amount");

    $pdo->beginTransaction();

    // Get current balance
    $stmt = $pdo->prepare("SELECT balance FROM accounts WHERE account_number = ?");
    $stmt->execute([$_POST['account_number']]);
    $currentBalance = $stmt->fetchColumn();
    
    if ($currentBalance === false) {
        throw new Exception("Account not found");
    }

    // Calculate new balance
    $newBalance = $currentBalance + $amount;

    // Update balance
    $stmt = $pdo->prepare("UPDATE accounts SET balance = ? WHERE account_number = ?");
    $stmt->execute([$newBalance, $_POST['account_number']]);

    // Generate reference number
    $referenceNumber = generateReferenceNumber();

    // Record transaction with all fields
    $stmt = $pdo->prepare("
        INSERT INTO transactions 
        (account_number, transaction_type, amount, description, 
         balance_after_transaction, reference_number)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $_POST['account_number'],
        'Deposit',
        $amount,
        $_POST['description'] ?? 'Deposit',
        $newBalance,
        $referenceNumber
    ]);

    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'new_balance' => number_format($newBalance, 2),
        'reference_number' => $referenceNumber
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(400);
    echo json_encode([
        'status' => 'error', 
        'message' => $e->getMessage()
    ]);
}
?>