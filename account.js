document.addEventListener("DOMContentLoaded", () => {
    const clientBtn = document.getElementById("clientBtn");
    const providerBtn = document.getElementById("providerBtn");
    const accountStatus = document.getElementById("accountStatus");

    // Simulated behavior for active status
    const isSignedUp = true; // Replace this with real sign-up validation

    // Update account status based on sign-up
    if (isSignedUp) {
        accountStatus.textContent = "Active";
    } else {
        accountStatus.textContent = "Inactive";
    }

    // Event listeners for buttons
    clientBtn.addEventListener("click", () => {
        alert("You selected Client role.");
    });

    providerBtn.addEventListener("click", () => {
        alert("You selected Service Provider role.");
    });
});
