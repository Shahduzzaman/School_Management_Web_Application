function showSection(sectionId) {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.remove('active');
        if (section.id === sectionId) {
            section.classList.add('active');
        }
    });
}
document.addEventListener("DOMContentLoaded", () => {
    showSection('attendance');
});

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
    alert("Logging out...");
    window.location.href = "login.html";
}