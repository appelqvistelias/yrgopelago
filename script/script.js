// Visual calendar function
function createCalendar(bookedDates) {
    const calendarGrid = document.querySelector('.calendar-grid');
    // Hard coded due to assignment
    const year = 2025;
    const month = 0;

    const firstDay = new Date(year, month, 1).getDay();
    const startingDay = firstDay === 0 ? 6 : firstDay - 1;
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // empty cells before first date
    for (let i = 0; i < startingDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day';
        calendarGrid.appendChild(emptyDay);
    }

    // Create cells for days
    for (let day = 1; day <= daysInMonth; day++) {
        const dayCell = document.createElement('div');
        dayCell.className = 'calendar-day';

        // Add the date number
        const dateNumber = document.createElement('div');
        dateNumber.textContent = day;
        dayCell.appendChild(dateNumber);

        // Format date to match data format
        const currentDate = `2025-01-${day.toString().padStart(2, '0')}`;

        // Status for each room type
        const roomTypes = [
            {id: 1, name: 'Economy'},
            {id: 2, name: 'Standard'},
            {id: 3, name: 'Luxury'}
        ];

        roomTypes.forEach(room => {
            const roomStatus = document.createElement('div');

            // Check if the room is booked on the current date, return true if it is
            const isBooked = bookedDates.some(dateObj => 
                dateObj.date === currentDate &&
                dateObj.roomType === room.id
            );

            roomStatus.classList.add(isBooked ? 'booked' : 'available');
            roomStatus.textContent = room.name;
            dayCell.appendChild(roomStatus);
        });

        calendarGrid.appendChild(dayCell);
    }
}

// Function to filter room options based on booked dates
function filterRoomOptions(bookedDates) {
    const roomDropdown = document.getElementById('room');
    const startDateInput = document.getElementById('startdate');
    const endDateInput = document.getElementById('enddate');
    
    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);

    if (!startDateInput.value || !endDateInput.value) return;

    Array.from(roomDropdown.options).forEach(option => {
        if (option.value === "") return; // Skip placeholder option
        
        const roomTypeId = option.value;
        const isBooked = bookedDates.some(dateObj => {
            const bookedDate = new Date(dateObj.date);
            return dateObj.roomType == roomTypeId && 
                   bookedDate >= startDate && 
                   bookedDate <= endDate;
        });

        option.disabled = isBooked; // Disable room types that are booked
    });

    // Reset to default if no options are available
    if ([...roomDropdown.options].slice(1).every(option => option.disabled)) {
        roomDropdown.selectedIndex = 0;
    }
}

// Check room-date availability
fetch('calendar.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to fetch booked dates');
        }
        return response.json();
    })
    .then(bookedDates => {
        const startDateInput = document.getElementById('startdate');
        const endDateInput = document.getElementById('enddate');
        
        startDateInput.addEventListener('change', () => filterRoomOptions(bookedDates));
        endDateInput.addEventListener('change', () => filterRoomOptions(bookedDates));

        createCalendar(bookedDates);
    })
    .catch(error => console.error('Error fetching booked dates:', error));

// User feedback while filling form
const arrivalDateInput = document.getElementById('startdate');
const departureDateInput = document.getElementById('enddate');
const roomDropdown = document.querySelector('#room');
const checkboxes = document.querySelectorAll('input[type="checkbox"]');

const roomPriceElement = document.querySelector('.room-price');
const featuresPriceElement = document.querySelector('.features-price');
const totalPriceElement = document.querySelector('.total-price');

// Validation
function validateDateOrder() {
    const startDateInput = document.getElementById('startdate');
    const endDateInput = document.getElementById('enddate');

    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);

    if (startDate > endDate) {
        alert("Departure date must be after arrival date");
        startDateInput.value = '';
        endDateInput.value = '';
        roomDropdown.selectedIndex = 0;
        checkboxes.forEach(checkbox => checkbox.checked = false);
        roomPriceElement.textContent = '$0';
        featuresPriceElement.textContent = '$0';
        totalPriceElement.textContent = '$0';
        return false;
    }
    return true;
}

function validateFormSubmittingOrder() {
    const startDateInput = document.getElementById('startdate').value;
    const endDateInput = document.getElementById('enddate').value;

    if (!startDateInput || !endDateInput) {
        alert("Please enter arrival and departure dates");
        roomDropdown.selectedIndex = 0;
        checkboxes.forEach(checkbox => checkbox.checked = false);
        roomPriceElement.textContent = '$0';
        featuresPriceElement.textContent = '$0';
        totalPriceElement.textContent = '$0';
        return false;
    }
    return true;
}

// Price calculation
function calculatePrices() {
    const selectedRoomOption = roomDropdown.options[roomDropdown.selectedIndex];
    let roomPrice = parseInt(selectedRoomOption.getAttribute('data-price')) || 0;

    // Calculate total number of days
    const startDateInput = document.getElementById('startdate').value;
    const endDateInput = document.getElementById('enddate').value;

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
    let totalPrice = roomPrice + featuresPrice;

    roomPriceElement.textContent = '$' + roomPrice;
    featuresPriceElement.textContent = '$' + featuresPrice;
    totalPriceElement.textContent = '$' + totalPrice;
}

arrivalDateInput.addEventListener('change', () => {
    if (validateDateOrder()) {
        calculatePrices();
    }
});

departureDateInput.addEventListener('change', () => {
    if (validateDateOrder()) {
        calculatePrices();
    }
});

roomDropdown.addEventListener('change', () => {
    if (validateFormSubmittingOrder()) {
        calculatePrices();
    }
});

checkboxes.forEach(checkbox => checkbox.addEventListener('change', () => {
    if (validateFormSubmittingOrder()) {
        calculatePrices();
    }
}));

// User feedback after trying to book
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

                const islandName = document.createElement("p");
                islandName.textContent = "Island Name: " + result.data['island'];
                feedbackDiv.appendChild(islandName);

                const hotelName = document.createElement("p");
                hotelName.textContent = "Hotel Name: " + result.data['hotel'];
                feedbackDiv.appendChild(hotelName);

                const arrivalDate = document.createElement("p");
                arrivalDate.textContent = "Arrival: " + result.data['arrival_date'];
                feedbackDiv.appendChild(arrivalDate);

                const departureDate = document.createElement("p");
                departureDate.textContent = "Departure: " + result.data['departure_date'];
                feedbackDiv.appendChild(departureDate);

                const totalCost = document.createElement("p");
                totalCost.textContent = "Total Cost: $" + result.data['total_cost'];
                feedbackDiv.appendChild(totalCost);
                
                const stars = document.createElement("p");
                stars.textContent = "Stars: " + result.data['stars'];
                feedbackDiv.appendChild(stars);

                const roomType = document.createElement("p");
                roomType.textContent = "Room type: " + result.data['room_type'];
                feedbackDiv.appendChild(roomType);

                const features = document.createElement("p");
                features.textContent = "Features: " + result.data['features'].join(', ');
                feedbackDiv.appendChild(features);

                const additionalInfo = document.createElement("p");
                additionalInfo.textContent = result.data['additional_info']['greetings'];
                feedbackDiv.appendChild(additionalInfo);

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