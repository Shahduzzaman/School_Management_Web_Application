document.addEventListener("DOMContentLoaded", function() {
    showSection("classwork");
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1;  
    const currentYear = currentDate.getFullYear(); 
    populateCalendar(currentMonth, currentYear);
});
function populateCalendar(month, year) {
    const calendar = document.getElementById("calendar");
    calendar.innerHTML = ""; 

    const firstDayOfMonth = new Date(year, month - 1, 1);
    const lastDateOfMonth = new Date(year, month, 0);
    const totalDaysInMonth = lastDateOfMonth.getDate(); 
    for (let day = 1; day <= totalDaysInMonth; day++) {
        const dayElement = document.createElement("div");
        dayElement.classList.add("day");
        dayElement.textContent = day;
        calendar.appendChild(dayElement);
    }
}
function filterByMonth(month) {
    console.log("Filtering attendance for month:", month);
}
document.getElementById("month-select")?.addEventListener("change", function() {
    const selectedMonth = this.value;
    filterByMonth(selectedMonth);
});
function showSection(sectionId) {
    const sections = document.querySelectorAll(".section");
    sections.forEach((section) => {
        section.classList.remove("active");
    });
    const activeSection = document.getElementById(sectionId);
    if (activeSection) activeSection.classList.add("active");
}
document.addEventListener("DOMContentLoaded", function() {
    showSection("classwork");
    const dateInput = document.getElementById("classwork-date");
    fetchLastClassDate().then(lastDate => {
        dateInput.value = lastDate;
        fetchClasswork(lastDate);
    });
    dateInput.addEventListener("change", function() {
        const selectedDate = this.value;
        fetchClasswork(selectedDate);
    });
});

async function fetchLastClassDate() {
    const response = await fetch('/api/last-class-date'); 
    const data = await response.json();
    return data.lastClassDate; 
}

async function fetchClasswork(date) {
    const tableBody = document.getElementById("classwork-table").querySelector("tbody");
    tableBody.innerHTML = "";
    const response = await fetch(`/api/classwork?date=${date}`);
    const classworkData = await response.json();
    classworkData.forEach((entry) => {
        const row = document.createElement("tr");

        const subjectCell = document.createElement("td");
        subjectCell.textContent = entry.subject;
        row.appendChild(subjectCell);

        const lessonCell = document.createElement("td");
        lessonCell.textContent = entry.lesson;
        row.appendChild(lessonCell);

        tableBody.appendChild(row);
    });
}
document.addEventListener("DOMContentLoaded", function() {
    fetchMarksheetData();
});

async function fetchMarksheetData() {
    const tableHead = document.querySelector("#marksheets-table thead tr");
    const tableBody = document.querySelector("#marksheets-table tbody");
    tableBody.innerHTML = "";
    const response = await fetch('/api/marksheets');  
    const data = await response.json();
    const { monthlyExams, subjects } = data;
    const existingMonthlyColumns = document.querySelectorAll(".monthly-column");
    existingMonthlyColumns.forEach(col => col.remove());
    monthlyExams.forEach(month => {
        const monthlyTh = document.createElement("th");
        monthlyTh.classList.add("monthly-column");
        monthlyTh.textContent = month;
        tableHead.insertBefore(monthlyTh, tableHead.children[1]);
    });
    subjects.forEach(subjectData => {
        const row = document.createElement("tr");
        const subjectCell = document.createElement("td");
        subjectCell.textContent = subjectData.subject;
        row.appendChild(subjectCell);
        subjectData.monthlyMarks.forEach(mark => {
            const monthlyCell = document.createElement("td");
            monthlyCell.textContent = mark;
            row.appendChild(monthlyCell);
        });
        const firstTermCell = document.createElement("td");
        firstTermCell.textContent = subjectData.firstTerm;
        row.appendChild(firstTermCell);
        const secondTermCell = document.createElement("td");
        secondTermCell.textContent = subjectData.secondTerm;
        row.appendChild(secondTermCell);
        const finalTermCell = document.createElement("td");
        finalTermCell.textContent = subjectData.final;
        row.appendChild(finalTermCell);
        const gradePointCell = document.createElement("td");
        gradePointCell.textContent = subjectData.gradePoint.toFixed(2);
        row.appendChild(gradePointCell);
        const gradeLetterCell = document.createElement("td");
        gradeLetterCell.textContent = subjectData.gradeLetter;
        row.appendChild(gradeLetterCell);
        tableBody.appendChild(row);
    });
}

document.addEventListener("DOMContentLoaded", function() {
    fetch('/api/fees-history')
        .then(response => response.json())
        .then(data => {
            populateFeesHistoryTable(data); 
        })
        .catch(error => console.error("Error fetching fees history:", error));
});


function populateFeesHistoryTable(data) {
    const tbody = document.getElementById("fees-history-tbody");
    tbody.innerHTML = ""; 
    data.forEach(item => {
        const row = document.createElement("tr");

        const categoryCell = document.createElement("td");
        categoryCell.textContent = item.category;
        row.appendChild(categoryCell);

        const amountCell = document.createElement("td");
        amountCell.textContent = `Tk. ${item.amount}`;
        row.appendChild(amountCell);

        const statusCell = document.createElement("td");
        statusCell.textContent = item.status;
        row.appendChild(statusCell);

        const dateCell = document.createElement("td");
        dateCell.textContent = item.date;
        row.appendChild(dateCell);

        tbody.appendChild(row);
    });
}

document.addEventListener("DOMContentLoaded", function() {
    populateFeesHistoryTable(feesHistoryData);
});
document.getElementById("leave-application-form").addEventListener("submit", function(event) {
    event.preventDefault();
    
    const applicationBody = document.getElementById("application-body").value;
    
    if (applicationBody.trim() === "") {
        alert("Please write your application before sending.");
        return;
    }
    console.log("Application submitted:", applicationBody);
    document.getElementById("application-body").value = "";
    alert("Your leave application has been sent!");
});

const userId = sessionStorage.getItem("userId");

async function loadProfileData(userId) {
    try {
        const response = await fetch(`/api/getUserProfile?userId=${userId}`);
        const data = await response.json();

        if (response.ok && data) {
            document.getElementById("student-name").textContent = data.name || "N/A";
            document.getElementById("user-id").textContent = userId;
            document.getElementById("date-of-birth").textContent = data.dateOfBirth || "N/A";
            document.getElementById("father-name").textContent = data.fatherName || "N/A";
            document.getElementById("mother-name").textContent = data.motherName || "N/A";
            document.getElementById("guardian-contact").textContent = data.guardianContact || "N/A";
            document.getElementById("present-address").textContent = data.presentAddress || "N/A";
            document.getElementById("permanent-address").textContent = data.permanentAddress || "N/A";
            
            if (data.profilePicture) {
                document.getElementById("profile-picture").src = data.profilePicture;
            }
        } else {
            console.error("Failed to load profile data:", data.message);
            alert("Unable to load profile data. Please try again later.");
        }
    } catch (error) {
        console.error("Error fetching profile data:", error);
        alert("An error occurred while loading your profile. Please try again.");
    }
}

// Handling Change Password
document.getElementById("change-password-form").addEventListener("submit", async function (event) {
    event.preventDefault();

    const currentPassword = document.getElementById("current-password").value;
    const newPassword = document.getElementById("new-password").value;
    const reEnterPassword = document.getElementById("re-enter-password").value;

    if (newPassword !== reEnterPassword) {
        alert("New passwords do not match.");
        return;
    }

    try {
        const response = await fetch("/api/changePassword", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                userId,
                currentPassword,
                newPassword,
            }),
        });

        const result = await response.json();
        
        if (response.ok && result.success) {
            alert("Password changed successfully.");
            document.getElementById("change-password-form").reset();
        } else {
            alert(result.message || "Failed to change password. Please try again.");
        }
    } catch (error) {
        console.error("Error changing password:", error);
        alert("An error occurred. Please try again.");
    }
});



function logOut() {
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = "logout.php";
    }
}
