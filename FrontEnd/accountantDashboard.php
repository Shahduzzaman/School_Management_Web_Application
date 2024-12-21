<?php
include('connect_db.php');
include('profile_data.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountant Dashboard</title>
    <link rel="stylesheet" href="accountantDashboard.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar" id="sidebar">
            <div class="logo">
                <img src="images/TESL_logo.png" alt="Logo">
            </div>
            <a href="#" onclick="showSection('overview')" style="text-decoration: none;">
                <h2>Accountant Dashboard</h2>
            </a>
            <ul>
                <li><a href="#" onclick="showSection('fees')">Tuition Fees</a></li>
                <li><a href="#" onclick="showSection('reportsAnalytics')">Reports</a></li>
                <li><a href="#" onclick="showSection('profile')">My Profile</a></li>
                <li><a href="#" onclick="logOut()">Log Out</a></li>
            </ul>
        </nav>
        <div class="content" id="content">
            <section id="overview" class="section">
                <h3>Dashboard Overview</h3>
                <p>Overview of key metrics and statistics for quick insights.</p>
                <div id="message">
                    <?php if (isset($_SESSION['error'])): ?>
                        <p class="alert error" id="error-message">
                            <?php echo $_SESSION['error']; ?>
                            <button class="close-btn" onclick="closeMessage('error')">×</button>
                        </p>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <p class="alert success" id="success-message">
                            <?php echo $_SESSION['success']; ?>
                            <button class="close-btn" onclick="closeMessage('success')">×</button>
                        </p>
                    <?php endif; ?>
                </div>
            </section>

            <section id="fees" class="section active">
                <h3>Student Tuition Fees</h3>
                <div class="user-id-input">
                    <label for="student-user-id">Enter User ID:</label>
                    <input type="text" id="student-user-id" placeholder="Enter User ID">
                    <button type="apply">Apply</button>
                </div>
                <table id="fees-history-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tbody id="fees-history-tbody">
                        <tr>
                            <td><input type="text" name="category-1" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-1" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-1">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-1"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-2" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-2" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-2">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-2"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-3" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-3" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-3">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-3"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-4" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-4" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-4">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-4"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-5" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-5" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-5">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-5"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-6" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-6" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-6">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-6"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-7" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-7" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-7">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-7"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-8" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-8" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-8">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-8"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-9" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-9" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-9">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-9"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-10" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-10" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-10">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-10"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-11" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-11" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-11">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-11"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-12" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-12" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-12">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-12"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-13" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-13" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-13">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-13"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="category-14" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-14" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-14">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-14"></td>
                        </tr>
                        
                        <tr>
                            <td><input type="text" name="category-15" placeholder="Enter category"></td>
                            <td><input type="number" name="amount-15" placeholder="Enter amount"></td>
                            <td>
                                <select name="status-15">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="date" name="payment-date-15"></td>
                        </tr>
                        
                        
                    </tbody>
                </table>
                <div class="submitButton">
                    <button type="submit">Submit</button>
                </div>
            </section>

            <section id="reportsAnalytics" class="section">
                <h3>Reports & Analytics</h3>
                <p>Generate reports and view analytics on payments.</p>
                <div class="report-container">
                    <div class="date-picker-container">
                        <label for="start-date">Start Date:</label>
                        <input type="date" id="start-date" class="input-box">
                    </div>
                    <div class="date-picker-container">
                        <label for="end-date">End Date:</label>
                        <input type="date" id="end-date" class="input-box">
                    </div>
                    <button id="apply-button" type="button" class="button">Apply</button>
                </div>
                <div id="report-results" class="report-results hidden">
                    <h4>Payment Report</h4>
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Student User ID</th>
                                <th>Category</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="report-table-body">

                        </tbody>
                    </table>
                    <div class="report-summary">
                        <p><strong>Total Records:</strong> <span id="total-records">0</span></p>
                        <p><strong>Total Amount:</strong> <span id="total-amount">0.00</span></p>
                    </div>
                </div>
            </section>
            
            
            <section id="profile" class="section">
                <h3>My Profile</h3>

                <!-- Profile Picture -->
                <div class="profile-picture-container">
                    <img src="<?= isset($user['Picture']) && file_exists($user['Picture']) ? htmlspecialchars($user['Picture']) : 'path/to/default-profile.jpg' ?>" alt="Profile Picture" id="profile-picture" />
                </div>

                <!-- Profile Information -->
                <div class="profile-info">
                    <div class="profile-item"><strong>Name:</strong> <?= isset($user['Name']) ? htmlspecialchars($user['Name']) : '-' ?></div>
                    <div class="profile-item"><strong>User ID:</strong> <?= isset($user['UserID']) ? htmlspecialchars($user['UserID']) : '-' ?></div>
                    <div class="profile-item"><strong>Date of Birth:</strong> <?= isset($user['DateOfBirth']) ? htmlspecialchars($user['DateOfBirth']) : '-' ?></div>
                    <div class="profile-item"><strong>Father's Name:</strong> <?= isset($user['FatherName']) ? htmlspecialchars($user['FatherName']) : '-' ?></div>
                    <div class="profile-item"><strong>Mother's Name:</strong> <?= isset($user['MotherName']) ? htmlspecialchars($user['MotherName']) : '-' ?></div>
                    <div class="profile-item"><strong>Guardian's Contact:</strong> <?= isset($user['GuardianPhoneNumber']) ? htmlspecialchars($user['GuardianPhoneNumber']) : '-' ?></div>
                    <div class="profile-item"><strong>Present Address:</strong> <?= isset($user['PresentAddress']) ? htmlspecialchars($user['PresentAddress']) : '-' ?></div>
                    <div class="profile-item"><strong>Permanent Address:</strong> <?= isset($user['PermanentAddress']) ? htmlspecialchars($user['PermanentAddress']) : '-' ?></div>
                </div>

                <!-- Change Password Section -->
                <div class="change-password-section">
                    <h3>Change Password</h3>
                    <form id="change-password-form" action="change_password.php" method="POST">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" name="current-password" required>

                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new-password" required>

                        <label for="re-enter-password">Re-enter New Password</label>
                        <input type="password" id="re-enter-password" name="re-enter-password" required>

                        <button type="submit" class="btn">Change Password</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <div data-include-footer></div>
    <script src="includeFooter.js" defer></script>
    <script src="accountantDashboard.js"></script>
</body>
</html>
