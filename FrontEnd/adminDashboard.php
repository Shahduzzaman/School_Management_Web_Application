<?php
include('connect_db.php');
include('profile_data.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminDashboard.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar" id="sidebar">
            <div class="logo">
                <img src="images/TESL_logo.png" alt="Logo">
            </div>
            <h2>Admin Dashboard</h2>
            <ul>
                <li class="dropdown">
                    <a href="#">User</a>
                    <ul class="submenu">
                        <li><a href="#" onclick="showSection('createAccount')">Create User</a></li>
                        <li><a href="#" onclick="showSection('updateAccount')">Update User</a></li>
                        <li><a href="#" onclick="showSection('deleteAccount')">Delete User</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Class</a>
                    <ul class="submenu">
                        <li><a href="#" onclick="showSection('createClass')">Create Class</a></li>
                        <li><a href="#" onclick="showSection('deleteClass')">Delete Class</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Subject</a>
                    <ul class="submenu">
                        <li><a href="#" onclick="showSection('createSubject')">Create Subject</a></li>
                        <li><a href="#" onclick="showSection('assignSubject')">Assign Subject</a></li>
                        <li><a href="#" onclick="showSection('deleteSubject')">Delete Subject</a></li>
                    </ul>
                </li>
                <li><a href="#" onclick="showSection('attendance')">Attendance</a></li>
                <li class="dropdown">
                    <a href="#">Payment</a>
                    <ul class="submenu">
                        <li><a href="#" onclick="showSection('feesPayments')">Submit Payment</a></li>
                        <li><a href="#" onclick="showSection('reportsAnalytics')">Payment Report</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Profile</a>
                    <ul class="submenu">
                        <li><a href="#" onclick="showSection('profile')">My Profile</a></li>
                        <li><a href="#" onclick="showSection('studentProfile')">View Profile</a></li>
                    </ul>
                </li>
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

            <section id="createAccount" class="section">
                <form id="createAccountForm" action="create_user.php" method="POST" enctype="multipart/form-data">
                    <h2>Create New Account</h2>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
            
                    <label for="userId">User ID:</label>
                    <input type="text" id="userId" name="userId" required>
            
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" required>
            
                    <label for="fatherName">Father's Name:</label>
                    <input type="text" id="fatherName" name="fatherName" required>
            
                    <label for="motherName">Mother's Name:</label>
                    <input type="text" id="motherName" name="motherName" required>
            
                    <label for="guardianContact">Guardian's Contact:</label>
                    <input type="tel" id="guardianContact" name="guardianContact" required>
            
                    <label for="presentAddress">Present Address:</label>
                    <textarea id="presentAddress" name="presentAddress" required></textarea>
            
                    <label for="permanentAddress">Permanent Address:</label>
                    <textarea id="permanentAddress" name="permanentAddress" required></textarea>
            
                    <label for="picture">Picture (jpg, jpeg, png):</label>
                    <input type="file" id="picture" name="picture" accept=".jpg, .jpeg, .png" required>
            
                    <label for="birthCertificate">Birth Certificate (jpg, jpeg, png, pdf):</label>
                    <input type="file" id="birthCertificate" name="birthCertificate" accept=".jpg, .jpeg, .png, .pdf" required>
            
                    <label for="fathersNid">Father's NID (jpg, jpeg, png, pdf):</label>
                    <input type="file" id="fathersNid" name="fathersNid" accept=".jpg, .jpeg, .png, .pdf" required>
            
                    <label for="mothersNid">Mother's NID (jpg, jpeg, png, pdf):</label>
                    <input type="file" id="mothersNid" name="mothersNid" accept=".jpg, .jpeg, .png, .pdf" required>
            
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
            
                    <label for="reEnterPassword">Re-enter Password:</label>
                    <input type="password" id="reEnterPassword" name="reEnterPassword" required>

                    <label for="role">User Role:</label>
                    <select id="role" name="role" required>
                        <option value="" disabled selected>Select a role</option>
                        <option value="Admin">Admin</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Accountant">Accountant</option>
                        <option value="Student">Student</option>
                    </select>

                    <button type="submit">Create Account</button>
                </form>
            </section>

            <section id="updateAccount" class="section">
                <form id="updateAccountForm" action="update_user.php" method="POST" enctype="multipart/form-data">
                    <label for="searchUserId">User ID:</label>
                    <input type="text" id="searchUserId" name="searchUserId" required>
                    <button type="button" id="searchUserButton">Search</button>

                    <div id="updateFields">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" required>

                        <label for="fatherName">Father's Name:</label>
                        <input type="text" id="fatherName" name="fatherName" required>

                        <label for="motherName">Mother's Name:</label>
                        <input type="text" id="motherName" name="motherName" required>

                        <label for="guardianContact">Guardian's Contact:</label>
                        <input type="tel" id="guardianContact" name="guardianContact" required>

                        <label for="presentAddress">Present Address:</label>
                        <textarea id="presentAddress" name="presentAddress" required></textarea>

                        <label for="permanentAddress">Permanent Address:</label>
                        <textarea id="permanentAddress" name="permanentAddress" required></textarea>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>

                        <label for="reEnterPassword">Re-enter Password:</label>
                        <input type="password" id="reEnterPassword" name="reEnterPassword" required>

                        <button type="submit">Update Account</button>
                    </div>
                </form>
            </section>

            <section id="deleteAccount" class="section">
                <h3>Delete Account</h3>
                <p>Search and delete a user account.</p>
                <form id="deleteAccountForm">
                    <label for="userIdInput">Enter User ID:</label>
                    <input type="text" id="userIdInput" name="userId" placeholder="Enter User ID" required>
                    <button type="button" id="deleteAccount_searchButton">Search</button>
                    <div id="userInfo" style="margin-top: 10px;">
                        <p><strong>User Name:</strong> <span id="userName">N/A</span></p>
                        <button type="button" id="deleteAccount_deleteButton" style="background-color: red; color: white;">Delete</button>
                    </div>
                </form>
            </section>


            <section id="createClass" class="section">
                <form id="createClassForm" action="create_class.php" method="POST">
                    <h3>Create Class</h3>
                    <p>Naming Convention: ClassName_Section_Year.</p>
                    <p>Example: G1_S1_2024</p>

                    <label for="classID">Class ID:</label>
                    <input type="text" id="classID" name="classID" required placeholder="Enter class ID (e.g., G-1_S-1_2024)">

                    <label for="className">Class Name:</label>
                    <input type="text" id="className" name="className" required placeholder="Enter Class Name (e.g., Grade 1)">

                    <label for="subjectID">Subject ID:</label>
                    <input type="text" id="subjectID" name="subjectID" placeholder="Optional">

                    <button type="submit">Create Class</button>
                </form>
            </section>


            <section id="deleteClass" class="section">
                <form id="deleteClassForm" action="delete_class.php" method="POST">
                    <h3>Delete Class</h3>
                    <p>Select the year and class to delete.</p>
                    
                    <div class="delete-class-form">
                        <label for="selectClass">Select Class:</label>
                        <select id="selectClass" name="selectClass" class="input-box" required>
                            <option value="" disabled selected>Select Class</option>
                            <?php
                            include('connect_db.php');
                            try {
                                $query = "SELECT ClassID, ClassName FROM class";
                                $stmt = $pdo->query($query);
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['ClassID'] . "'>" . $row['ClassID'] . " - " . $row['ClassName'] . "</option>";
                                }
                            } catch (PDOException $e) {
                                echo "<option value='' disabled>Error loading classes.</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button id="deleteClassButton" class="btn delete-btn" type="submit">Delete Class</button>
                </form>
            </section>


            <section id="attendance" class="section">
                <h3>Teacher Attendance</h3>
                <p>Manage and review attendance records for teachers here.</p>
            
                <label for="classSelect">Select Class:</label>
                <select id="classSelect" name="class" onchange="loadAttendance()">
                    <option value="" disabled selected>Select Class</option>
                    <option value="Staff">Staff</option>
                    <option value="pre-school">Pre-School</option>
                    <option value="play">Play</option>
                    <option value="nursery">Nursery</option>
                    <option value="grade-1">Grade 1</option>
                    <option value="grade-2">Grade 2</option>
                    <option value="grade-3">Grade 3</option>
                    <option value="grade-4">Grade 4</option>
                    <option value="grade-5">Grade 5</option>
                    <option value="grade-6">Grade 6</option>
                    <option value="grade-7">Grade 7</option>
                    <option value="grade-8">Grade 8</option>
                    <option value="grade-9">Grade 9</option>
                    <option value="grade-10">Grade 10</option>
                </select>
                <div class="attendance-table-container">
                    <table class="attendance-table" id="attendanceTable">
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Last Day</th>
                                <th>Today</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceTableBody">
                        </tbody>
                    </table>
                </div>
                <button type="button" onclick="submitAttendance()">Submit Attendance</button>
            </section>

            <section id="feesPayments" class="section">
                <h3>Student Tuition Fees</h3>
                <div class="user-id-input">
                    <label for="student-user-id">Enter User ID:</label>
                    <input type="text" id="student-user-id" placeholder="Enter User ID" class="input-box">
                </div>
                <div class="bill-category-input">
                    <label for="bill-category">Select Bill Category:</label>
                    <select id="bill-category" class="dropdown">
                        <option value="" disabled selected>Select Category</option>
                        <option value="admission-fee">Admission Fee</option>
                        <option value="session-fee">Session Fee</option>
                        <option value="january-tuition-fee">January-Tuition Fee</option>
                        <option value="february-tuition-fee">February-Tuition Fee</option>
                        <option value="march-tuition-fee">March-Tuition Fee</option>
                        <option value="april-tuition-fee">April-Tuition Fee</option>
                        <option value="may-tuition-fee">May-Tuition Fee</option>
                        <option value="june-tuition-fee">June-Tuition Fee</option>
                        <option value="july-tuition-fee">July-Tuition Fee</option>
                        <option value="august-tuition-fee">August-Tuition Fee</option>
                        <option value="september-tuition-fee">September-Tuition Fee</option>
                        <option value="october-tuition-fee">October-Tuition Fee</option>
                        <option value="november-tuition-fee">November-Tuition Fee</option>
                        <option value="december-tuition-fee">December-Tuition Fee</option>
                        <option value="1st-term-exam-fee">1st Term Exam Fee</option>
                        <option value="2nd-term-exam-fee">2nd Term Exam Fee</option>
                        <option value="annual-exam-fee">Annual Exam Fee</option>
                        <option value="transport-fee">Transport Fee</option>
                    </select>
                    
                </div>
                <button id="search-button" type="button" class="button">Search</button>
        
                <div id="payment-status-container" class="status-container hidden">
                    <p id="payment-status-message" class="status-message"></p>
                </div>
        
                <div id="payment-details-form" class="payment-form hidden">
                    <h4>Payment Details</h4>
                    <div class="payment-input">
                        <label for="payment-amount">Amount:</label>
                        <input type="number" id="payment-amount" placeholder="Enter amount" class="input-box">
                    </div>
                    <div class="payment-status-input">
                        <label for="payment-status">Payment Status:</label>
                        <select id="payment-status" class="dropdown">
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                    <div class="payment-date-input">
                        <label for="payment-date">Payment Date:</label>
                        <input type="date" id="payment-date" class="input-box">
                    </div>
                    <button id="submit-button" type="submit" class="button">Submit</button>
                </div>
            </section>

            <section id="academicManagement" class="section">
                <h3>Academic Management</h3>
                <p>Oversee classwork, assignments, exams, and results.</p>
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
            
            <section id="leaveManagement" class="section">
                <h3>Leave Management</h3>
                <p>Approve or deny leave requests from teachers and students.</p>
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

            <section id="studentProfile" class="section">
                <h3>Student Profile</h3>
                <div id="studentSearch">
                    <label for="searchStudentId">Enter Student ID:</label>
                    <input type="text" id="searchStudentId" placeholder="Student ID">
                    <br>
                    <label for="classSelect">Enter Class:</label>
                    <select id="classSelect">
                        <option value="" disabled selected>Select Class</option>
                        <option value="pre-school">Pre-School</option>
                        <option value="play">Play</option>
                        <option value="nursery">Nursery</option>
                        <option value="grade-1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="grade-3">Grade 3</option>
                        <option value="grade-4">Grade 4</option>
                        <option value="grade-5">Grade 5</option>
                        <option value="grade-6">Grade 6</option>
                        <option value="grade-7">Grade 7</option>
                        <option value="grade-8">Grade 8</option>
                        <option value="grade-9">Grade 9</option>
                        <option value="grade-10">Grade 10</option>
                    </select>
                    <br>
                    <button type="button" onclick="fetchStudentProfile()">Search</button>
                </div>

                <div id="studentProfileDisplay">
                    <div class="profile-picture-container">
                        <img src="" alt="Profile Picture" id="student-profile-picture" />
                    </div>
                    <div class="profile-info">
                        <div class="profile-item"><strong>Name:</strong> <span id="student-name"></span></div>
                        <div class="profile-item"><strong>User ID:</strong> <span id="user-id"></span></div>
                        <div class="profile-item"><strong>Date of Birth:</strong> <span id="date-of-birth"></span></div>
                        <div class="profile-item"><strong>Father's Name:</strong> <span id="father-name"></span></div>
                        <div class="profile-item"><strong>Mother's Name:</strong> <span id="mother-name"></span></div>
                        <div class="profile-item"><strong>Guardian's Contact:</strong> <span id="guardian-contact"></span></div>
                        <div class="profile-item"><strong>Present Address:</strong> <span id="present-address"></span></div>
                        <div class="profile-item"><strong>Permanent Address:</strong> <span id="permanent-address"></span></div>
                    </div>

                    <div id="examSelection">
                        <label for="examTypeSelect">Select Exam:</label>
                        <select id="examTypeSelect" onchange="loadExamResults()">
                            <option value="first-term">1st Term Exam</option>
                            <option value="second-term">2nd Term Exam</option>
                            <option value="annual">Annual Exam</option>
                        </select>
                    </div>

                    <div id="examResults">
                        <h4>Results Table</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Subject</th>
                                    <th>Full Marks</th>
                                    <th>Written</th>
                                    <th>MCQ</th>
                                    <th>Practical</th>
                                    <th>Total</th>
                                    <th>Highest</th>
                                    <th>Letter Grade</th>
                                    <th>Grade Point</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><span id="subject1Name"></span></td>
                                    <td><span id="subject1FullMarks"></span></td>
                                    <td><span id="subject1Written"></span></td>
                                    <td><span id="subject1MCQ"></span></td>
                                    <td><span id="subject1Practical"></span></td>
                                    <td><span id="subject1Total"></span></td>
                                    <td><span id="subject1Highest"></span></td>
                                    <td><span id="subject1LetterGrade"></span></td>
                                    <td><span id="subject1GradePoint"></span></td>
                                </tr>
                            </tbody>
                        </table>

                        <div id="totalMarksContainer">
                            <label for="monthlyExamTotal">Total of Monthly Exam:</label>
                            <span id="monthlyExamTotal"></span>

                            <label for="monthlyExamPercentage">20% of Monthly Exam:</label>
                            <span id="monthlyExamPercentage"></span>

                            <label for="gpaWithoutAdditional">GPA without Additional Subject:</label>
                            <span id="gpaWithoutAdditional"></span>

                            <label for="totalGpa">GPA with Additional Subject:</label>
                            <span id="totalGpa"></span>

                            <label for="comment">Comment:</label>
                            <p id="comment"></p>

                            <label for="totalMarks">Total Marks:</label>
                            <span id="totalMarks"></span>

                            <label for="procuredMarks">Procured Marks:</label>
                            <span id="procuredMarks"></span>
                        </div>
                    </div>

                    <div id="additionalDocuments">
                        <h4>Additional Documents</h4>
                        <div class="document-item">
                            <strong>Birth Certificate:</strong>
                            <span id="birth-certificate-display">Not Uploaded</span>
                        </div>
                        <div class="document-item">
                            <strong>Father's NID:</strong>
                            <span id="father-nid-display">Not Uploaded</span>
                        </div>
                        <div class="document-item">
                            <strong>Mother's NID:</strong>
                            <span id="mother-nid-display">Not Uploaded</span>
                        </div>
                    </div>
                </div>
            </section>



        </div>
    </div>
    <div data-include-footer></div>
    <script src="includeFooter.js" defer></script>
    <script src="adminDashboard.js"></script>
</body>
</html>
