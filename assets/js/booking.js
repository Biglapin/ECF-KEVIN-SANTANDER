// You can specify which plugins you need
import {
  Tooltip,
  Toast,
  Popover
} from 'bootstrap';
import {
  DateTime
} from "luxon";

// Modal booking 

let btnCheckAvailable = document.getElementById('available');
let btnBooking = document.getElementById('btnBooking').hidden = true;
let inputHotel = document.getElementById('booking_getHotelId').hidden = true;

btnCheckAvailable.addEventListener('click', function (e) {
  e.preventDefault();

  let roomName = document.querySelector('[name="booking[roomId]"').value;
  let hotelName = document.querySelector('[name="booking[getHotelId]"');
  let room = document.querySelector('[name="booking[roomId]').value;
  let inputCheckin = document.querySelector('[name="booking[checkin]');
  let inputCheckout = document.querySelector('[name="booking[checkout]');
  let dateCheckin = inputCheckin.value;
  let dateCheckout = inputCheckout.value;

  let url = '/fetchroom';
  url = url + '?roomid=' + room + '&checkin=' + dateCheckin + '&checkout=' + dateCheckout;

  // fetch room and check available 
  fetch(url).then((response) =>
    response.json().then((data) => {
      if (data == '400') {
        document.querySelector("#showAvailable").innerHTML = '<div class="alert alert-warning" role="alert">Oh no ! Not available ! </div>';
        let btnBooking = document.getElementById('btnBooking').hidden = true;

      }
      if (data == '200') {
        let btnBooking = document.getElementById('btnBooking').hidden = false;
        let btnCheckAvailable = document.getElementById('available').hidden = true;
        document.querySelector("#showAvailable").innerHTML = '<div class="alert alert-success text-center" role="alert">Yeah ! I\'m Free !' + '</div>';
      }
    }).catch((error) => {
      console.log(error);
    })
  );
});