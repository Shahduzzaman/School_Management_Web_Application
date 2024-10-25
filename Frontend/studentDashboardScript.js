// Function to toggle the sidebar visibility
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("collapsed");
}

// Function to show the selected section
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll(".section");
    sections.forEach((section) => {
        section.classList.remove("active");
    });

    // Show the selected section
    const activeSection = document.getElementById(sectionId);
    activeSection.classList.add("active");
}

// Show the first section by default
document.addEventListener("DOMContentLoaded", function() {
    showSection("classwork");
});
