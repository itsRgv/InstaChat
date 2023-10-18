const form = document.querySelector(".typing-area"),
  sendBtn = form.querySelector("button"),
  inputField = form.querySelector(".input-field"),
  chatBox = document.querySelector(".chat-box");

form.onsubmit = function (e) {
  e.preventDefault();
};
sendBtn.onclick = () => {
  // starting Ajax
  let xhr = new XMLHttpRequest(); // creating XML object
  xhr.open("POST", "php/insert-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        inputField.value = "";
        scrollToBottom();
      }
    }
  };

  //we have to send the form data through ajax to php
  let formData = new FormData(form); //creating new formData object
  xhr.send(formData); //sending the formData to php
};
chatBox.onmouseenter = () => {
  chatBox.classList.add("active");
};
chatBox.onmouseleave = () => {
  chatBox.classList.remove("active");
};
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/retrieve-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatBox.innerHTML = data;
        if (!chatBox.classList.contains("active")) scrollToBottom();
      }
    }
  };
  //we have to send the form data through ajax to php
  let formData = new FormData(form); //creating new formData object
  xhr.send(formData); //sending the formData to php
}, 500);

function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}
