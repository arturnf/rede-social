document.addEventListener('DOMContentLoaded', function() {
   
    const passwordField = document.getElementById('password');
    const toggleIconX = document.querySelector('.password-toggle');

    
    toggleIconX.addEventListener('click', function() {
        
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        
        
        passwordField.setAttribute('type', type);
        
        
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });


    const confirmPasswordField = document.getElementById('confirmPassword');
    const toggleIconZ = document.querySelector('.password-toggleZ');

    
    toggleIconZ.addEventListener('click', function() {
        
        const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
        
        
        confirmPasswordField.setAttribute('type', type);
        
        
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
});


gsap.from(".graphic-element", {
    y: -100,
    opacity: 0,
    rotation: 70, 
    duration: 1,
});
gsap.from(".logo", {
    x: -100,
    opacity: 0,
    duration: 1,
});
gsap.from(".copyright", {
    x: -100,
    opacity: 0,
    duration: 1,
});
gsap.from(".login-title", {
    y: -100,
    x: -100,
    opacity: 0,
    duration: 1,
});
gsap.from(".login-form", {
    x: 100,
    opacity: 0,
    duration: 1,
});
gsap.from(".create-account-link", {
    x: 100,
    opacity: 0,
    duration: 1,
});