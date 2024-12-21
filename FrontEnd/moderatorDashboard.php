<?php
include('connect_db.php');
include('profile_data.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard</title>
    <link rel="stylesheet" href="moderatorDashboard.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar" id="sidebar">
            <div class="logo">
                <img src="images/TESL_logo.png" alt="Logo">
            </div>
            <a href="#" onclick="showSection('overview')" style="text-decoration: none;">
                <h2>Moderator Dashboard</h2>
            </a>
            <ul>
                <li><a href="#" onclick="showSection('attendance')">Attendance</a></li>
                <li><a href="#" onclick="showSection('createAccount')">Create Account</a></li>
                <li><a href="#" onclick="showSection('updateAccount')">Update User</a></li>
                <li><a href="#" onclick="showSection('studentProfile')">View Profile</a></li>
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

            <section id="attendance" class="section">
                <h3>Teacher Attendance</h3>
                <p>Manage and review attendance records for teachers here.</p>
            
                <label for="classSelect">Select Class:</label>
                <select id="classSelect" name="class" onchange="loadAttendance()">
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
            
            <section id="createAccount" class="section">
                <h2>Create Account</h2>
                <h4>Create accounts for teachers, accountants, and students.</h4>
                <form id="createAccountForm" action="#" method="POST" enctype="multipart/form-data">
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
            
                    <label for="picture">Picture (JPG, JPEG, PNG):</label>
                    <input type="file" id="picture" name="picture" accept=".jpg, .jpeg, .png" required>
            
                    <label for="birthCertificate">Birth Certificate (PDF):</label>
                    <input type="file" id="birthCertificate" name="birthCertificate" accept=".pdf" required>
            
                    <label for="fathersNid">Father's NID (PDF):</label>
                    <input type="file" id="fathersNid" name="fathersNid" accept=".pdf" required>
            
                    <label for="mothersNid">Mother's NID (PDF):</label>
                    <input type="file" id="mothersNid" name="mothersNid" accept=".pdf" required>
            
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
            
                    <label for="reEnterPassword">Re-enter Password:</label>
                    <input type="password" id="reEnterPassword" name="reEnterPassword" required>
            
                    <button type="submit">Create Account</button>
                </form>
            </section>

            <section id="updateAccount" class="section">
                <form id="updateAccountForm" action="#" method="POST" enctype="multipart/form-data">
                    <h2>Update Account Information</h2>
                    
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
                        
                        <label for="picture">Picture (JPG, JPEG, PNG):</label>
                        <input type="file" id="picture" name="picture" accept=".jpg, .jpeg, .png">
                        
                        <label for="birthCertificate">Birth Certificate (PDF):</label>
                        <input type="file" id="birthCertificate" name="birthCertificate" accept=".pdf">
                        
                        <label for="fathersNid">Father's NID (PDF):</label>
                        <input type="file" id="fathersNid" name="fathersNid" accept=".pdf">
                        
                        <label for="mothersNid">Mother's NID (PDF):</label>
                        <input type="file" id="mothersNid" name="mothersNid" accept=".pdf">
                        
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        
                        <label for="reEnterPassword">Re-enter Password:</label>
                        <input type="password" id="reEnterPassword" name="reEnterPassword" required>
                        
                        <button type="submit">Update Account</button>
                    </div>
                </form>
            </section>
            
            
            <section id="studentProfile" class="section">
                <h3>Student Profile</h3>
                <div id="studentSearch">
                    <label for="searchStudentId">Enter Student ID:</label>
                    <input type="text" id="searchStudentId" placeholder="Student ID">
                    <button type="button" onclick="fetchStudentProfile()">Search</button>
                </div>
            
                <div id="studentProfileDisplay">
                    <div class="profile-picture-container">
                        <img src="" alt="Profile Picture" id="student-profile-picture" />
                    </div>
            
                    <div class="profile-info">
                        <div class="profile-item"><strong>User ID:</strong> <span id="user-id-display"></span></div>
                        <div class="profile-item"><strong>Name:</strong> <span id="student-name-display"></span></div>
                        <div class="profile-item"><strong>Roll Number:</strong> <span id="roll-number-display"></span></div>
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
    <script src="moderatorDashboard.js"></script>
</body>
</html>
