// Price calculations
const roomDropdown = document.querySelector('#room');
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

// // Transfer JSON

// const form = document.querySelector('form');

// form.addEventListener('submit', (event) => {
//     event.preventDefault(); // Prevent the default form submission

//     const formData = new FormData(form);
//     fetch('https://yrgopelago.se/centralbank/transferCode', {
//         method: 'POST',
//         body: formData,
//     })
//     .then((response) => response.json())
//     .then((data) => {
//         console.log(data); // Log the response data to the console
//     })
//     .catch(console.error); // Handle any errors in the fetch process
// });