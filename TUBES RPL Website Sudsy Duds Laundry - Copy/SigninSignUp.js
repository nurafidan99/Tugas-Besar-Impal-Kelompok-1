let container = document.getElementById('container');

function toggle() {
    container.classList.toggle('sign-in');
    container.classList.toggle('sign-up');
}

function signup() {
    const username = document.getElementById('signup-username').value;
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;
    const confirmPassword = document.getElementById('signup-confirm-password').value;

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return;
    }

    const payload = {
        username: username,
        email: email,
        password: password
    };

    google.script.run.withSuccessHandler(() => {
        alert('Registration successful!');
        toggle();
    }).withFailureHandler((error) => {
        alert('Registration failed: ' + error.message);
    }).doPost(payload);
}

function signin() {
    const username = document.getElementById('signin-username').value;
    const password = document.getElementById('signin-password').value;

    const payload = {
        username: username,
        password: password
    };

    google.script.run.withSuccessHandler((response) => {
        if (response.result === 'success') {
            alert('Sign in successful!');
            // Redirect or perform actions upon successful sign in
        } else {
            alert('Sign in failed: ' + response.message);
        }
    }).withFailureHandler((error) => {
        alert('Sign in failed: ' + error.message);
    }).doPost(payload);
}

setTimeout(() => {
    container.classList.add('sign-in');
}, 200);