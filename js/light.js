document.addEventListener("DOMContentLoaded", docReady);
function docReady() {
  for (var i = 0; i < document.getElementsByTagName("td").length; i++) {
    switch (document.getElementsByTagName("td")[i].textContent) {
      case "В работе":
        document.getElementsByTagName("td")[
          i
        ].parentNode.style.backgroundColor = "#E6E6FA";
        break;
      case "Выполнено":
        document.getElementsByTagName("td")[
          i
        ].parentNode.style.backgroundColor = "white";
        break;
    }
  }
}
