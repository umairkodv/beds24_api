function fetchRooms() {
  const checkin = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;
  const guests = document.getElementById('guests').value;

  if (!checkin || !checkout || !guests) {
    alert('Please select check-in, check-out dates, and number of guests.');
    return;
  }

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
  const checkin = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;

  window.location.href = `php/checkout.php?roomId=${roomId}&roomName=${roomName}&price=${price}&checkin=${checkin}&checkout=${checkout}&guests=${guests}`;
}
