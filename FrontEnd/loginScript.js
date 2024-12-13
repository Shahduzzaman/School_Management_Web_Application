async function login(username, password) {
    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        });
        
        const data = await response.json();
        
        if (data.success) {
            sessionStorage.setItem("studentId", data.studentId);
            window.location.href = "/dashboard.html";
        } else {
            alert(data.message || "Login failed");
        }
    } catch (error) {
        console.error("Login error:", error);
        alert("Unable to log in. Please try again.");
    }
}


document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById("togglePassword");
    const passwordField = document.getElementById("password");

    togglePassword.addEventListener("click", function () {
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);

        this.textContent = type === "password" ? "👁‍🗨️" : "👁️";
    });
});


var closeBtns = document.getElementsByClassName("closebtn");
        for (var i = 0; i < closeBtns.length; i++) {
            closeBtns[i].addEventListener("click", function(){
                this.parentElement.style.display = "none";
            });
        }