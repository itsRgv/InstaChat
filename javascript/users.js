const searchBar = document.querySelector(".wrapper .users .search input"),
  searchBtn = document.querySelector(".users .search button"),
  usersList = document.querySelector(".users .users-list");

searchBtn.onclick = function () {
  searchBar.classList.toggle("active");
  searchBar.focus();
  searchBtn.classList.toggle("active");
  searchBar.value = "";
};

searchBar.onkeyup = () => {
  let searchTerm = searchBar.value;
  //let's start ajax

  // since ajax was running two times
  if (searchTerm != "") {
    searchBar.classList.add("active");
  } else searchBar.classList.remove("active");
  let xhr = new XMLHttpRequest(); // creating an XML object
  xhr.open("POST", "php/search.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        // console.log(data);
        usersList.innerHTML = data;
      }
    }
  };
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
};

setInterval(() => {
  let xhr = new XMLHttpRequest(); // creating XML object
  xhr.open("GET", "php/users.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        // console.log(data);
        if (!searchBar.classList.contains("active")) {
          // if seearch bar doesn't contain active class
          usersList.innerHTML = data;
        }
      }
    }
  };
  xhr.send();
}, 500); // this function is called after every 500ms
