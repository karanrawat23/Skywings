console.log("Skywings - JS Connected ✅");

// ================= SEARCH VALIDATION =================
function validateSearch() {
    let source = document.querySelector("input[name='source']");
    let destination = document.querySelector("input[name='destination']");
    let date = document.querySelector("input[name='date']");

    if (!source || !destination || !date) {
        return true;
    }

    if (source.value === "" || destination.value === "" || date.value === "") {
        showAlert("Please fill all fields", "error");
        return false;
    }

    if (source.value === destination.value) {
        showAlert("Source and destination cannot be the same!", "error");
        return false;
    }

    let selectedDate = new Date(date.value);
    let today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selectedDate < today) {
        showAlert("Please select a future date!", "error");
        return false;
    }

    showAlert("Searching flights...", "info");
    return true;
}

// ================= BOOKING POPUP =================
function bookingPopup() {
    showAlert("Flight booking in process...", "info");
    return true;
}

// ================= LOGOUT FUNCTION =================
function logout() {
    if (confirm("Are you sure you want to logout?")) {
        showAlert("Logged out successfully", "success");
        window.location.href = "login.html";
    }
}

// ================= PROFILE MENU TOGGLE =================
function toggleMenu() {
    let menu = document.getElementById("profileMenu");
    if (!menu) return;

    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

// ================= CLOSE DROPDOWN ON OUTSIDE CLICK =================
document.addEventListener("click", function(event) {
    let menu = document.getElementById("profileMenu");
    let profileImg = document.querySelector(".user-profile img");
    
    if (!menu) return;

    if (!event.target.closest("#profileMenu") && event.target !== profileImg) {
        menu.style.display = "none";
    }
});

// ================= SAVE FORM DATA (Auto Save) =================
/*document.addEventListener("input", function(e) {
    if (e.target.name) {
        localStorage.setItem(e.target.name, e.target.value);
    }
});

// ================= LOAD SAVED FORM DATA =================
window.addEventListener("load", function() {
    let inputs = document.querySelectorAll("input, select, textarea");
    
    inputs.forEach(input => {
        let savedValue = localStorage.getItem(input.name);
        if (savedValue) {
            input.value = savedValue;
        }
    });
});*/

// ================= CLEAR SAVED DATA ON LOGOUT =================
function clearSavedData() {
    localStorage.clear();
    sessionStorage.clear();
}

// ================= CUSTOM ALERT FUNCTION (Better than default alert) =================
function showAlert(message, type) {
    // Check if custom alert already exists
    let existingAlert = document.querySelector(".custom-alert");
    if (existingAlert) {
        existingAlert.remove();
    }

    // Create alert element
    let alertBox = document.createElement("div");
    alertBox.className = `custom-alert alert-${type}`;
    alertBox.innerHTML = `
        <div class="alert-content">
            <i class="fa-solid ${getIcon(type)}"></i>
            <span>${message}</span>
        </div>
    `;

    // Style the alert
    alertBox.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        padding: 15px 25px;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        animation: slideIn 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    `;

    // Set colors based on type
    if (type === "error") {
        alertBox.style.background = "#e74c3c";
        alertBox.style.color = "white";
    } else if (type === "success") {
        alertBox.style.background = "#2ecc71";
        alertBox.style.color = "white";
    } else {
        alertBox.style.background = "#3498db";
        alertBox.style.color = "white";
    }

    document.body.appendChild(alertBox);

    // Remove after 3 seconds
    setTimeout(() => {
        alertBox.style.animation = "slideOut 0.3s ease";
        setTimeout(() => {
            if (alertBox) alertBox.remove();
        }, 300);
    }, 3000);
}

function getIcon(type) {
    if (type === "error") return "fa-circle-exclamation";
    if (type === "success") return "fa-circle-check";
    return "fa-info-circle";
}

// ================= ADD CSS FOR ALERTS =================
const alertStyles = document.createElement("style");
alertStyles.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .custom-alert {
        cursor: pointer;
    }
    
    .custom-alert:hover {
        opacity: 0.9;
    }
    
    .alert-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .alert-content i {
        font-size: 18px;
    }
`;
document.head.appendChild(alertStyles);

// ================= PREVENT BACK BUTTON AFTER LOGOUT =================
window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});

// ================= DISABLE RIGHT CLICK (Optional - Security) =================
// document.addEventListener("contextmenu", function(e) {
//     e.preventDefault();
// });

console.log("Skywings - All features loaded ✅");