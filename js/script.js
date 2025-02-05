function fetchRooms() {
  const dateRange = document.getElementById('daterange').value;
  const guests = document.getElementById('guests').value;

  if (!dateRange || !guests) {
    alert('Please select a date range and number of guests.');
    return;
  }

  const dates = dateRange.split(', '); // Correct separator for Flatpickr
  if (dates.length !== 2) {
    alert('Please select a valid check-in and check-out date.');
    return;
  }

  const checkin = dates[0];
  const checkout = dates[1];

  fetch(`php/fetch_rooms.php?from=${checkin}&to=${checkout}&guests=${guests}`)
    .then((response) => response.json())
    .then((data) => {
      const roomList = document.getElementById('room-list');
      roomList.innerHTML = '';

      if (data.error) {
        roomList.innerHTML = `<p>Error: ${data.error}</p>`;
        return;
      }

      data.rooms.forEach((room) => {
        const roomItem = document.createElement('div');
        roomItem.classList.add('room-card');
        roomItem.innerHTML = `
                  <p><strong>${room.name}</strong></p>
                  <p>Price: <span style="color: #ff7b00; font-weight: bold;">$${room.price}</span> / night</p>
                  <p>For ${guests} guest(s)</p>
                  <button class="book-btn" onclick="bookRoom(${room.id}, '${room.name}', ${room.price}, ${guests})">Book Now</button>
              `;
        roomList.appendChild(roomItem);
      });
    })
    .catch((error) => console.error('Error fetching rooms:', error));
}

function bookRoom(roomId, roomName, price, guests) {
  const dateRange = document.getElementById('daterange').value;
  const dates = dateRange.split(', '); // Correct separator

  if (dates.length !== 2) {
    alert('Please select valid check-in and check-out dates.');
    return;
  }

  const checkin = new Date(dates[0]);
  const checkout = new Date(dates[1]);

  // Calculate the number of nights
  const timeDifference = checkout - checkin;
  const totalNights = Math.ceil(timeDifference / (1000 * 60 * 60 * 24)); // Convert milliseconds to days

  if (totalNights <= 0) {
    alert('Check-out date must be after check-in date.');
    return;
  }

  // Calculate the total price correctly
  const totalPrice = price * totalNights;

  // Redirect to checkout with correct total price
  window.location.href = `php/booking_details.php?roomId=${roomId}&roomName=${roomName}&price=${totalPrice}&checkin=${dates[0]}&checkout=${dates[1]}&guests=${guests}`;
}
