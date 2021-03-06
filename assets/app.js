/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import "./styles/register.css";
import "./styles/login.css";

// You can specify which plugins you need
import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import { DateTime } from "luxon";


var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})



//check if the room is available.

/* //api fetch 
const fetchButton = document.getElementById('available');

fetchButton.addEventListener('click', function() {
  const url = '/fetchroom';
  var e = document.getElementById("booking_roomId");
  var strUser = e.value;
  console.log(strUser);

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

