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

function logOut() {
    alert("Logging out...");
    window.location.href = "login.html";
}
