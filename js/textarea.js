var area = document.getElementById('answerarea');
var inputname = document.getElementById('inputname');
var left = document.getElementById('leftsimbols');
var leftname = document.getElementById('leftsimbolsname');
var leftarea = document.getElementById('leftsimbolsarea');

if (area.addEventListener) {
  area.addEventListener('input', function() {
    if(left){
        left.textContent = 'Использовано ' + area.value.length + ' из 1000 доступных символов';
    }
    else if(leftarea){
        leftarea.textContent = 'Использовано ' + area.value.length + ' из 1000 доступных символов';
    }
}, false);
} else if (area.attachEvent) {
  area.attachEvent('onpropertychange', function() {
  });
}

if (inputname.addEventListener) {
  inputname.addEventListener('input', function() {
    if(leftname){
      leftname.textContent = 'Использовано ' + inputname.value.length + ' из 150 доступных символов';
    }
}, false);
} else if (inputname.attachEvent) {
  inputname.attachEvent('onpropertychange', function() {
  });
}