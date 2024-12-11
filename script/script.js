// Room features display
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

// Price calculations
const checkboxes = document.querySelectorAll('input[type="checkbox"]');

const roomPriceElement = document.querySelector('.room-price');
const featuresPriceElement = document.querySelector('.features-price');
const totalPriceElement = document.querySelector('.total-price');

function calculatePrices() {
    const selectedRoomOption = roomDropdown.options[roomDropdown.selectedIndex];
    const roomPrice = parseInt(selectedRoomOption.getAttribute('data-price')) || 0;

    let featuresPrice = 0;
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            featuresPrice += parseInt(checkbox.getAttribute('data-price')) || 0;
        }
    });

    const totalPrice = roomPrice + featuresPrice;

    roomPriceElement.textContent = roomPrice;
    featuresPriceElement.textContent = featuresPrice;
    totalPriceElement.textContent = totalPrice;
}

roomDropdown.addEventListener('change', calculatePrices);
checkboxes.forEach(checkbox => checkbox.addEventListener('change', calculatePrices));

calculatePrices();

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