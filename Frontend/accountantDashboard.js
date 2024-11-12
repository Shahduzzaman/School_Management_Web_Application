document.addEventListener("DOMContentLoaded", () => {

    showSection('fees');
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', (e) => {
            const sectionId = e.target.getAttribute('data-section-id');
            showSection(sectionId);
        });
    });


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
                loadUserFees();
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

function showSection(sectionId) {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.remove('active'); 
    });

    const sectionToShow = document.getElementById(sectionId);
    if (sectionToShow) {
        sectionToShow.classList.add('active'); 
    }
}

async function loadUserFees() {
    const userId = document.getElementById("user-id").value.trim();
    if (!userId) {
        alert("Please enter a valid User ID.");
        return;
    }

    document.getElementById("loading-message").style.display = "block"; 

    try {
        const response = await fetch(`/api/getFeesHistory?userId=${userId}`);
        if (!response.ok) throw new Error("Failed to load fees history");

        const feesData = await response.json();
        const tbody = document.getElementById("fees-history-tbody");
        tbody.innerHTML = ""; 

        if (feesData.length === 0) {
            tbody.innerHTML = "<tr><td colspan='5'>No fee records found for this user.</td></tr>";
        } else {
            feesData.forEach((fee) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${fee.category}</td>
                    <td>${fee.amount}</td>
                    <td>
                        <select data-column="status" onchange="updateStatus(this, '${fee.id}')">
                            <option value="Paid" ${fee.status === "Paid" ? "selected" : ""}>Paid</option>
                            <option value="Unpaid" ${fee.status === "Unpaid" ? "selected" : ""}>Unpaid</option>
                        </select>
                    </td>
                    <td>${fee.paymentDate}</td>
                    <td><button onclick="updateFee('${fee.id}', this)">Update</button></td>
                `;
                tbody.appendChild(row);
            });
        }
    } catch (error) {
        console.error("Error loading fees data:", error);
        alert("Failed to load fees data. Please try again.");
    } finally {
        document.getElementById("loading-message").style.display = "none"; 
    }
}

async function updateStatus(selectElement, feeId) {
    const status = selectElement.value;
    const row = selectElement.closest("tr");
    const paymentDateCell = row.cells[3]; 

    if (status === "Paid") {
        paymentDateCell.textContent = new Date().toLocaleDateString();
    } else {
        paymentDateCell.textContent = "N/A";
    }

    await updateFee(feeId, status, paymentDateCell.textContent);
}


async function updateFee(feeId, status, paymentDate) {
    const updatedFee = { id: feeId, status, paymentDate };

    try {
        const response = await fetch(`/api/updateFee`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(updatedFee),
        });

        if (response.ok) {
            alert("Fee status updated successfully.");
        } else {
            throw new Error("Failed to update fee");
        }
    } catch (error) {
        console.error("Error updating fee:", error);
        alert("Failed to update fee. Please try again.");
    }
}


document.getElementById("change-password-form").addEventListener("submit", async function (event) {
    event.preventDefault();

    const currentPassword = document.getElementById("current-password").value;
    const newPassword = document.getElementById("new-password").value;
    const reEnterPassword = document.getElementById("re-enter-password").value;
    const userId = sessionStorage.getItem("userId");

    if (!userId) {
        alert("Please log in first.");
        window.location.href = "/login.html";
        return;
    }

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
    sessionStorage.clear(); 
    window.location.href = "login.html"; 
}