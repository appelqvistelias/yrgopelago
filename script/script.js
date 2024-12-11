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

handleRoomSelection({ target: roomDropdown });
