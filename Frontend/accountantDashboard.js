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
    showSection('updateFees');
});
document.addEventListener("DOMContentLoaded", () => {
    loadFeesData();
    document.getElementById("add-fee-btn").addEventListener("click", () => {
        document.getElementById("add-fee-form").style.display = "block";
    });
    document.getElementById("cancel-add-fee").addEventListener("click", () => {
        document.getElementById("add-fee-form").style.display = "none";
    });
    document.getElementById("new-fee-form").addEventListener("submit", async (event) => {
        event.preventDefault();
        const newFee = {
            category: document.getElementById("new-category").value,
            amount: document.getElementById("new-amount").value,
            status: document.getElementById("new-status").value,
            paymentDate: document.getElementById("new-date").value,
        };
        
        try {
            const response = await fetch("/api/addFee", {
                method: "POST",
                headers: { "Content-Type": "application/json" },

                body: JSON.stringify(newFee),
            });
            if (response.ok) {
                loadFeesData();
                document.getElementById("add-fee-form").reset();
                document.getElementById("add-fee-form").style.display = "none";
            } else {
                alert("Failed to add fee. Please try again.");
            }
        } catch (error) {
            console.error("Error adding fee:", error);
        }
    });
});
async function loadUserFees() {
    const userId = document.getElementById("user-id").value.trim();
    if (!userId) {
        alert("Please enter a valid User ID.");
        return;
    }

    try {
        loadFeesData(userId);
    } catch (error) {
        console.error("Error loading fees data:", error);
        alert("Failed to load fees data.");
    }
}

async function loadFeesData(userId) {
    try {
        const response = await fetch(`/api/getFeesHistory?userId=${userId}`);
        if (!response.ok) throw new Error("Failed to load fees history");

        const feesData = await response.json();

        const tbody = document.getElementById("fees-history-tbody");
        tbody.innerHTML = ""; /

        feesData.forEach((fee) => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td contenteditable="true" data-column="category">${fee.category}</td>
                <td contenteditable="true" data-column="amount">${fee.amount}</td>
                <td>
                    <select data-column="status" onchange="updateStatus(this, '${fee.id}')">
                        <option value="Paid" ${fee.status === "Paid" ? "selected" : ""}>Paid</option>
                        <option value="Unpaid" ${fee.status === "Unpaid" ? "selected" : ""}>Unpaid</option>
                    </select>
                </td>
                <td contenteditable="true" data-column="paymentDate">${fee.paymentDate}</td>
                <td><button onclick="updateFee('${fee.id}', this)">Update</button></td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error("Error loading fees data:", error);
        alert("Failed to load fees data. Please try again.");
    }
}
function updateStatus(selectElement, feeId) {
    const row = selectElement.closest("tr");
    const status = selectElement.value;
    
    if (status === "Paid") {
        const currentDate = new Date().toISOString().split('T')[0]; 
        row.querySelector('[data-column="paymentDate"]').textContent = currentDate;
    }
}

async function updateFee(feeId, button) {
    const row = button.closest("tr");
    const updatedFee = {
        id: feeId,
        category: row.querySelector('[data-column="category"]').textContent,
        amount: row.querySelector('[data-column="amount"]').textContent,
        status: row.querySelector('[data-column="status"]').value,
        paymentDate: row.querySelector('[data-column="paymentDate"]').textContent,
    };

    try {
        const response = await fetch(`/api/updateFee`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(updatedFee),
        });
        
        if (response.ok) {
            alert("Fee updated successfully.");
        } else {
            throw new Error("Failed to update fee");
        }
    } catch (error) {
        console.error("Error updating fee:", error);
        alert("Failed to update fee. Please try again.");
    }
}


const userId = sessionStorage.getItem("userId");
// This is for futur work
// if (userId) {
//     loadProfileData(userId); // Fetch profile data if userId is available
// } else {
//     // If no userId is found, redirect to the login page
//     window.location.href = "/login.html";
// }


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