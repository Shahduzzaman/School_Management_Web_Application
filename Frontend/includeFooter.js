function includeFooter() {
    const footerElement = document.querySelector('[data-include-footer]');
    if (footerElement) {
        fetch("footer.html")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
            .then(data => {
                footerElement.innerHTML = data;
            })
            .catch(err => console.error("Failed to load footer:", err));
    }
}
document.addEventListener("DOMContentLoaded", includeFooter);
