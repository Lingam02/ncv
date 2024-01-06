//--------Main toggle function starts--------
 var el = document.getElementById("wrapper");
 var toggleButton = document.getElementById("menu-toggle");

 toggleButton.onclick = function () {
   el.classList.toggle("toggled");
};
//--------Main toggle function ends--------

  function handleEnterKey(event, nextElementId) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const nextElement = document.getElementById(nextElementId);
        nextElement.focus();
    }
}

// window.onload = function() {
//   var userType = document.getElementById('u_type').value;

//   if (userType == ' ADMIN') {
//     document.getElementById('01').style.display = "block";
//   } else {
//     document.getElementById('01').style.display = "none";
//   }
// };

document.addEventListener('keypress', function(event) {
  if (event.key === 'Enter') {
      event.preventDefault();
  }
});