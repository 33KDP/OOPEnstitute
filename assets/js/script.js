$(document).ready(function() {$('#loginModal').modal('show');
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
});

$(document).ready(function() {$('#sigupModal').modal('show');
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
});

function hide() {
  var x = document.getElementById("grade");
    x.style.display = "none";
}
function show() {
  var x = document.getElementById("grade");
    x.style.display = "block";
}
window.addEventListener('DOMContentLoaded', (event) => {
  var x = document.getElementById("grade");
  x.style.display = "none";
});


