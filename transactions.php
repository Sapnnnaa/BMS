<?php
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['loggedin']) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Management</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">  
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <div class="main-wrapper">
        <div class="header-container fixed-top">
            <header class="header navbar navbar-expand-sm expand-header">
                <div class="header-left d-flex">
                    <div class="logo">
                        BANKING
                    </div>
                </div>


                <ul class="navbar-item flex-row ml-auto">
                    <div class="theme-toggler">
                        <span class="material-symbols-sharp active">light_mode</span>
                        <span class="material-symbols-sharp">dark_mode</span>
                    </div>

                </ul>
            </header>


            <div class="left-menu">
                <div class="menubar-content">
                    <nav class="animated bounceInDown">
                        <div class="sidebar">
                            <a href="dashboard.php">
                                <span class="material-symbols-sharp">grid_view</span>
                                <h3>Dashboard</h3>
                            </a>

                            <a href="customer.php">
                                <span class="material-symbols-sharp">group</span>
                                <h3>Customer Management</h3>
                            </a>

                            <a href="account.php">
                                <span class="material-symbols-sharp">account_balance</span>
                                <h3>Account Management</h3>
                            </a>

                            <a href="transactions.php" class="active">
                                <span class="material-symbols-sharp">payments</span>
                                <h3>Transaction</h3>
                            </a>

                            <a href="logout.php" id="logoutBtn">
                                <span class="material-symbols-sharp">logout</span>
                                <h3>Logout</h3>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>

        </div>

        <div class="content-wrapper">
            <section class="dashboard-top">
                <h1>Transaction Management</h1>

                <div class="insights">
                    <div class="transaction">
                        <span class="material-symbols-sharp">payments</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Transaction</h3>
                                <h1 id="totalTransactions">Loading...</h1>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                    <!-- End of transaction  -->

                    <div class="balance">
                        <span class="material-symbols-sharp">account_balance_wallet</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Balance</h3>
                                <h1 id="totalBalance">Loading...</h1>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                    <!-- End of balance  -->

                </div>
                <!-- End of Insights -->

                <!-- Add transaction Button -->
                <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#transactionModal">
                    New Transaction
                </button>

                <!-- Transaction Modal -->
                <div class="modal fade" id="transactionModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">New Transaction</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="transactionForm">
                                    <!-- Transaction Type -->
                                    <div class="mb-3">
                                        <label class="form-label">Transaction Type</label>
                                        <select class="form-select" id="transactionType" required>
                                            <option value="">Select Transaction</option>
                                            <option value="deposit">Deposit</option>
                                            <option value="withdraw">Withdrawal</option>
                                            <option value="transfer">Transfer</option>
                                        </select>
                                    </div>

                                    <!-- Account Number -->
                                    <div class="mb-3">
                                        <label class="form-label">Account Number</label>
                                        <input type="text" class="form-control" id="transactionAccount"
                                            name="account_number" required pattern="[A-Z0-9]{12}"
                                            title="12-digit account number">
                                    </div>

                                    <!-- Recipient Account (Only for Transfers) -->
                                    <div class="mb-3 transfer-field" style="display: none;">
                                        <label class="form-label">Recipient Account</label>
                                        <input type="text" class="form-control" id="recipientAccount"
                                            name="recipient_account" pattern="[A-Z0-9]{12}"
                                            title="12-digit account number">
                                    </div>

                                    <!-- Amount -->
                                    <div class="mb-3">
                                        <label class="form-label">Amount (₹)</label>
                                        <input type="number" class="form-control" id="transactionAmount" name="amount"
                                            min="1" step="0.01" required>
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" id="transactionDesc" name="description"
                                            rows="2"></textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Process Transaction</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="mt-4 mb-3 fs-4 fw-bold">Transaction History</h2>

                <table id="transactionTable" class="table mt-5 w-100">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Account Number</th>
                            <th>Type</th>
                            <th>Amount (₹)</th>
                            <th>Related Account</th>
                            <th>Date & Time</th>
                            <th>Reference No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated dynamically -->
                         
                    </tbody>
                </table>
            </section>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/index.js"></script>   
</body>

</html>