let username = document.querySelector("#username");
let email = document.querySelector("#email");
let password = document.querySelector("#password");
let register_btn = document.querySelector("#sign_up");

register_btn.addEventListener("click", function (go) {
  go.preventDefault();

  if (username.value === "" || email.value === "" || password.value === "") {
    alert("Please fill all data");
  } else {
    localStorage.setItem("username", username.value);
    localStorage.setItem("email", email.value);
    localStorage.setItem("password", password.value);

    alert("Account created successfully!");

    setTimeout(() => {
      window.location = "sign in.html";
    }, 1500);
  }
});
