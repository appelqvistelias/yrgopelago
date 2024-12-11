// Handles the room feature display
const roomDropdown = document.querySelector('#room');
const economySelect = document.querySelector('.economy-select');
const standardSelect = document.querySelector('.standard-select');
const luxurySelect = document.querySelector('.luxury-select');

function handleRoomSelection(e) {
    const selectedRoom = e.target.value;

    economySelect.style.display = 'none';
    standardSelect.style.display = 'none';
    luxurySelect.style.display = 'none';

    if (selectedRoom === 'economy') {
        economySelect.style.display = 'block';
    } else if (selectedRoom === 'standard') {
        standardSelect.style.display = 'block';
    } else if (selectedRoom === 'luxury') {
        luxurySelect.style.display = 'block';
    }
}

roomDropdown.addEventListener('change', handleRoomSelection);

// Price
    const roomPrice = document.querySelector('.room-price');
    const featuresPrice = document.querySelector('.features-price');
    const totalPrice = document.querySelector('.total-price');

    function priceCalculator(e) {
        const selectedRoom = e.target.value;

        if (selectedRoom === 'economy') {
            roomPrice.textContent = '$1'
        } else if (selectedRoom === 'standard') {
            roomPrice.textContent = '$2'
        } else if (selectedRoom === 'luxury') {
            roomPrice.textContent = '$4'
        }
    }

// Booking
document.querySelector('form').addEventListener('submint', function(event) {
    event.preventDefault();

    // Creates an object of the booker
    const bookingData = {
        startdate: document.querySelector('#startdate').value,
        enddate: document.querySelector('#enddate').value,
        roomType: document.querySelector('#room').value,
        economyOptions: getCheckedOptions('economy-options[]'),
        standardOptions: getCheckedOptions('standard-options[]'),
        luxuryOptions: getCheckedOptions('luxury-options[]'),
        firstname: document.querySelector('#firstname').value,
        lastname: document.querySelector('#lastname').value,
        transferCode: document.querySelector('#transfer-code').value
    };

    // TODO: Skicka iväg eller paketera datan för att kunna användas.
});

// Function to fetch checkbox values
function getCheckedOptions(option) {
    const checkboxes = document.querySelectorAll(`input[name="${option}"]:checked`);
    const values = [];
    checkboxes.forEach(checkbox => values.push(checkbox.value));
    return values;
}

// Function to send data to server
// TODO