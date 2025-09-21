document.addEventListener("DOMContentLoaded", () => {
    // ... existing code ...

    // Handle form submission for booking
    serviceForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const selectedOptions = Array.from(document.querySelectorAll('input[name="options[]"]:checked')).map(cb => cb.value);
        const quantities = {};

        selectedOptions.forEach(option => {
            let qty = 1;
            if (currentService.title === "Vacuum Cleaning" && option === "more_than_1_bedroom") {
                qty = parseInt(prompt("Enter the number of bedrooms:"), 10) || 1;
            } else if (currentService.title === "Ironing") {
                qty = parseInt(prompt("Enter the number of clothes:"), 10) || 1;
            } else if (currentService.title === "Washing Clothes") {
                qty = parseInt(prompt("Enter the number of laundry baskets:"), 10) || 1;
            }
            quantities[option] = qty;
        });

        const totalCost = totalCostSpan.textContent;

        // Send booking data to book_service.php via AJAX
        fetch('book_service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'service': currentService.title.toLowerCase().replace(' ', '_'),
                'options': JSON.stringify(selectedOptions),
                'quantities': JSON.stringify(quantities),
                'total_price': totalCost
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                // Reset form or redirect as needed
                serviceForm.reset();
                serviceDetails.classList.add("hidden");
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});



