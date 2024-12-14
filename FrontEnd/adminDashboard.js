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

document.getElementById('deleteAccount_searchButton').addEventListener('click', function () {
    const userId = document.getElementById('userIdInput').value;

    if (!userId) {
        alert('Please enter a User ID.');
        return;
    }

    fetch('delete_account.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ action: 'search', userId: userId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('userName').textContent = data.user_name;
                document.getElementById('userInfo').style.display = 'block';
            } else {
                alert(data.message || 'Error occurred.');
                document.getElementById('userInfo').style.display = 'none';
            }
        })
        .catch(error => console.error('Error:', error));
});

document.getElementById('deleteAccount_deleteButton').addEventListener('click', function () {
    const userId = document.getElementById('userIdInput').value;

    if (confirm(`Are you sure you want to delete the user?`)) {
        fetch('delete_account.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'delete', userId: userId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    document.getElementById('deleteAccountForm').reset();
                    document.getElementById('userInfo').style.display = 'none';
                } else {
                    alert(data.message || 'Error occurred.');
                }
            })
            .catch(error => console.error('Error:', error));
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
                document.getElementById('student-name').innerText = data.user.Name || '-';
                document.getElementById('user-id').innerText = data.user.UserID || '-';
                document.getElementById('date-of-birth').innerText = data.user.DateOfBirth || '-';
                document.getElementById('father-name').innerText = data.user.FatherName || '-';
                document.getElementById('mother-name').innerText = data.user.MotherName || '-';
                document.getElementById('guardian-contact').innerText = data.user.GuardianPhoneNumber || '-';
                document.getElementById('present-address').innerText = data.user.PresentAddress || '-';
                document.getElementById('permanent-address').innerText = data.user.PermanentAddress || '-';
                document.getElementById('student-profile-picture').src = data.user.Picture || 'path/to/default-profile.jpg';

                const resultsTable = document.querySelector('#examResults tbody');
                resultsTable.innerHTML = ''; 

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

function closeMessage(type) {
    var messageElement = document.getElementById(type + '-message');
    if (messageElement) {
        messageElement.style.display = "none";
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "remove_message.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("type=" + type);
}


document.getElementById('createSubjectButton').addEventListener('click', function () {
    const subjectId = document.getElementById('subjectIdInput').value;
    const subjectName = document.getElementById('subjectNameInput').value;
    const formMessage = document.getElementById('createSubjformMsg');

    if (!subjectId || !subjectName) {
        formMessage.textContent = 'Both Subject ID and Subject Name are required.';
        formMessage.className = 'error';
        formMessage.style.display = 'block';
        return;
    }

    fetch('create_subject.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ subjectId: subjectId, subjectName: subjectName }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                formMessage.textContent = 'Subject created successfully!';
                formMessage.className = 'success';
                formMessage.style.display = 'block';
                document.getElementById('createSubjectForm').reset();
            } else {
                formMessage.textContent = data.message || 'Error occurred while creating the subject.';
                formMessage.className = 'error';
                formMessage.style.display = 'block';
            }
        })
        .catch(error => {
            formMessage.textContent = 'Error occurred: ' + error.message;
            formMessage.className = 'error';
            formMessage.style.display = 'block';
        });
});

document.addEventListener('DOMContentLoaded', function () {
    const subjectDropdown = document.getElementById('subjectDropdown');
    const formMessage = document.getElementById('deleteSubjformMsg');

    // Populate dropdown with SubjectID and SubjectName
    fetch('get_subjects.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                data.subjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.SubjectID;
                    option.textContent = `${subject.SubjectID} - ${subject.SubjectName}`;
                    subjectDropdown.appendChild(option);
                });
            } else {
                formMessage.textContent = data.message || 'Failed to load subjects.';
                formMessage.className = 'error';
                formMessage.style.display = 'block';
            }
        })
        .catch(error => {
            formMessage.textContent = 'Error occurred: ' + error.message;
            formMessage.className = 'error';
            formMessage.style.display = 'block';
        });

    // Handle delete action
    document.getElementById('deleteSubjectButton').addEventListener('click', function () {
        const subjectId = subjectDropdown.value;

        if (!subjectId) {
            formMessage.textContent = 'Please select a subject to delete.';
            formMessage.className = 'error';
            formMessage.style.display = 'block';
            return;
        }

        fetch('delete_subject.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ subjectId: subjectId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    formMessage.textContent = 'Subject deleted successfully!';
                    formMessage.className = 'success';
                    formMessage.style.display = 'block';
                    subjectDropdown.querySelector(`option[value="${subjectId}"]`).remove();
                } else {
                    formMessage.textContent = data.message || 'Failed to delete the subject.';
                    formMessage.className = 'error';
                    formMessage.style.display = 'block';
                }
            })
            .catch(error => {
                formMessage.textContent = 'Error occurred: ' + error.message;
                formMessage.className = 'error';
                formMessage.style.display = 'block';
            });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const classDropdown = document.getElementById('classDropdown');
    const subjectDropdown = document.getElementById('subjectDropdown');
    const formMessage = document.getElementById('assignSubjformMsg');

    fetch('get_classes.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                data.classes.forEach(cls => {
                    const option = document.createElement('option');
                    option.value = cls.ClassID;
                    option.textContent = `${cls.ClassID} - ${cls.ClassName}`;
                    classDropdown.appendChild(option);
                });
            } else {
                formMessage.textContent = data.message || 'Failed to load classes.';
                formMessage.className = 'error';
                formMessage.style.display = 'block';
            }
        })
        .catch(error => {
            formMessage.textContent = 'Error occurred: ' + error.message;
            formMessage.className = 'error';
            formMessage.style.display = 'block';
        });

    fetch('get_subjects.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                subjectDropdown.innerHTML = '<option value="">-- Select Subject --</option>';

                data.subjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.SubjectID;
                    option.textContent = `${subject.SubjectID} - ${subject.SubjectName}`;
                    subjectDropdown.appendChild(option);
                });
            } else {
                formMessage.textContent = data.message || 'Failed to load subjects.';
                formMessage.className = 'error';
                formMessage.style.display = 'block';
            }
        })
        .catch(error => {
            formMessage.textContent = 'Error occurred: ' + error.message;
            formMessage.className = 'error';
            formMessage.style.display = 'block';
        });

    // Handle Assign Action
    document.getElementById('assignSubjectButton').addEventListener('click', function () {
        const classId = classDropdown.value;
        const subjectId = subjectDropdown.value;

        if (!classId || !subjectId) {
            formMessage.textContent = 'Both Class and Subject must be selected.';
            formMessage.className = 'error';
            formMessage.style.display = 'block';
            return;
        }

        fetch('assign_subject.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ classId: classId, subjectId: subjectId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    formMessage.textContent = 'Subject assigned successfully!';
                    formMessage.className = 'success';
                    formMessage.style.display = 'block';
                } else {
                    formMessage.textContent = data.message || 'Failed to assign subject.';
                    formMessage.className = 'error';
                    formMessage.style.display = 'block';
                }
            })
            .catch(error => {
                formMessage.textContent = 'Error occurred: ' + error.message;
                formMessage.className = 'error';
                formMessage.style.display = 'block';
            });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const classDropdown = document.getElementById('classDropdown');
    const classSubjectsTable = document.getElementById('classSubjectsTable');
    const classSubjectsBody = document.getElementById('classSubjectsBody');
    const formMessage = document.getElementById('viewClassMsg');

    fetch('get_classes.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                data.classes.forEach(cls => {
                    const option = document.createElement('option');
                    option.value = cls.ClassID;
                    option.textContent = `${cls.ClassID} - ${cls.ClassName}`;
                    classDropdown.appendChild(option);
                });
            } else {
                formMessage.textContent = data.message || 'Failed to load classes.';
                formMessage.className = 'error';
                formMessage.style.display = 'block';
            }
        })
        .catch(error => {
            formMessage.textContent = 'Error occurred: ' + error.message;
            formMessage.className = 'error';
            formMessage.style.display = 'block';
        });

    document.getElementById('viewClassButton').addEventListener('click', function () {
        const classId = classDropdown.value;

        if (!classId) {
            formMessage.textContent = 'Please select a class.';
            formMessage.className = 'error';
            formMessage.style.display = 'block';
            return;
        }

        fetch(`view_class_subjects.php?classId=${classId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    classSubjectsBody.innerHTML = '';

                    const classRow = document.createElement('tr');
                    classRow.innerHTML = `<td colspan="1"><strong>${data.classInfo.ClassID} - ${data.classInfo.ClassName}</strong></td>`;
                    classSubjectsBody.appendChild(classRow);

                    if (data.subjects.length > 0) {
                        data.subjects.forEach(subject => {
                            const row = document.createElement('tr');
                            row.innerHTML = `<td>${subject.SubjectID} - ${subject.SubjectName}</td>`;
                            classSubjectsBody.appendChild(row);
                        });
                    } else {
                        const noSubjectsRow = document.createElement('tr');
                        noSubjectsRow.innerHTML = `<td>No subjects assigned to this class.</td>`;
                        classSubjectsBody.appendChild(noSubjectsRow);
                    }

                    classSubjectsTable.style.display = 'block';
                    formMessage.style.display = 'none';
                } else {
                    formMessage.textContent = data.message || 'Failed to fetch subjects.';
                    formMessage.className = 'error';
                    formMessage.style.display = 'block';
                }
            })
            .catch(error => {
                formMessage.textContent = 'Error occurred: ' + error.message;
                formMessage.className = 'error';
                formMessage.style.display = 'block';
            });
    });
});



function logOut() {
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = "logout.php";
    }
}
