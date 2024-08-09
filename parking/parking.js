document.addEventListener("DOMContentLoaded", function () {
    const parkingLot = document.getElementById('parkingLot');

    // Fetch parking spaces data from the server
    fetch('get_parking_data.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(space => {
                const spaceDiv = document.createElement('div');
                spaceDiv.classList.add('parking-space');
                spaceDiv.classList.add(space.status);
                spaceDiv.textContent = `Space ${space.space_number}`;
                spaceDiv.dataset.id = space.id;

                if (space.status === 'available') {
                    spaceDiv.addEventListener('click', () => {
                        bookParkingSpace(space.id);
                    });
                }

                parkingLot.appendChild(spaceDiv);
            });
        })
        .catch(error => console.error('Error fetching parking data:', error));
});

function bookParkingSpace(spaceId) {
    fetch(`book_space.php?id=${spaceId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Space booked successfully!');
                location.reload();  // Reload the page to update the parking lot
            } else {
                alert('Failed to book the space.');
            }
        })
        .catch(error => console.error('Error booking parking space:', error));
}
