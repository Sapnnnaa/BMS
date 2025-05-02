<?php
require 'database.php';


header('Content-Type: application/json');

try {
    
    $required = ['account_number', 'amount', 'recipient_account'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing $field");
        }
    }

    // Validate account numbers
    if (!preg_match('/^[A-Z0-9]{12}$/', $_POST['account_number'])) {
        throw new Exception("Invalid sender account format");
    }
    
    if (!preg_match('/^[A-Z0-9]{12}$/', $_POST['recipient_account'])) {
        throw new Exception("Invalid recipient account format");
    }

   
    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);
    if ($amount === false || $amount <= 0) {
        throw new Exception("Invalid amount");
    }

    if ($_POST['account_number'] === $_POST['recipient_account']) {
        throw new Exception("Cannot transfer to same account");
    }

    // Start transaction AFTER validation
    $pdo->beginTransaction();

    // Get sender balance
    $stmt = $pdo->prepare("SELECT balance FROM accounts WHERE account_number = ?");
    $stmt->execute([$_POST['account_number']]);
    $senderBalance = $stmt->fetchColumn();
    
    if ($senderBalance === false) {
        throw new Exception("Sender account not found");
    }

    /*if ($senderBalance < $amount) {
        throw new Exception("Insufficient funds");
    } */

    // Verify recipient exists
    $stmt = $pdo->prepare("SELECT 1 FROM accounts WHERE account_number = ?");
    $stmt->execute([$_POST['recipient_account']]);
    if (!$stmt->fetchColumn()) {
        throw new Exception("Recipient account not found");
    }

    // Calculate balances
    $newSenderBalance = $senderBalance - $amount;
    
    // Update sender
    $stmt = $pdo->prepare("UPDATE accounts SET balance = ? WHERE account_number = ?");
    $stmt->execute([$newSenderBalance, $_POST['account_number']]);

    // Update recipient
    $stmt = $pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE account_number = ?");
    $stmt->execute([$amount, $_POST['recipient_account']]);

    // Generate reference
    $referenceNumber = 'TXN' . date('Ymd') . bin2hex(random_bytes(4));

    // Insert transactions
    $stmt = $pdo->prepare("INSERT INTO transactions 
        (account_number, transaction_type, amount, description, 
         balance_after_transaction, reference_number, related_account)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Sender transaction
    $stmt->execute([
        $_POST['account_number'],
        'Transfer',
        $amount,
        $_POST['description'] ?? 'Funds Transfer',
        $newSenderBalance,
        $referenceNumber,
        $_POST['recipient_account']
    ]);

    // Recipient transaction
    // $stmt->execute([
    //     $_POST['recipient_account'],
    //     'Deposit',
    //     $amount,
    //     $_POST['description'] ?? 'Funds Received',
    //     $newSenderBalance + $amount, // Recipient's new balance
    //     $referenceNumber,
    //     $_POST['account_number']
    // ]);

    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'new_balance' => number_format($newSenderBalance, 2),
        'reference_number' => $referenceNumber
    ]);

} catch (Exception $e) {
    // Only rollback if transaction was started
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Transaction Error: ' . $e->getMessage());
    
    echo json_encode([
        'status' => 'error', 
        'message' => $e->getMessage()
    ]);
    exit;
}