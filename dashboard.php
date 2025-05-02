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
    <title>Dashboard</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
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
                            <a href="dashboard.php" class="active">
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
                <h1>Dashboard</h1>

                <div class="insights">
                    <div class="user">
                        <span class="material-symbols-sharp">group</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Customers</h3>
                                <h1 id="totalCustomers">Loading...</h1>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                    <!-- End of user -->

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

                </div>
                <!-- End of Insights -->

                <h2 class="mt-4 mb-3 fs-4 fw-bold">Recent Transaction</h2>

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
     </div>

        </section>
    </div>

    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/index.js"></script>
</body>

</html>