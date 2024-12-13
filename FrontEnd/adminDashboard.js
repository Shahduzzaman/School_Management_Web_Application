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
    showSection('overview');
});


document.getElementById('searchUser').addEventListener('click', function() {
    const userId = document.getElementById('userId').value;

    if (userId) {
        fetch('search_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `userId=${encodeURIComponent(userId)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('userName').innerText = data.name;
                document.getElementById('userDisplayId').innerText = data.userId;
            } else {
                alert('User not found.');
                document.getElementById('userName').innerText = '-';
                document.getElementById('userDisplayId').innerText = '-';
            }
        })
        .catch(err => console.error('Search Error:', err)); 
    }
});



document.getElementById('deleteButton').addEventListener('click', function() {
    const userId = document.getElementById('userDisplayId').innerText;

    if (userId !== '-') {
        if (confirm('Are you sure you want to delete this account?')) {
            fetch('delete_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `userId=${encodeURIComponent(userId)}`
            })
            .then(response => response.text())
            .then(message => {
                alert(message);
                if (message === 'Account deleted successfully') {
                    document.getElementById('userName').innerText = '-';
                    document.getElementById('userDisplayId').innerText = '-';
                }
            })
            .catch(err => console.error('Delete Error:', err));
        }
    }
});

function fetchStudentProfile() {
    const studentID = document.getElementById('searchStudentId').value;
    const classID = document.getElementById('classSelect').value;

    if (!studentID || classID === "Select Class") {
        alert('Please enter Student ID and select a Class.');
        return;
    }

    const url = `student_profile_data.php?StudentID=${studentID}&ClassID=${classID}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                // Populate the profile fields
                document.getElementById('student-name').innerText = data.user.Name || '-';
                document.getElementById('user-id').innerText = data.user.UserID || '-';
                document.getElementById('date-of-birth').innerText = data.user.DateOfBirth || '-';
                document.getElementById('father-name').innerText = data.user.FatherName || '-';
                document.getElementById('mother-name').innerText = data.user.MotherName || '-';
                document.getElementById('guardian-contact').innerText = data.user.GuardianPhoneNumber || '-';
                document.getElementById('present-address').innerText = data.user.PresentAddress || '-';
                document.getElementById('permanent-address').innerText = data.user.PermanentAddress || '-';
                document.getElementById('student-profile-picture').src = data.user.Picture || 'path/to/default-profile.jpg';

                // Populate results
                const resultsTable = document.querySelector('#examResults tbody');
                resultsTable.innerHTML = ''; // Clear old data

                data.results.forEach((result, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${result.SubjectName}</td>
                            <td>${result.TotalMarks}</td>
                            <td>${result.Marks}</td>
                            <td>${result.Grade}</td>
                            <td>${result.GPA}</td>
                        </tr>`;
                    resultsTable.innerHTML += row;
                });
            }
        })
        .catch(error => console.error('Error fetching student profile:', error));
}





function logOut() {
    alert("Logging out...");
    window.location.href = "login.php";
}