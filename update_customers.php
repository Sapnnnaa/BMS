<?php
include 'database.php';

// Handle PUT requests
parse_str(file_get_contents("php://input"),  $_PUT);

// Check required fields
$required = ['customerId', 'firstname', 'lastname', 'phone'];
foreach ($required as $field) {
    if (empty($_PUT[$field])) {
        http_response_code(400);
        die(json_encode(['status' => 'error', 'message' => "$field is required"]));
    }
}

try {
    // Update Customer
    $stmt = $pdo->prepare("
        UPDATE customers SET
            first_name = ?,
            last_name = ?,
            email = ?,
            phone = ?,
            dob = ?,
            gender = ?,
            nationality = ?,
            address = ?,
            city = ?,
            zip_code = ?,
            state = ?,
            country = ?,
            category = ?,
            qualification = ?,
            occupation = ?,
            annual_income = ?,
            pan_card = ?,
            aadhar_number = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_PUT['firstname'],
        $_PUT['lastname'],
        $_PUT['email'],
        $_PUT['phone'],
        $_PUT['dob'],
        $_PUT['gender'],
        $_PUT['nationality'],
        $_PUT['address'],
        $_PUT['city'],
        $_PUT['zip_code'],
        $_PUT['state'],
        $_PUT['country'],
        $_PUT['category'],
        $_PUT['qualification'],
        $_PUT['occupation'],
        $_PUT['annual_income'],
        $_PUT['pan_card'],
        $_PUT['aadhar_number'],
        $_PUT['customerId']
    ]);

    // Update Account
    $stmt = $pdo->prepare("
        UPDATE accounts SET
            account_type = ?,
            branch_id = ?,
            opening_date = ?,
            initial_deposit = ?
        WHERE customer_id = ?
    ");

    $stmt->execute([
        $_PUT['accountType'],
        $_PUT['branch'],
        $_PUT['opening_date'],
        $_PUT['initial_deposit'],
        $_PUT['customerId']
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Customer updated successfully'
    ]);

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>