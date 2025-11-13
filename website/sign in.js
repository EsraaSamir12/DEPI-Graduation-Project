let username = document.querySelector("#username");

let password = document.querySelector("#password");
let loginBtn = document.querySelector("#sign_in");

let getUser = localStorage.getItem("username");
let getPassword = localStorage.getItem("password");

loginBtn.addEventListener("click", function (go) {
  go.preventDefault();

  if (username.value === "" || password.value === "" ) {
    alert("Please fill all data");
  } else {
    if (
      getUser &&
      getUser.trim() === (username.value.trim()  ) &&
      getPassword &&
      getPassword === password.value
    ) {
      alert("Login successful!");
      setTimeout(() => {
        window.location = "index.html";
      }, 1500);
    } else {
      alert("Username or password is wrong!");
    }
  }
});
