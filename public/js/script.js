$(document).ready(function() {
  var reussite = document.getElementById('success');
  if (reussite != null && reussite.hidden == false) {
    setTimeout(function() {
      reussite.hidden = true;
    }, 5000);
  }
})
