var xclicks = 0, a;
function xbtn (e) {
  e.preventDefault();
  $(this).parents().filter('.job').hide(250);
  $.get('headless.php?clicks='+xclicks, function (data) {
    var $newjob = $($.parseHTML(data));
    window.a = $newjob;
    $newjob.find('.jobxbtn').click(xbtn);
    $newjob.appendTo($('#content'));
  });
  xclicks++;
}

$(function() {
  $('.jobxbtn').click(xbtn);
});
