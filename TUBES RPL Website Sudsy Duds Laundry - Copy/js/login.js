let container = document.getElementById('container')

toggle = () => {
	container.classList.toggle('sign-in')
	container.classList.toggle('sign-up')
}

setTimeout(() => {
	container.classList.add('sign-in')
}, 200)
// File: login.js
function toggleLogin() {
    var loginForm = document.getElementById('loginForm');
    if (loginForm) { // Periksa apakah elemen loginForm ada
        if (loginForm.style.display === "none") {
            loginForm.style.display = "block";
        } else {
            loginForm.style.display = "none";
        }
    } else {
        console.error("Elemen dengan id 'loginForm' tidak ditemukan.");
    }
}