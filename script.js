console.log("JS connected");

// Search validation
function validateSearch() {
    let source = document.querySelector("input[name='source']");
    let destination = document.querySelector("input[name='destination']");
    let date = document.querySelector("input[name='date']");

    if (!source || !destination || !date) {
        return true;
    }

    if (source.value === "" || destination.value === "" || date.value === "") {
        alert("Please fill all fields");
        return false;
    }

    alert("Searching flights...");
    return true;
}

// Booking popup
function bookingPopup() {
    alert("Flight booking in process...");
    return true;
}

// Logout
function logout() {
    alert("Logged out successfully");
    window.location.href = "login.html";
}

// Profile menu toggle
function toggleMenu() {
    let menu = document.getElementById("profileMenu");

    if (!menu) return;

    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

// Close dropdown on outside click
document.addEventListener("click", function(event) {
    let menu = document.getElementById("profileMenu");

    if (!menu) return;

    if (!event.target.closest("#profileMenu") && !event.target.closest("img")) {
        menu.style.display = "none";
    }
});
// Save form data
document.addEventListener("input", function(e) {
    if (e.target.name) {
        localStorage.setItem(e.target.name, e.target.value);
    }
});

// Load saved data
window.addEventListener("load", function() {
    let inputs = document.querySelectorAll("input");

    inputs.forEach(input => {
        let savedValue = localStorage.getItem(input.name);
        if (savedValue) {
            input.value = savedValue;
        }
    });
});