<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // Check if existing customer
        $customerId = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
        
        if ($customerId) {
            // Validate existing customer
            $stmt = $pdo->prepare("SELECT id FROM customers WHERE id = ?");
            $stmt->execute([$customerId]);
            if (!$stmt->fetch()) {
                throw new Exception("Customer not found with ID: $customerId");
            }
        } else {
            // Insert new customer
            $requiredFields = [
                'firstname', 'lastname', 'phone', 'dob', 'gender',
                'address', 'city', 'state', 'zip_code', 'country'
            ];
            
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    throw new Exception("Missing required field: $field");
                }
            }

            $stmt = $pdo->prepare("
                INSERT INTO customers (
                    first_name, last_name, email, phone, dob, gender, nationality, 
                    address, city, state, zip_code, country, category, qualification, 
                    occupation, annual_income, pan_card, aadhar_number
                ) VALUES (
                    :firstname, :lastname, :email, :phone, :dob, :gender, :nationality,
                    :address, :city, :state, :zip_code, :country, :category, 
                    :qualification, :occupation, :annual_income, :pan_card, :aadhar_number
                )
            ");

            $customerData = [
                ':firstname' => $_POST['firstname'],
                ':lastname' => $_POST['lastname'],
                ':email' => $_POST['email'] ?? null,
                ':phone' => $_POST['phone'],
                ':dob' => $_POST['dob'],
                ':gender' => $_POST['gender'],
                ':nationality' => $_POST['nationality'] ?? '',
                ':address' => $_POST['address'],
                ':city' => $_POST['city'],
                ':state' => $_POST['state'],
                ':zip_code' => $_POST['zip_code'],
                ':country' => $_POST['country'],
                ':category' => $_POST['category'] ?? '',
                ':qualification' => $_POST['qualification'] ?? '',
                ':occupation' => $_POST['occupation'] ?? '',
                ':annual_income' => $_POST['annual_income'] ?? null,
                ':pan_card' => $_POST['pan_card'] ?? '',
                ':aadhar_number' => $_POST['aadhar_number'] ?? ''
            ];

            $stmt->execute($customerData);
            $customerId = $pdo->lastInsertId();
        }

        // Validate account fields
        $requiredAccountFields = [
            'accountType', 'branch', 'opening_date', 'initial_deposit'
        ];
        
        foreach ($requiredAccountFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Missing required account field: $field");
            }
        }

        // Generate account number
        $branchId = $_POST['branch'];
        $stmt = $pdo->prepare("SELECT branch_code FROM branch WHERE branch_id = ?");
        $stmt->execute([$branchId]);
        $branch = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$branch) {
            throw new Exception("Invalid branch selected");
        }

        if ($branch) {
            $branchCode = $branch['branch_code'];

            // Generate 12-digit account number
            $uniqueNumberLength = 12 - strlen($branchCode); // Calculate remaining digits
            $uniqueNumber = str_pad(mt_rand(1, pow(10, $uniqueNumberLength) - 1), $uniqueNumberLength, '0', STR_PAD_LEFT);
            $accountNumber = $branchCode . $uniqueNumber;
         }

        // Create account
        $stmt = $pdo->prepare("
            INSERT INTO accounts (
                customer_id, account_number, account_type, branch_id, 
                opening_date, initial_deposit, balance
            ) VALUES (
                :customer_id, :account_number, :account_type, :branch_id,
                :opening_date, :initial_deposit, :initial_deposit
            )
        ");

        $stmt->execute([
            ':customer_id' => $customerId,
            ':account_number' => $accountNumber,
            ':account_type' => $_POST['accountType'],
           ':branch_id' => $_POST['branch'],
            ':opening_date' => $_POST['opening_date'],
            ':initial_deposit' => $_POST['initial_deposit']
        ]);

        $pdo->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Account created successfully',
            'customer_id' => $customerId,
            'account_number' => $accountNumber
        ]);

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}
?>                            