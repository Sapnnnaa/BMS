<?php
include 'database.php';

header('Content-Type: application/json');

try {
    // Columns for ordering (match DataTables columns)
    $columns = [
        'transaction_id',
        'account_number',
        'transaction_type',
        'amount',
        'related_account',
        'transaction_date',
        'reference_number'
    ];

    // Get DataTables parameters
    $request = $_POST;
    $draw = $request['draw'] ?? 1;
    $start = $request['start'] ?? 0;
    $length = $request['length'] ?? 10;
    $searchValue = $request['search']['value'] ?? '';
    if (empty($request['order'])) {
        // Default to transaction_date descending
        $orderColumn = 'transaction_date';
        $orderDir = 'DESC';
    } else {
        $orderColumnIndex = $request['order'][0]['column'];
        $orderColumn = $columns[$orderColumnIndex];
        $orderDir = $request['order'][0]['dir'];
        
        // Validate order column index
        if ($orderColumnIndex >= count($columns)) {
            $orderColumn = 'transaction_date';
            $orderDir = 'DESC';
        }
    }

    // Validate order column index
    if ($orderColumnIndex >= count($columns)) {
        $orderColumnIndex = 0;
    }
    $orderColumn = $columns[$orderColumnIndex];

    // Base query
    $baseQuery = "FROM transactions";
    $whereClause = "";

    // Search filter
    $params = [];
    if (!empty($searchValue)) {
        $whereClause = " WHERE (transaction_id LIKE :search 
                          OR account_number LIKE :search 
                          OR transaction_type LIKE :search 
                          OR amount LIKE :search 
                          OR related_account LIKE :search 
                          OR transaction_date LIKE :search 
                          OR reference_number LIKE :search)";
        $params[':search'] = "%$searchValue%";
    }

    // Total records count
    $totalRecords = $pdo->query("SELECT COUNT(*) FROM transactions")->fetchColumn();

    // Filtered count query
    $countQuery = "SELECT COUNT(*) $baseQuery $whereClause";
    $stmtCount = $pdo->prepare($countQuery);
    if (!empty($searchValue)) {
        $stmtCount->bindValue(':search', $params[':search']);
    }
    $stmtCount->execute();
    $filteredRecords = $stmtCount->fetchColumn();

    // Main data query
    $query = "SELECT transaction_id, 
                    account_number, 
                    transaction_type,
                    amount,
                    COALESCE(related_account, 'N/A') AS related_account,
                    DATE_FORMAT(transaction_date, '%d %b %Y %H:%i') AS formatted_date,
                    reference_number 
              $baseQuery 
              $whereClause 
              ORDER BY $orderColumn $orderDir 
              LIMIT :start, :length";

    $stmt = $pdo->prepare($query);

    // Bind parameters
    if (!empty($searchValue)) {
        $stmt->bindValue(':search', $params[':search']);
    }
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);
    $stmt->execute();

    // Format data
    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'transaction_id' => $row['transaction_id'],
            'account_number' => $row['account_number'],
            'transaction_type' => ucfirst($row['transaction_type']),
            'amount' => (float)$row['amount'], 
            'related_account' => $row['related_account'],
            'transaction_date' => $row['formatted_date'],
            'reference_number' => $row['reference_number']
        ];
    }

    // Return JSON response
    echo json_encode([
        'draw' => intval($draw),
        'recordsTotal' => intval($totalRecords),
        'recordsFiltered' => intval($filteredRecords),
        'data' => $data
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error: ' . $e->getMessage(),
        'trace' => $e->getTrace()
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Application error: ' . $e->getMessage()
    ]);
}