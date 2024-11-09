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
function logOut() {
    alert("Logging out...");
    window.location.href = "login.html";
}
