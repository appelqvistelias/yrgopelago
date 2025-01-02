document.addEventListener("DOMContentLoaded", () => {
    const rooms = document.querySelectorAll('.room');
    let currentRoomIndex = 0;

    function showNextRoom() {
        rooms[currentRoomIndex].classList.remove('active');
        currentRoomIndex = (currentRoomIndex + 1) % rooms.length;
        rooms[currentRoomIndex].classList.add('active');
    }

    // Initial display
    rooms[currentRoomIndex].classList.add('active');

    // Change room every 5 seconds
    setInterval(showNextRoom, 5000);
});