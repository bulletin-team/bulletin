var xclicks = 0, a;
function jxbtn (e) {
  e.preventDefault();
  $(this).parents().filter('.job').hide(250);
  $.get('headless.php?clicks='+xclicks, function (data) {
    var $newjob = $($.parseHTML(data));
    window.a = $newjob;
    $newjob.find('.jobxbtn').click(jxbtn);
    $newjob.appendTo($('#content'));
  });
  xclicks++;
}
function axbtn (e) {
  e.preventDefault();
  $(this).parents().filter('.job').hide(250);
}

$(function() {
  $('.jobxbtn').click(jxbtn);
  $('.appxbtn').click(axbtn);
});
