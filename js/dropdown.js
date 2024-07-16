/* Когда пользователь нажимает на кнопку, переключаться раскрывает содержимое */
function showProfile() {
    document.getElementById("myDropdown").classList.toggle("show");

    var myDropdown2 = document.getElementById("myDropdown2");
    if (myDropdown2 && myDropdown2.classList.contains('show')){
      myDropdown2.classList.remove('show');
    }

    var myDropdown3 = document.getElementById("myDropdown3");
    if (myDropdown3 && myDropdown3.classList.contains('show')){
      myDropdown3.classList.remove('show');
    }
}

function showSearch() {
    document.getElementById("myDropdown2").classList.toggle("show");

    var myDropdown = document.getElementById("myDropdown");
    if (myDropdown && myDropdown.classList.contains('show')){
      myDropdown.classList.remove('show');
    }

    var myDropdown3 = document.getElementById("myDropdown3");
    if (myDropdown3 && myDropdown3.classList.contains('show')){
      myDropdown3.classList.remove('show');
    }
}

function showMenu() {
    document.getElementById("myDropdown3").classList.toggle("show");

    var myDropdown = document.getElementById("myDropdown");
    if (myDropdown && myDropdown.classList.contains('show')){
      myDropdown.classList.remove('show');
    }

    var myDropdown2 = document.getElementById("myDropdown2");
    if (myDropdown2 && myDropdown2.classList.contains('show')){
      myDropdown2.classList.remove('show');
    }
}
  
// Закрыть раскрывающийся список, если пользователь щелкнет за его пределами.
window.onclick = function(e) {
  if (e.target.matches('.searchButton') || e.target.matches('.searchField') || e.target.matches('#myDropdown2')) {
    return;
  }

  if (!e.target.matches('.dropbtn')) {
    var myDropdown = document.getElementById("myDropdown");
    if (myDropdown.classList.contains('show')) {
      myDropdown.classList.remove('show');
    }
    var myDropdown2 = document.getElementById("myDropdown2");
      if (myDropdown2 && myDropdown2.classList.contains('show')) {
        myDropdown.classList.remove('show');
    }
    var myDropdown3 = document.getElementById("myDropdown3");
      if (myDropdown3 && myDropdown3.classList.contains('show')) {
        myDropdown.classList.remove('show');
    }
  }
}