const pswrdField = document.querySelector(
  ".form .field input[type = 'password']"
);
const toggleBtn = document.querySelector(".form .field i");

toggleBtn.onclick = function () {
  // console.log("Hi");
  if (pswrdField.type === "password") {
    toggleBtn.classList.add("active");
    pswrdField.type = "text";
  } else {
    pswrdField.type = "password";
    toggleBtn.classList.remove("active");
  }
};
