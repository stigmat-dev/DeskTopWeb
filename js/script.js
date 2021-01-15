document.addEventListener("DOMContentLoaded", docReady);
function docReady() {
  for (var i = 0; i < document.getElementsByTagName("td").length; i++) {
    switch (document.getElementsByTagName("td")[i].textContent) {
      case "В работе":
        document.getElementsByTagName("td")[
          i
        ].parentNode.style.backgroundColor = "#e6e6fa";
        break;
      case "Выполнено":
        document.getElementsByTagName("td")[
          i
        ].parentNode.style.backgroundColor = "white";
        break;
    }
  }
}

setTimeout(function () {
  $(".msg").fadeOut("fast");
}, 4000);
