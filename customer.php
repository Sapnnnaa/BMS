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
    <title>Customer Management</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

                            <a href="customer.php" class="active">
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
            <div>
                <section class="dashboard-top">
                    <h1>Customer Management</h1>

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

                    </div>
                    <!-- End of Insights -->


                    <button class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#userDetailsModal">
                        Add Customer
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userDetailsModalLabel">Customer Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="userForm" novalidate>
                                        <input type="hidden" id="customerId" name="customerId">
                                        <!-- Pills Navigation -->
                                        <nav class="mb-4">
                                            <div class="nav nav-pills" id="nav-tab" role="tablist">
                                                <button class="nav-link active" id="nav-personal-tab"
                                                    data-bs-toggle="tab" data-bs-target="#nav-personal" type="button"
                                                    role="tab">Personal Details</button>
                                                <button class="nav-link" id="nav-additional-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-additional" type="button" role="tab"
                                                    disabled>Additional Details</button>
                                                <button class="nav-link" id="nav-account-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-account" type="button" role="tab"
                                                    disabled>Account Details</button>
                                            </div>
                                        </nav>

                                        <!-- Pills Content -->
                                        <div class="tab-content" id="nav-tabContent">
                                            <!-- Personal Details Tab -->
                                            <div class="tab-pane fade show active" id="nav-personal" role="tabpanel">
                                                
                                                <div class="row g-3">
                                                    <!-- Name Section -->
                                                    <div class="col-12">
                                                        <h6 class="mb-3">Name Details</h6>
                                                        <div class="row g-3">
                                                            <!-- Prefix -->
                                                            <div class="col-md-2">
                                                                <label class="form-label">Prefix</label>
                                                                <select class="form-select" name="prefix">
                                                                    <option>Mr.</option>
                                                                    <option>Mrs.</option>
                                                                    <option>Miss</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-5">
                                                                <label class="form-label">First Name</label>
                                                                <input type="text" class="form-control" id="firstname"
                                                                    name="firstname">
                                                                <div class="invalid-feedback" id="error-firstname">
                                                                    Please enter your first name.</div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label class="form-label">Last Name</label>
                                                                <input type="text" class="form-control" id="lastname"
                                                                    name="lastname">
                                                                <div class="invalid-feedback" id="error-lastname">Please
                                                                    enter your last name.</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email"
                                                            name="email">
                                                        <div class="invalid-feedback" id="error-email">Please enter a
                                                            valid email.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Phone</label>
                                                        <input type="tel" class="form-control" id="phone" name="phone"
                                                            pattern="[0-9]{10}">
                                                        <div class="invalid-feedback" id="error-phone">Please enter a
                                                            valid 10-digit phone number.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Date of Birth</label>
                                                        <input type="date" class="form-control" id="dob" name="dob">
                                                        <div class="invalid-feedback" id="error-dob">Please enter a
                                                            valid dob.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Gender</label>
                                                        <select class="form-select" id="gender" name="gender">
                                                            <option value="" selected disabled>Select gender</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>
                                                        <div class="invalid-feedback" id="error-gender">Please enter a
                                                            valid gender.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nationality</label>
                                                        <input type="text" class="form-control" id="nationality"
                                                            name="nationality">
                                                        <div class="invalid-feedback" id="error-nationality">Please
                                                            enter a valid nationality.</div>
                                                    </div>

                                                    <!-- Address Details -->
                                                    <div class="col-12 mt-4">
                                                        <h6 class="mb-3">Address Details</h6>
                                                        <div class="row g-3">
                                                            <!-- Street Address -->
                                                            <div class="col-12">
                                                                <label class="form-label">Street Address</label>
                                                                <input type="text" class="form-control" id="address"
                                                                    name="address">
                                                                <div class="invalid-feedback" id="error-address">Please
                                                                    enter a valid address.</div>
                                                            </div>

                                                            <!-- City + ZIP Code -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">City</label>
                                                                <input type="text" class="form-control" id="city"
                                                                    name="city">
                                                                <div class="invalid-feedback" id="error-city">Please
                                                                    enter a valid city.</div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label class="form-label">ZIP Code</label>
                                                                <input type="text" class="form-control" id="zip_code"
                                                                    name="zip_code">
                                                                <div class="invalid-feedback" id="error-code">Please
                                                                    enter a valid zip code.</div>
                                                            </div>

                                                            <!-- State/Region -->
                                                            <div class="col-md-3">
                                                                <label class="form-label">State/Region</label>
                                                                <input type="text" class="form-control" id="state"
                                                                    name="state">
                                                                <div class="invalid-feedback" id="error-state">Please
                                                                    enter a valid state.</div>
                                                            </div>

                                                            <!-- Country -->
                                                            <div class="col-md-6">
                                                                <label class="form-label">Country</label>
                                                                <select class="form-select" id="country" name="country">
                                                                    <option value="" selected disabled>Select country
                                                                    </option>
                                                                    <option value="US">United States</option>
                                                                    <option value="IN">India</option>
                                                                    <option value="UK">United Kingdom</option>
                                                                    <option value="CA">Canada</option>
                                                                </select>
                                                                <div class="invalid-feedback" id="error-country">Please
                                                                    enter a valid country.</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Navigation Buttons -->
                                                <div class="d-flex justify-content-end mt-4">
                                                    <button type="button" class="btn btn-primary next-tab">Next</button>
                                                </div>
                                            </div>

                                            <!-- Additional Details Tab -->
                                            <div class="tab-pane fade" id="nav-additional" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Category</label>
                                                        <select class="form-select" id="category" name="category">
                                                            <option value="" selected disabled>Select category</option>
                                                            <option value="general">General</option>
                                                            <option value="sc">SC</option>
                                                            <option value="st">ST</option>
                                                            <option value="obc">OBC</option>
                                                        </select>
                                                        <div class="invalid-feedback" id="error-category">Please select
                                                            a category.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Education Qualification</label>
                                                        <input type="text" class="form-control" id="qualification"
                                                            name="qualification">
                                                        <div class="invalid-feedback" id="error-qualification">Please
                                                            enter your qualification.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Occupation</label>
                                                        <select class="form-select" id="occupation" name="occupation">
                                                            <option value="" selected disabled>Select occupation
                                                            </option>
                                                            <option value="salaried">Salaried</option>
                                                            <option value="employee">Self-employee</option>
                                                            <option value="student">Student</option>
                                                            <option value="retired">Retired</option>
                                                        </select>
                                                        <div class="invalid-feedback" id="error-occupation">Please
                                                            select your occupation.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Annual Income</label>
                                                        <input type="text" class="form-control" id="annual_income"
                                                            name="annual_income">
                                                        <div class="invalid-feedback" id="error-income">Please enter
                                                            your annual income.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Pan Card Number</label>
                                                        <input type="text" class="form-control" id="pan_card"
                                                            name="pan_card">
                                                        <div class="invalid-feedback" id="error-pancard">Please enter
                                                            your pan card number.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Aadhar Card Number</label>
                                                        <input type="text" class="form-control" id="aadhar_number"
                                                            name="aadhar_number">
                                                        <div class="invalid-feedback" id="error-aadharnumber">Please
                                                            enter your aadhar card number.</div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between mt-4">
                                                    <button type="button" class="btn btn-primary next-tab">Next</button>
                                                </div>
                                            </div>

                                            <!-- Account Details Tab -->
                                            <div class="tab-pane fade" id="nav-account" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Account Type</label>
                                                        <select class="form-select" id="accountType" name="accountType">
                                                            <option value="" selected disabled>Select account type
                                                            </option>
                                                            <option value="savings">Savings</option>
                                                            <option value="current">Current</option>
                                                        </select>
                                                        <div class="invalid-feedback" id="error-accountType">Please
                                                            select an account type.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Opening Date</label>
                                                        <input type="date" class="form-control" id="opening_date"
                                                            name="opening_date">
                                                        <div class="invalid-feedback" id="error-openingdate">Please
                                                            enter date.</div>
                                                    </div>
                                                    <div class="col-md-6">

                                                        <label class="form-label">Branch</label>
                                                        <select class="form-select" id="branch" name="branch">
                                                            <option value="" selected disabled>Select Branch
                                                            </option>
                                                            <option value="1">Golmuri</option>
                                                            <option value="2">Sakchi</option>
                                                        </select>
                                                        <div class="invalid-feedback" id="error-branch">Please select
                                                            branch.</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Initial Deposit Amount</label>
                                                        <input type="number" class="form-control" id="initial_deposit"
                                                            name="initial_deposit">
                                                        <div class="invalid-feedback" id="error-deposit">Please enter an
                                                            initial deposit amount.</div>
                                                    </div>
                                                </div>


                                                <div class="d-flex justify-content-between mt-4">
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Display Generated Account Number -->
                                    <div id="accountNumberDisplay" style="display: none;">
                                        <strong>Account Number:</strong> <span id="generatedAccountNumber"></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View Customer Modal -->
                    <div class="modal fade" id="viewCustomerModal" tabindex="-1"
                        aria-labelledby="viewCustomerModalLabel">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewCustomerModalLabel">Customer Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <nav class="mb-4">
                                        <div class="nav nav-pills" id="viewNavTab" role="tablist">
                                            <button class="nav-link active" data-bs-toggle="tab"
                                                data-bs-target="#view-personal">Personal</button>
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#view-additional">Additional</button>
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#view-account">Account</button>
                                        </div>
                                    </nav>
                                    <div class="tab-content">
                                        <!-- Personal Details -->
                                        <div class="tab-pane fade show active" id="view-personal">
                                            <div class="row g-3">
                                                <div class="col-md-2">
                                                    <label class="fw-bold">Prefix:</label>
                                                    <p id="view-prefix"></p>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="fw-bold">First Name:</label>
                                                    <p id="view-firstname"></p>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="fw-bold">Last Name:</label>
                                                    <p id="view-lastname"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Email:</label>
                                                    <p id="view-email"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Phone:</label>
                                                    <p id="view-phone"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Date of Birth:</label>
                                                    <p id="view-dob"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Gender:</label>
                                                    <p id="view-gender"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Nationality:</label>
                                                    <p id="view-nationality"></p>
                                                </div>
                                                <div class="col-12">
                                                    <label class="fw-bold">Address:</label>
                                                    <p id="view-address"></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="fw-bold">City:</label>
                                                    <p id="view-city"></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="fw-bold">ZIP Code:</label>
                                                    <p id="view-zip"></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="fw-bold">State:</label>
                                                    <p id="view-state"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Country:</label>
                                                    <p id="view-country"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional Details -->
                                        <div class="tab-pane fade" id="view-additional">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Category:</label>
                                                    <p id="view-category"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Qualification:</label>
                                                    <p id="view-qualification"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Occupation:</label>
                                                    <p id="view-occupation"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Annual Income:</label>
                                                    <p id="view-income"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">PAN Number:</label>
                                                    <p id="view-pan"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Aadhar Number:</label>
                                                    <p id="view-aadhar"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Account Details -->
                                        <div class="tab-pane fade" id="view-account">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Account Number:</label>
                                                    <p id="view-accountNumber"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Account Type:</label>
                                                    <p id="view-accountType"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Opening Date:</label>
                                                    <p id="view-openingDate"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Branch:</label>
                                                    <p id="view-branch"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Initial Deposit:</label>
                                                    <p id="view-deposit"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <h2 class="mt-3 mb-3 fs-4 fw-bold">Customer Details</h2>

            <table id="myTable" class="table mt-5 w-100">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>Account type</th>
                        <th>Phone Number</th>
                        <th>Opening Dates</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
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