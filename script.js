// Modal functionality
const signupBtn = document.getElementById('signupBtn');
const loginBtn = document.getElementById('loginBtn');
const signupModal = document.getElementById('signupModal');
const loginModal = document.getElementById('loginModal');
const closeBtns = document.querySelectorAll('.close');

// Open modals
signupBtn.onclick = () => signupModal.style.display = 'flex';
loginBtn.onclick = () => loginModal.style.display = 'flex';

// Close modals
closeBtns.forEach(btn => btn.onclick = () => {
    signupModal.style.display = 'none';
    loginModal.style.display = 'none';
});
