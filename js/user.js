function handleEnterKey(event, nextFieldId) {
  if (event.key === 'Enter') {
    event.preventDefault();
    document.getElementById(nextFieldId).focus();
  }
}

document.getElementById('userCreationForm').addEventListener('submit', function(event) {
  const workerName = document.getElementById('workerName').value;
  const workerNameError = document.getElementById('workerNameError');
  const userName = document.getElementById('userName').value;
  const userNameError = document.getElementById('userNameError');
  const password = document.getElementById('password').value;
  const passwordError = document.getElementById('passwordError');

  if (workerName.trim() === '') {
    workerNameError.classList.add('visible');
    event.preventDefault();
    return;
  } else {
    workerNameError.classList.remove('visible');
  }

  if (userName.trim() === '') {
    userNameError.classList.add('visible');
    event.preventDefault();
    return;
  } else {
    userNameError.classList.remove('visible');
  }

  if (password.trim() === '') {
    passwordError.classList.add('visible');
    event.preventDefault();
    return;
  } else {
    passwordError.classList.remove('visible');
  }

  // Additional validation checks can be added here.

  // If all validations pass, the form will submit.
});
// ... Your existing code ...
// ... Your existing code ...

document.getElementById('userCreationForm').addEventListener('submit', async function(event) {
  const workerNameInput = document.getElementById('workerName');
  const workerNameError = document.getElementById('workerNameError');
  const workerDuplicateError = document.getElementById('workerDuplicateError');

  const userNameInput = document.getElementById('userName');
  const userNameError = document.getElementById('userNameError');
  const userDuplicateError = document.getElementById('userDuplicateError');

  // Check if the worker name is already in use using AJAX
  const workerResponse = await fetch('check_worker_nam.php', {
    method: 'POST',
    body: new URLSearchParams({
      workerName: workerNameInput.value
    })
  });

  const workerData = await workerResponse.json();

  if (workerData.exists) {
    workerDuplicateError.classList.add('visible'); // Show the duplicate error message
    workerNameError.classList.remove('visible'); // Hide the required error message
    event.preventDefault();
    return;
  } else {
    workerDuplicateError.classList.remove('visible'); // Hide the duplicate error message
    if (workerNameInput.value.trim() === '') {
      workerNameError.classList.add('visible'); // Show the required error message if worker name is empty
      event.preventDefault();
      return;
    } else {
      workerNameError.classList.remove('visible'); // Hide the required error message
    }
  }

  // Check if the username is already in use using AJAX
  const userResponse = await fetch('check_username.php', {
    method: 'POST',
    body: new URLSearchParams({
      userName: userNameInput.value
    })
  });

  const userData = await userResponse.json();

  if (userData.exists) {
    userDuplicateError.classList.add('visible'); // Show the duplicate error message
    userNameError.classList.remove('visible'); // Hide the required error message
    event.preventDefault();
    return;
  } else {
    userDuplicateError.classList.remove('visible'); // Hide the duplicate error message
    if (userNameInput.value.trim() === '') {
      userNameError.classList.add('visible'); // Show the required error message if username is empty
      event.preventDefault();
      return;
    } else {
      userNameError.classList.remove('visible'); // Hide the required error message
    }
  }

  // Other validations ...

  // If all validations pass, the form will submit.
});

// ... Your existing code ...
