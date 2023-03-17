const signupBtn = document.getElementById("signup-mode-btn");
signupBtn.style.display = "none";
const loginBtn = document.getElementById("login-mode-btn");
const loginContainerText = document.getElementById("login-container-text");
const loginForm = document.getElementById("login-form");
loginForm.style.display = "none";
const signupForm = document.getElementById("signup-form");
const backdrop = document.getElementById("p-modal");
const forgotBtn = document.getElementById("forgot-btn");
const closeBtn = document.getElementById("close-btn");

backdrop.style.display = "none";

backdrop.addEventListener("click", (e) => {
    if(e.target.id === "p-modal") {
        backdrop.style.display = "none";
    }
})

closeBtn.addEventListener("click", () => {
    backdrop.style.display = "none";
})

forgotBtn.addEventListener("click", () => {
    backdrop.style.display = null;
})

loginBtn.addEventListener("click",() => {
    signupBtn.style.display = null;
    loginBtn.style.display = "none";
    loginContainerText.innerHTML = "Not Connected With Us?";
    signupForm.style.display = "none";
    loginForm.style.display = null;

    
})

signupBtn.addEventListener("click", () => {
    signupBtn.style.display = "none";
    loginBtn.style.display = null;
    loginContainerText.innerHTML = "Already Connected With Us?";
    signupForm.style.display = null;
    loginForm.style.display = "none";
})