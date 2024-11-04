function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("collapsed");
}
function showSection(sectionId) {
    const sections = document.querySelectorAll(".section");
    sections.forEach((section) => {
        section.classList.remove("active");
    });
    const activeSection = document.getElementById(sectionId);
    activeSection.classList.add("active");
}
document.addEventListener("DOMContentLoaded", function() {
    showSection("classwork");
    populateCalendar(11, 2024);
});
function populateCalendar(month, year) {
    const calendar = document.getElementById('calendar');
    const daysInMonth = new Date(year, month, 0).getDate();
    calendar.innerHTML = '';
    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    dayNames.forEach(day => {
        const dayLabel = document.createElement('div');
        dayLabel.classList.add('day-label');
        dayLabel.textContent = day;
        calendar.appendChild(dayLabel);
    });
    const firstDayOfMonth = new Date(year, month - 1, 1).getDay();
    for (let i = 0; i < firstDayOfMonth; i++) {
        const emptyCell = document.createElement('div');
        emptyCell.classList.add('day');
        calendar.appendChild(emptyCell);
    }
}
function logOut() {
    window.location.href = "login.html";
}