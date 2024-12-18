// Check date availability
fetch('calendar.php')
    .then(response => response.json())
    .then(bookedDates => {
        const startInput = document.getElementById('startdate');
        const endInput = document.getElementById('enddate');

        // Prevent user from selecting booked dates
        [startInput, endInput].forEach(input => {
            input.addEventListener('change', () => {
                // Disable booked dates
                const allDateInputs = document.querySelectorAll('input[type="date"]');
                allDateInputs.forEach(dateInput => {
                    if (bookedDates.includes(dateInput.value)) {
                        dateInput.disabled = true;
                    }
                });

                // Alert and clear if selected date is booked
                if (bookedDates.includes(input.value)) {
                    alert('This date is already booked!');
                    input.value = '';
                }
            });
        });
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