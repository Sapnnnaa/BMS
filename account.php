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
    <title>Account Management</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- DataTables CSS -->
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

                            <a href="account.php" class="active">
                                <span class="material-symbols-sharp">account_balance</span>
                                <h3>Account Management</h3>
                            </a>

                            <a href="transactions.php">
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
                <h1>Account Management</h1>

                <div class="insights">
                    <div class="account">
                        <span class="material-symbols-sharp">account_balance</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Account</h3>
                                <h1 id="totalAccounts">Loading...</h1>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>

                    <!-- end of accounts -->

                    <div class="account">
                        <span class="material-symbols-sharp">account_balance</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Active Account</h3>
                                <h1 id="activeAccounts">Loading...</h1>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>

                    <!-- end of accounts -->

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


                <button class="btn btn-primary mt-4 mb-3" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                    Create New Account
                </button>

                <!-- Add Account Modal -->

                <div class="modal fade" id="addAccountModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Open New Account</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="accountForm">
                                    <!-- Customer Search Section -->
                                    <div class="mb-3">
                                        <label class="form-label">Search Customer</label>
                                        <input type="text" class="form-control" id="customerSearch"
                                            placeholder="Enter Customer ID or Name">
                                            <div id="searchResults" class="list-group mt-2 d-none"></div>
                                        <input type="hidden" id="selectedCustomerId" name="customer_id">
                                    </div>

                                    <!-- Account Details -->
                                    <div class="mb-3">
                                        <label class="form-label">Account Type</label>
                                        <select class="form-select" name="accountType" id="accountType" required>
                                            <option value="savings">Savings</option>
                                            <option value="current">Current</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Initial Deposit (₹)</label>
                                        <input type="number" class="form-control"  id="initialDeposit" name="initial_deposit" min="500"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Branch</label>
                                        <select class="form-select" name="branch" id="branch"  required>
                                            <option value="1">Golmuri</option>
                                            <option value="2">Sakchi</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Opening Date</label>
                                        <input type="date" class="form-control" name="opening_date"  id="openingDate"required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="createAccountBtn">Create
                                    Account</button>
                            </div>
                        </div>
                    </div>
                </div>


                
            </section>
        </div>

    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/index.js"></script>
</body>

</html>