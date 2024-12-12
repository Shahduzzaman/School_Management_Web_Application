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


document.getElementById('searchUserButton').addEventListener('click', function() {
    const userId = document.getElementById('searchUserId').value;

    if (userId) {
        console.log('User ID:', userId);  // Debugging line

        fetch('search_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `searchUserId=${userId}`
        })
        .then(response => response.json())
        .then(user => {
            console.log('User response:', user);  // Debugging line

            if (user.error) {
                alert(user.error);
            } else {
                document.getElementById('name').value = user.name;
                document.getElementById('dob').value = user.dob;
                document.getElementById('fatherName').value = user.fathers_name;
                document.getElementById('motherName').value = user.mothers_name;
                document.getElementById('guardianContact').value = user.guardian_contact;
                document.getElementById('presentAddress').value = user.present_address;
                document.getElementById('permanentAddress').value = user.permanent_address;
                document.getElementById('password').value = user.password;
                document.getElementById('reEnterPassword').value = user.password;
            }
        })
        .catch(error => console.error('AJAX Error:', error));  // Debugging AJAX errors
    } else {
        alert('Please enter a User ID');
    }
});




function logOut() {
    alert("Logging out...");
    window.location.href = "login.php";
}