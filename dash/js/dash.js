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
  if (window.confirm('Permanently remove this application?')) {
    $(this).parents().filter('.job').hide(250);
    $.get('headless.php?del='+$(this).attr('data-rid'), function (data) {
      if (data != 'OK') window.alert('The application could not be permanently deleted. It has been removed from view for your convenience.');
    });
  }
}
function acbtn (e) {
  e.preventDefault();
  if (window.confirm('Hire this candidate the job?')) {
    $(this).parents().filter('.job').hide(250);
    $.get('headless.php?hire='+$(this).attr('data-rid'), function (data) {
      if (data == 'OK') {
        window.location.href = '/dash/rate.php';
      } else {
        window.alert('We\'ve experienced an error trying to approve this application. Please try again another time.');
        window.location.href = '/dash/';
      }
    });
  }
}
function trashbtn (e) {
  e.preventDefault();
  if (window.confirm('Permanently delete this ad?')) {
    $.get('headless.php?rmad='+$(this).attr('data-adid'), function (data) {
      if (data == 'OK') window.location.href = '/dash/';
      else window.alert('An error was encountered while attempting to delete this ad.');
    });
  }
}
function serveratings ($spaces) {
  $.each($spaces, function (idx, me) {
    var $me = $(me);
    var rating = parseFloat($me.attr('data-rating'));
    if (!rating && rating != 0) {
      $me.html('<img class="norating" src="img/unrated.png" alt="Not Yet Rated" />');
    } else {
      var html = '';
      for (var i = 1; i <= rating; i++) html += '<img class="star" src="img/star_given.png" alt="Full Star" />';
      if (rating-Math.floor(rating) >= 0.5) html += '<img class="star" src="img/star_half.png" alt="Half Star" />'
      i += Math.round(rating-Math.floor(rating));
      for (; i <= 5; i++) html += '<img class="star" src="img/star_empty.png" alt="No Star" />';
      $me.html(html);
    }
  });
}
function ratewidget (idx, me) {
  var $me = $(me);
  var rating = parseFloat($me.attr('data-rating'));
  if (!rating) rating = 0;
  var html = '<div><textarea class="typereview" maxlength="250" placeholder="Reflect on your experience (250 characters)..."></textarea></div><div class="stars">';
  for (var i = 1; i <= rating; i++) html += '<img class="ratebtn" src="img/star_given.png" alt="Full Star" />';
  if (rating-Math.floor(rating) >= 0.5) html += '<img class="ratebtn" src="img/star_half.png" alt="Half Star" />'
  i += Math.round(rating-Math.floor(rating));
  for (; i <= 5; i++) html += '<img class="ratebtn" src="img/star_empty.png" alt="No Star" />';
  html += '</html>';
  $me.html(html);
  $.each($me.find('.ratebtn'), function (idx, obj) {
    $(obj).click(function (e) {
      e.preventDefault();
      console.log('Clicked '+(idx+1));
      $.get('headless.php?rate='+$me.attr('data-uid')+'&jid='+$me.attr('data-jid')+'&val='+(idx+1)+'&txt='+$me.find('.typereview').val(), function (data) {
        if (data == 'OK') window.location.reload();
        else window.alert('The server encountered an error submitting your rating. We\'re sorry for the inconvenience.');
      });
    });
  });
}

$(function() {
  $('.jobxbtn').click(jxbtn);
  $('.appxbtn').click(axbtn);
  $('.appcbtn').click(acbtn);
  $('.adtrash').click(trashbtn);
  serveratings($('.ratingdata'));
  $.each($('.rate-widget'), ratewidget);
});
