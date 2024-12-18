// Check room-date availability
fetch('calendar.php')
    .then(response => response.json())
    .then(bookedDates => {
        const roomDropdown = document.getElementById('room');

        document.getElementById('startdate').addEventListener('change', () => filterRoomOptions(bookedDates));
        document.getElementById('enddate').addEventListener('change', () => filterRoomOptions(bookedDates));

        function filterRoomOptions(bookedDates) {
            const startDate = document.getElementById('startdate').value;
            const endDate = document.getElementById('enddate').value;

            Array.from(roomDropdown.options).forEach(option => {
                const roomTypeId = option.value;
                const isBooked = bookedDates.some(dateObj => dateObj.date === startDate && dateObj.roomType == roomTypeId);

                option.disabled = isBooked; // Disable room types that are booked
            });

            // Reset to default if no options are available
            if ([...roomDropdown.options].every(option => option.disabled)) {
                roomDropdown.selectedIndex = 0;
            }
        }
    })
    .catch(error => console.error('Error fetching booked dates:', error));

// Price calculation for user feedback
const roomDropdown = document.querySelector('#room');
const checkboxes = document.querySelectorAll('input[type="checkbox"]');

const roomPriceElement = document.querySelector('.room-price');
const featuresPriceElement = document.querySelector('.features-price');
const totalPriceElement = document.querySelector('.total-price');

function calculatePrices() {
    const selectedRoomOption = roomDropdown.options[roomDropdown.selectedIndex];
    let roomPrice = parseInt(selectedRoomOption.getAttribute('data-price')) || 0;

    // Calculate total number of days
    const startDateInput = document.getElementById('startdate').value;
    const endDateInput = document.getElementById('enddate').value;

    if (!startDateInput || !endDateInput) {
        alert("Please enter arrival and departure dates!");
        roomDropdown.selectedIndex = 0;
        checkboxes.forEach(checkbox => checkbox.checked = false);
        return;
    }

    const startDate = new Date(startDateInput);
    const endDate = new Date(endDateInput);

    const timeDifference = endDate - startDate; // in milliseconds
    const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24) + 1); // convert to days

    let featuresPrice = 0;
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            featuresPrice += parseInt(checkbox.getAttribute('data-price')) || 0;
        }
    });
    
    roomPrice *= daysDifference;
    const totalPrice = roomPrice + featuresPrice;

    roomPriceElement.textContent = '$' + roomPrice;
    featuresPriceElement.textContent = '$' + featuresPrice;
    totalPriceElement.textContent = '$' + totalPrice;
}

roomDropdown.addEventListener('change', calculatePrices);
checkboxes.forEach(checkbox => checkbox.addEventListener('change', calculatePrices));


// Fetch bookings data and/or errors for user feedback
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("booking-form");
    const feedbackDiv = document.querySelector(".user-feedback");

    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        // Clear old feedback
        while (feedbackDiv.firstChild) {
            feedbackDiv.removeChild(feedbackDiv.firstChild);
        }

        // Collect data from form
        const formData = new FormData(form);

        try {
            // Sending POST request
            const response = await fetch(form.action, {
                method: form.method,
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                // Booking successful
                const successMessage = document.createElement("p");
                successMessage.classList.add('success-message');
                successMessage.textContent = "Booking successful!";
                feedbackDiv.appendChild(successMessage);

                const detailsList = document.createElement("ul");

                // Add details from response
                for (const [key, value] of Object.entries(result.data)) {
                    const listItem = document.createElement("li");

                    if (typeof value === "object" && !Array.isArray(value)) {
                        listItem.textContent = `${key}:`;
                        const nestedList = document.createElement("ul");
                        for (const [nestedKey, nestedValue] of Object.entries(value)) {
                            const nestedItem = document.createElement("li");
                            nestedItem.textContent = `${nestedKey}: ${nestedValue}`;
                            nestedList.appendChild(nestedItem);
                        }
                        listItem.appendChild(nestedList);
                    } else {
                        listItem.textContent = `${key}: ${value}`;
                    }

                    detailsList.appendChild(listItem);
                }

                feedbackDiv.appendChild(detailsList);
            } else {
                const errorMessage = document.createElement("p");
                errorMessage.classList.add('error-message');
                errorMessage.textContent = `Error: ${result.message}`;
                feedbackDiv.appendChild(errorMessage);
            }
        } catch (error) {
            const errorMessage = document.createElement("p");
            errorMessage.classList.add('error-message');
            errorMessage.textContent = `Something went wrong: ${error.message}`;
            feedbackDiv.appendChild(errorMessage);
        }
    });
});