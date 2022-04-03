

// You can specify which plugins you need
import { Tooltip, Toast, Popover } from 'bootstrap';
import { DateTime } from "luxon";


/* 
 const fetchButton = document.getElementById('available');

fetchButton.addEventListener('click', function() {
  const url = '/fetchroom';

  fetch(url).then((response) => 
    response.json().then((data) => {
      console.log(data);
      let showAvailable = '<ul>';
      for(let rooms of data) {
        showAvailable += `<li>${rooms.title}</li>`;
      }
      showAvailable += '</ul>';
      document.querySelector("#showAvailable").innerHTML = showAvailable;

    })
  );
}); */

// Modal booking 

const fetchButton = document.getElementById('available');

fetchButton.addEventListener('click', function(e) {
  e.preventDefault();
  const url = '/fetchroom';
  let room = document.querySelector('[name="booking[roomId]').value;
  let dateCheckout = document.querySelector('[name="booking[checkout]');
  let dateCheckin = document.querySelector('[name="booking[checkin]');

console.log(room);
console.log(dateCheckin.value);
console.log(dateCheckout.value);


  fetch(url).then((response) => 
   response.json().then((data) => {
      console.log(data);      

    


 /*      let showAvailable = '<ul>';
      for(let rooms of data) {
        showAvailable += `<li>${rooms.title}</li>`;
      }
      showAvailable += '</ul>';
      document.querySelector("#showAvailable").innerHTML = showAvailable; */
    })
  );
});