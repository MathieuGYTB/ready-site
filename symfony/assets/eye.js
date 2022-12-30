const eyeOn = document.querySelector('.eye-on');
const eyeOff = document.querySelector('.eye-off');
const passwordField = document.querySelector('#inputPassword');

eyeOn.addEventListener('click', () => {
  eyeOn.style.display= "none";
  eyeOff.style.display= "block";
  passwordField.type= "text";
});

eyeOff.addEventListener('click', () => {
  eyeOff.style.display= "none";
  eyeOn.style.display= "block";
  passwordField.type= "password";
});