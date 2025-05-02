$(document).ready(function () {

    const themeToggler = document.querySelector('.theme-toggler');

    const applyTheme = (isDark) => {
        if (isDark) {
            document.body.classList.add('dark-theme-variables');
            if (themeToggler) {
                const lightIcon = themeToggler.querySelector('span:nth-child(1)');
                const darkIcon = themeToggler.querySelector('span:nth-child(2)');
                if (lightIcon && darkIcon) {
                    lightIcon.classList.remove('active');
                    darkIcon.classList.add('active');
                }
            }
        } else {
            document.body.classList.remove('dark-theme-variables');
            if (themeToggler) {
                const lightIcon = themeToggler.querySelector('span:nth-child(1)');
                const darkIcon = themeToggler.querySelector('span:nth-child(2)');
                if (lightIcon && darkIcon) {
                    lightIcon.classList.add('active');
                    darkIcon.classList.remove('active');
                }
            }
        }
    };

    // Check for saved theme preference
    const savedTheme = localStorage.getItem('darkTheme');
    const isDarkTheme = savedTheme === 'true';

    // Apply the saved theme preference
    applyTheme(isDarkTheme);

    // Add event listener to the theme toggler (if it exists)
    if (themeToggler) {
        themeToggler.addEventListener('click', () => {
            // Toggle the dark theme
            const isDark = !document.body.classList.contains('dark-theme-variables');
            applyTheme(isDark);

            // Save the theme preference in localStorage
            localStorage.setItem('darkTheme', isDark);
        });
    }


    const form = document.getElementById('userForm');
    const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');

    const elements = {
        personal: {
            firstname: document.getElementById('firstname'),
            lastname: document.getElementById('lastname'),
            email: document.getElementById('email'),
            phone: document.getElementById('phone'),
            dob: document.getElementById('dob'),
            gender: document.getElementById('gender'),
            nationality: document.getElementById('nationality'),
            address: document.getElementById('address'),
            city: document.getElementById('city'),
            zip_code: document.getElementById('zip_code'),
            state: document.getElementById('state'),
            country: document.getElementById('country')
        },

        additional: {
            category: document.getElementById('category'),
            qualification: document.getElementById('qualification'),
            occupation: document.getElementById('occupation'),
            annual_income: document.getElementById('annual_income'),
            pan_card: document.getElementById('pan_card'),
            aadhar_number: document.getElementById('aadhar_number')
        },
        account: {
            accountType: document.getElementById('accountType'),
            branch: document.getElementById('branch'),
            opening_date: document.getElementById('opening_date'),
            initial_deposit: document.getElementById('initial_deposit')
        }
    };

    const validators = {
        personal: function () {
            let isValid = true;
            const fields = elements.personal;

            //first name 
            if (!fields.firstname.value.trim()) {
                showError(fields.firstname, 'error-firstname', 'First name is required');
                isValid = false;
            } else {
                clearError(fields.firstname, 'error-firstname');
            }

            //last name
            if (!fields.lastname.value.trim()) {
                showError(fields.lastname, 'error-lastname', 'Last name is required');
                isValid = false;
            } else {
                clearError(fields.lastname, 'error-lastname');
            }

            //email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(fields.email.value)) {
                showError(fields.email, 'error-email', 'Invalid email format');
                isValid = false;
            } else {
                clearError(fields.email, 'error-email');
            }

            //phone        
            const phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(fields.phone.value)) {
                showError(fields.phone, 'error-phone', '10-digit number required');
                isValid = false;
            } else {
                clearError(fields.phone, 'error-phone');
            }

            // Date of Birth (Minimum 18 years)
            const dobDate = new Date(fields.dob.value);
            const age = new Date().getFullYear() - dobDate.getFullYear();
            if (!fields.dob.value || age < 18) {
                showError(fields.dob, 'error-dob', 'Must be at least 18 years old');
                isValid = false;
            } else {
                clearError(fields.dob, 'error-dob');
            }


            // Gender
            if (!fields.gender.value) {
                showError(fields.gender, 'error-gender', 'Gender is required');
                isValid = false;
            } else {
                clearError(fields.gender, 'error-gender');
            }

            // Nationality (text input)
            if (!fields.nationality.value.trim()) {
                showError(fields.nationality, 'error-nationality', 'Nationality is required');
                isValid = false;
            } else if (!/^[A-Za-z\s\-']+$/i.test(fields.nationality.value)) {
                showError(fields.nationality, 'error-nationality', 'Only letters and spaces allowed');
                isValid = false;
            } else {
                clearError(fields.nationality, 'error-nationality');
            }


            // Address
            if (!fields.address.value.trim()) {
                showError(fields.address, 'error-address', 'Address is required');
                isValid = false;
            } else {
                clearError(fields.address, 'error-address');
            }

            // City
            if (!fields.city.value.trim()) {
                showError(fields.city, 'error-city', 'City is required');
                isValid = false;
            } else {
                clearError(fields.city, 'error-city');
            }

            // ZIP Code
            if (!/^\d+$/.test(fields.zip_code.value)) {
                showError(fields.zip_code, 'error-code', 'Invalid ZIP code');
                isValid = false;
            } else {
                clearError(fields.zip_code, 'error-code');
            }


            // State/Region
            if (!fields.state.value.trim()) {
                showError(fields.state, 'error-state', 'State/Region is required');
                isValid = false;
            } else if (!/^[A-Za-z\s\-'.()]+$/i.test(fields.state.value)) {
                showError(fields.state, 'error-state', 'Invalid state format');
                isValid = false;
            } else {
                clearError(fields.state, 'error-state');
            }

            // Country
            if (!fields.country.value) {
                showError(fields.country, 'error-country', 'Country is required');
                isValid = false;
            } else {
                clearError(fields.country, 'error-country');
            }

            return isValid;
        },

        additional: function () {
            let isValid = true;
            const fields = elements.additional;

            // Category
            if (!fields.category.value) {
                showError(fields.category, 'error-category', 'Category is required');
                isValid = false;
            } else {
                clearError(fields.category, 'error-category');
            }

            // Qualification
            if (!fields.qualification.value.trim()) {
                showError(fields.qualification, 'error-qualification', 'Qualification is required');
                isValid = false;
            } else {
                clearError(fields.qualification, 'error-qualification');
            }

            // Occupation
            if (!fields.occupation.value) {
                showError(fields.occupation, 'error-occupation', 'Occupation is required');
                isValid = false;
            } else {
                clearError(fields.occupation, 'error-occupation');
            }

            // Annual Income
            const incomeValue = parseFloat(fields.annual_income.value);
            if (!fields.annual_income.value.trim()) {
                showError(fields.annual_income, 'error-income', 'Annual income is required');
                isValid = false;
            } else if (isNaN(incomeValue)) {
                showError(fields.annual_income, 'error-income', 'Must be a valid number');
                isValid = false;
            } else if (incomeValue <= 0) {
                showError(fields.annual_income, 'error-income', 'Must be greater than 0');
                isValid = false;
            } else if (incomeValue > 100000000) {
                showError(fields.annual_income, 'error-income', 'Amount too large');
                isValid = false;
            } else {
                clearError(fields.annual_income, 'error-income');
            }

            // PAN Card
            const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]$/i;
            if (!panRegex.test(fields.pan_card.value)) {
                showError(fields.pan_card, 'error-panumber', 'Invalid PAN format');
                isValid = false;
            } else {
                clearError(fields.pan_card, 'error-panumber');
            }

            // Aadhar
            if (!/^\d{12}$/.test(fields.aadhar_number.value)) {
                showError(fields.aadhar_number, 'error-aadharnumber', '12 digits required');
                isValid = false;
            } else {
                clearError(fields.aadhar_number, 'error-aadharnumber');
            }

            return isValid;
        },
        account: function () {
            let isValid = true;
            const fields = elements.account;

            // Account Type
            if (!fields.accountType.value) {
                showError(fields.accountType, 'error-account', 'Account type is required');
                isValid = false;
            } else {
                clearError(fields.accountType, 'error-account');
            }

            // Branch
            if (!fields.branch.value) {
                showError(fields.branch, 'error-branch', 'Please select a branch.');
                isValid = false;
            } else {
                clearError(fields.branch, 'error-branch');
            }

            // Opening Date
            const openingDateValue = fields.opening_date.value;

            if (!openingDateValue) {
                showError(fields.opening_date, 'error-open', 'Please enter an opening date.');
                isValid = false;
            } else {
                clearError(fields.opening_date, 'error-open');
            }

            // Initial Deposit Amount
            const depositValue = parseFloat(fields.initial_deposit.value);
            if (isNaN(depositValue) || depositValue <= 0) {
                showError(fields.initial_deposit, 'error-amount', 'Please enter a positive amount.');
                isValid = false;
            } else {
                clearError(fields.initial_deposit, 'error-amount');
            }

            return isValid;
        }
    };

    // Helper Functions
    function showError(field, errorId, message) {
        field.classList.add('is-invalid'); // Add invalid class to the field
        const errorElement = document.getElementById(errorId);
        if (errorElement) {
            errorElement.textContent = message; // Set the error message
        } else {
            console.error(`Error element with id "${errorId}" not found.`);
        }
    }

    function clearError(field, errorId) {
        field.classList.remove('is-invalid');
        const errorElement = document.getElementById(errorId);
        if (errorElement) {
            errorElement.textContent = ''; // Clear the error message
        } else {
            console.error(`Error element with id "${errorId}" not found.`);
        }
    }

    // Tab Navigation with Validation
    document.querySelectorAll('.next-tab').forEach(button => {
        button.addEventListener('click', function (e) {
            const activeTab = document.querySelector('.tab-pane.active');
            let isValid = true;

            // Validate the current tab
            if (activeTab.id === 'nav-personal') {
                isValid = validators.personal();
            } else if (activeTab.id === 'nav-additional') {
                isValid = validators.additional();
            }

            // If the current tab is valid, enable the next tab
            if (isValid) {
                const nextTab = button.closest('.tab-pane').nextElementSibling;
                const nextTabTrigger = document.querySelector(`[data-bs-target="#${nextTab.id}"]`);

                // Enable the next tab
                nextTabTrigger.removeAttribute('disabled');

                // Switch to the next tab
                new bootstrap.Tab(nextTabTrigger).show();
            }
        });
    });

    // Prevent Manual Tab Switching
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', function (e) {
            if (this.hasAttribute('disabled')) {
                e.preventDefault();
                alert('Please complete the previous tab first.');
            }
        });
    });


    // Form Submission
    $("#userForm").submit(function (e) {
        e.preventDefault();

        const isPersonalValid = validators.personal();
        const isAdditionalValid = validators.additional();
        const isAccountValid = validators.account();

        if (isPersonalValid && isAdditionalValid && isAccountValid) {

            console.log($('#userForm').serializeArray());
            const customerId = $('#customerId').val(); 
            const isEdit = customerId !== ''; // Check for non-empty string

            
            const formData = $(this).serialize() + (isEdit ? `&customerId=${customerId}` : '');

            $.ajax({
                url: isEdit ? 'update_customers.php' : 'submit_form.php',
                method: isEdit ? 'PUT' : 'POST',
                data: formData,
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert(isEdit ? 'Customer updated successfully!' : 'Customer created successfully!');
                        $('#userDetailsModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload(null, false);
                    } else {
                        alert('Operation failed: ' + res.message);
                    }
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseText);

                }
            })
            // $('#userDetailsModal').modal('hide');
            // alert('Form submitted successfully!');
        }
    });


    // Reset form on modal close
    $('#userDetailsModal').on('hidden.bs.modal', () => {
        // Reset form and clear validation
        document.getElementById('userForm').reset();
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    });

    //display data
    const dataTable = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'display_customers.php',
            type: 'POST'
        },
        columns: [
            {
                data: 'name',
                render: function (data, type, row) {
                    return `${row.first_name} ${row.last_name}`;
                }
            },
            { data: 'account_number' },
            {
                data: 'account_type',
                render: function (data) {
                    return data.charAt(0).toUpperCase() + data.slice(1);
                }
            },
            { data: 'phone' },
            {
                data: 'opening_date',
                render: function (data) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info view-btn" data-id="${row.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                         <button class="btn btn-sm btn-danger delete-btn" data-account-number="${row.account_number}">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                }
            }
        ],

        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthMenu: [5, 10, 25, 50], // Define page length options
        pageLength: 5, // Default page length
        responsive: true,
        language: {
            search: "Search:",
            paginate: {
                next: "Next",
                previous: "Previous"
            }
        }
    });

    // Refresh Table after form submission
    $('#userDetailsModal').on('hidden.bs.modal', function () {
        updateDashboardTotals();
        dataTable.ajax.reload();
    });


    // Delete Customer Handler
    $('#myTable').on('click', '.delete-btn', function () {
        const accountNumber = $(this).data('account-number'); 
        const row = $(this).closest('tr');

        if (confirm('Are you sure you want to delete this account?')) {
            $.ajax({
                url: 'delete_account.php',
                method: 'DELETE',
                contentType: 'application/json',
                data: JSON.stringify({ account_number: accountNumber }), 
                success: function (response) {
                    dataTable.row(row).remove().draw(false);
                    updateDashboardTotals();
                    alert('Account deleted successfully');
                },
                error: function (xhr) {
                    alert('Error deleting account: ' + xhr.responseText);
                }
            });
        }
    });

    // View Customer Details Handler
    $('#myTable').on('click', '.view-btn', function () {
        const customerId = $(this).data('id');

        // Define formatting functions FIRST
        const format = (value) => value || 'N/A';
        const formatCurrency = (value) => value ? '₹' + value : 'N/A';
        const formatDate = (dateString) => dateString ? new Date(dateString).toLocaleDateString() : 'N/A';

        $.ajax({
            url: 'get_customers.php',
            method: 'GET',
            dataType: 'json',
            data: { id: customerId },
            success: function (response) {

                $('#view-prefix').text(format(response.prefix));
                $('#view-firstname').text(format(response.first_name));
                $('#view-lastname').text(format(response.last_name));
                $('#view-email').text(format(response.email));
                $('#view-phone').text(format(response.phone));
                $('#view-dob').text(formatDate(response.dob));
                $('#view-gender').text(format(response.gender));
                $('#view-nationality').text(format(response.nationality));
                $('#view-address').text(format(response.address));
                $('#view-city').text(format(response.city));
                $('#view-zip').text(format(response.zip_code));
                $('#view-state').text(format(response.state));
                $('#view-country').text(format(response.country));
                $('#view-category').text(format(response.category));
                $('#view-qualification').text(format(response.qualification));
                $('#view-occupation').text(format(response.occupation));
                $('#view-income').text(formatCurrency(response.annual_income));
                $('#view-pan').text(format(response.pan_card));
                $('#view-aadhar').text(format(response.aadhar_number));
                $('#view-accountNumber').text(format(response.account_number));
                $('#view-accountType').text(
                    response.account_type ?
                        response.account_type.charAt(0).toUpperCase() + response.account_type.slice(1) :
                        'N/A'
                );
                $('#view-openingDate').text(formatDate(response.opening_date));
                $('#view-branch').text(format(response.branch_name));
                $('#view-deposit').text(formatCurrency(response.initial_deposit));

                $('#viewCustomerModal').modal('show');
            },
            error: function (xhr) {
                alert('Error fetching customer details: ' + xhr.responseText);
            }
        });
    });

    // Edit Customer 
    $('#myTable').on('click', '.edit-btn', function () {
        const customerId = $(this).data('id');

        $.ajax({
            url: 'get_customers.php',
            method: 'GET',
            dataType: 'json',
            data: { id: customerId },
            success: function (response) {
                // Set hidden customer ID
                $('#customerId').val(response.id);

                // Populate form fields
                $('#firstname').val(response.first_name);
                $('#lastname').val(response.last_name);
                $('#email').val(response.email);
                $('#phone').val(response.phone);
                $('#dob').val(response.dob);
                $('#gender').val(response.gender);
                $('#nationality').val(response.nationality);
                $('#address').val(response.address);
                $('#city').val(response.city);
                $('#zip_code').val(response.zip_code);
                $('#state').val(response.state);
                $('#country').val(response.country);
                $('#category').val(response.category);
                $('#qualification').val(response.qualification);
                $('#occupation').val(response.occupation);
                $('#annual_income').val(response.annual_income);
                $('#pan_card').val(response.pan_card);
                $('#aadhar_number').val(response.aadhar_number);
                $('#accountType').val(response.account_type);
                $('#branch').val(response.branch_id);
                $('#opening_date').val(response.opening_date);
                $('#initial_deposit').val(response.initial_deposit);

                // Enable all tabs
                $('#nav-additional-tab, #nav-account-tab')
                    .removeClass('disabled')
                    .removeAttr('disabled');

                // Change modal title
                $('#userDetailsModalLabel').text('Edit Customer');
                $('#userDetailsModal').modal('show');
            },
            error: function (xhr) {
                alert('Error fetching customer details: ' + xhr.responseText);
            }
        });
    });



    let searchTimeout;

    // Customer Search
    $('#customerSearch').on('input', function () {
        clearTimeout(searchTimeout);
        const searchTerm = $(this).val().trim();
        const resultsContainer = $('#searchResults');

        resultsContainer.addClass('d-none').empty();

        if (searchTerm.length < 2) {
            $('#selectedCustomerId').val('');
            return;
        }

        searchTimeout = setTimeout(() => {
            $.ajax({
                url: 'fetch_customers.php',
                method: 'POST',
                data: { search: searchTerm },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response.status === 'success') {
                        showSearchResults(response.data);
                    }
                },
                error: function (xhr) {
                    console.error('Search error:', xhr.responseText);
                }
            });
        }, 300);
    });
    // Show Results
    function showSearchResults(customers) {
        const container = $('#searchResults');
        container.empty();

        if (customers.length === 0) {
            container.append('<div class="list-group-item">No customers found</div>');
        } else {
            customers.forEach(customer => {
                const item = `
                    <div class="list-group-item list-group-item-action cursor-pointer"
                         data-id="${customer.id}"
                         data-name="${customer.first_name} ${customer.last_name}">
                        <div class="d-flex justify-content-between">
                            <span>ID: ${customer.id}</span>
                            <span>${customer.first_name} ${customer.last_name}</span>
                        </div>
                    </div>
                `;
                container.append(item);
            });
        }
        container.removeClass('d-none');
    }

    // Select Customer
    $('#searchResults').on('click', '.list-group-item', function () {
        const customerId = $(this).data('id');
        const customerName = $(this).data('name');

        $('#selectedCustomerId').val(customerId);
        $('#customerSearch').val(`${customerName}`);
        $('#searchResults').addClass('d-none').empty();
    });


    // Form Submission
    $('#createAccountBtn').click(function (e) {
        e.preventDefault();


        const customerId = $('#selectedCustomerId').val();
        const initialDeposit = parseFloat($('#initialDeposit').val());
        const openingDate = new Date($('#openingDate').val());

        if (!customerId) {
            alert('Please select a customer');
            return;
        }

        if (isNaN(initialDeposit) || initialDeposit < 500) {
            alert('Minimum initial deposit must be ₹500');
            return;
        }

        if (openingDate > new Date()) {
            alert('Opening date cannot be in the future');
            return;
        }

        const formData = {
            customer_id: customerId,
            accountType: $('#accountType').val(),
            branch: $('#branch').val(),
            initial_deposit: initialDeposit,
            opening_date: $('#openingDate').val()
        };


        const submitBtn = $(this);
        submitBtn.prop('disabled', true).html('Creating...');

        $.ajax({
            url: 'submit_form.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#accountForm')[0].reset();
                    $('#selectedCustomerId').val('');
                    $('#addAccountModal').modal('hide');

                    if ($.fn.DataTable.isDataTable('#myTable')) {
                        $('#myTable').DataTable().ajax.reload(null, false);
                    }

                    alert(`Account created! Number: ${response.account_number}`);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseText);
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('Create Account');
            }
        });
    });

    // Show/hide transfer field
    $('#transactionType').change(function () {
        $('.transfer-field').toggle($(this).val() === 'transfer');
    });

    // handle transaction form submisssion
    $('#transactionForm').submit(function (e) {
        e.preventDefault();

        const transactionType = $('#transactionType').val();
        const formData = {
            account_number: $('#transactionAccount').val(),
            amount: parseFloat($('#transactionAmount').val()),
            description: $('#transactionDesc').val()
        };

        // Validate Transfer-specific field
        if (transactionType === 'transfer') {
            const recipientAccount = $('#recipientAccount').val();
            if (!recipientAccount) {
                alert('Please enter recipient account');
                return;
            }
            formData.recipient_account = recipientAccount;
        }

        // Determine endpoint 
        const endpoints = {
            deposit: 'deposit.php',
            withdraw: 'withdraw.php',
            transfer: 'transfer.php'
        };

        $.ajax({
            url: endpoints[transactionType],
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert('Transaction successful!\nNew Balance: ₹' + response.new_balance);
                    $('#transactionModal').modal('hide');
                    $('#transactionForm')[0].reset();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON?.message || 'Transaction failed');
            }
        });

    })


    // display transaction history table
    const transactionTable = $('#transactionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'transaction.php',
            type: 'POST'
        },
        order: [[5, 'desc']], // Default sort by 6th column (Date) descending
        columns: [
            { data: 'transaction_id' },
            { data: 'account_number' },
            {
                data: 'transaction_type',
                render: function (data) {
                    return data.charAt(0).toUpperCase() + data.slice(1);
                }
            },
            {
                data: 'amount',
                render: function (data, type, row) {
                    // Ensure proper formatting
                    const amount = typeof data === 'number' ? data : parseFloat(data) || 0;
                    return '₹' + amount.toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            },
            { data: 'related_account' },
            {
                data: 'transaction_date',
                render: function (data) {
                    return new Date(data).toLocaleDateString('en-IN', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            },
            { data: 'reference_number' }
        ],
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthMenu: [5, 10, 25, 50],
        pageLength: 5,
        responsive: true,
        "dom": '<"top"lf>rt<"bottom"ip>',
        language: {
            search: "Search transactions:",
            paginate: {
                next: "Next",
                previous: "Previous"
            }
        }
    });

    // Refresh table after modal close
    $('#transactionModal').on('hidden.bs.modal', function () {
        updateDashboardTotals();
        transactionTable.ajax.reload();
    });

    // Function to update both counts
    function updateDashboardTotals() {
        $.ajax({
            url: 'get_totals.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#totalCustomers').text(response.total_customers.toLocaleString());
                    $('#totalAccounts').text(response.total_accounts.toLocaleString());
                    $('#totalTransactions').text(response.total_transactions.toLocaleString());
                    $('#activeAccounts').text(response.active_accounts.toLocaleString());
                    $('#totalBalance').text(
                        '₹' + response.total_balance.toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching totals:', error);
                $('#totalCustomers, #totalAccounts, #totalTransactions, #activeAccounts, #totalBalance').text('N/A');
            }
        });
    }

    updateDashboardTotals();

    document.getElementById('logoutBtn').addEventListener('click', function (e) {
        e.preventDefault();
        if (confirm('Are you sure you want to log out?')) {
            window.location.href = 'login.php';
        }
    });



});