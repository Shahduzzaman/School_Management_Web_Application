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






function logOut() {
    alert("Logging out...");
    window.location.href = "login.php";
}