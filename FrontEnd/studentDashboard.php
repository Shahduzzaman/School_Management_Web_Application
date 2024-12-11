<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="studentDashboard.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar" id="sidebar">
            <div class="logo">
                <img src="images/TESL_logo.png" alt="Logo">
            </div>
            <h2>Student Dashboard</h2>
            <ul>
                <li><a href="#" onclick="showSection('classwork')">Classwork</a></li>
                <li><a href="#" onclick="showSection('attendance')">Attendance</a></li>
                <li><a href="#" onclick="showSection('marksheets')">Results</a></li>
                <li><a href="#" onclick="showSection('fees')">Tuition Fees</a></li>
                <li><a href="#" onclick="showSection('leave')">Leave Application</a></li>
                <li><a href="#" onclick="showSection('profile')">My Profile</a></li>
                <li><a href="#" onclick="logOut()">Log Out</a></li>
            </ul>
        </nav>
        <div class="content" id="content">
            
            <section id="classwork" class="section active">
                <h3>Classwork & Lesson</h3>
                <label for="classwork-class">Select Class:</label>
                <select id="classwork-class">
                    <option value="class1">Class 1</option>
                    <option value="class2">Class 2</option>
                    <option value="class3">Class 3</option>
                </select>
                <br>
                <label for="classwork-date">Select Date:</label>
                <input type="date" id="classwork-date">
                <table id="classwork-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Lesson</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>            
            

            <section id="attendance" class="section active">
                <h3>Attendance History</h3>
                <div class="attendance-filter">
                    <label for="month-select">Select Month:</label>
                    <select id="month-select" onchange="fetchAttendance()">
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="calendar" id="calendar">
                </div>
                
                <div class="attendance-summary" id="attendance-summary">
                    <h3>Attendance Summary</h3>
                    <p>Total Days Present: <span id="total-present">0</span></p>
                    <p>Total Days Absent: <span id="total-absent">0</span></p>
                    <p>Days Late: <span id="total-late">0</span></p>
                    <p>Excused Absences: <span id="total-excused">0</span></p>
                </div>
                <button class="request-correction" onclick="requestCorrection()">Request Correction</button>
            </section>
            
            <section id="marksheets" class="section">
                <h3>Marksheets & Results</h3>
                <div class="marksheets-container">
                    <table id="marksheets-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>1st Term</th>
                                <th>2nd Term</th>
                                <th>Final</th>
                                <th>Grade Point</th>
                                <th>Grade Letter</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </section>
            
            
            <section id="fees" class="section">
                <h3>Tuition Fees History</h3>
                <table id="fees-history-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tbody id="fees-history-tbody">
                    </tbody>
                </table>
            </section>
            
            <section id="leave" class="section">
                <h3>Leave Application</h3>
                
                <form id="leave-application-form">
                    <textarea id="application-body" placeholder="Write your application here..." rows="10" required></textarea>
                    
                    <button type="submit" id="send-application-button">Send</button>
                </form>
            </section>            

            <section id="profile" class="section">
                <h3>My Profile</h3>
                <div class="profile-picture-container">
                    <img src="path/to/profile-picture.jpg" alt="Profile Picture" id="profile-picture" />
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
            
                <div class="change-password-section">
                    <h3>Change Password</h3>
                    <form id="change-password-form">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" required>
            
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" required>
            
                        <label for="re-enter-password">Re-enter New Password</label>
                        <input type="password" id="re-enter-password" required>
                    </form>
                    <button type="submit">Change Password</button>
                </div>
            </section>
            
            
        </div>
    </div>
    <div data-include-footer></div>
    <script src="includeFooter.js" defer></script>
    <script src="studentDashboardScript.js"></script>
</body>
</html>