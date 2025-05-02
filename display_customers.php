<?php
include 'database.php';

$columns = ['c.first_name', 'c.last_name', 'a.account_number', 'a.account_type', 'c.phone', 'a.opening_date'];

$start = $_POST['start'] ?? 0;
$length = $_POST['length'] ?? 10;
$searchValue = $_POST['search']['value'] ?? '';
$orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'ASC';

// Get actual column name for ordering
$orderColumn = $columns[$orderColumnIndex];

$query = "SELECT c.*, a.account_number, a.account_type, a.opening_date
          FROM customers c 
          JOIN accounts a ON c.id = a.customer_id";

$countQuery = "SELECT COUNT(*) FROM customers c JOIN accounts a ON c.id = a.customer_id";

// Apply search filter
$params = [];
if (!empty($searchValue)) {
    $query .= " WHERE (c.first_name LIKE :search 
                      OR c.last_name LIKE :search 
                      OR a.account_number LIKE :search 
                      OR c.phone LIKE :search)";
    
    $countQuery .= " WHERE (c.first_name LIKE :search 
                          OR c.last_name LIKE :search 
                          OR a.account_number LIKE :search 
                          OR c.phone LIKE :search)";

    $params[':search'] = "%$searchValue%";
}

// Sorting
$query .= " ORDER BY $orderColumn $orderDir";

// Pagination
$query .= " LIMIT :start, :length";

try {
    // Get filtered count
    $stmtCount = $pdo->prepare($countQuery);
    if (!empty($searchValue)) {
        $stmtCount->bindValue(':search', "%$searchValue%");
    }
    $stmtCount->execute();
    $filteredRecords = $stmtCount->fetchColumn();

    // Get actual data
    $stmt = $pdo->prepare($query);
    if (!empty($searchValue)) {
        $stmt->bindValue(':search', "%$searchValue%");
    }
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get total records count
    $totalRecords = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();

    // Format response
    $response = [
        "draw" => intval($_POST['draw'] ?? 1),
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $filteredRecords,
        "data" => $data
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
