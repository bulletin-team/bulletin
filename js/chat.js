var bullechat = {
  nickfmt: function (nick) {
    return nick;
  },
  gui: {
    $windows: {},
    updown: function ($elem) {
      if ($elem.hasClass('chexp')) {
        $elem.addClass('chshr');
        $elem.removeClass('chexp');
      } else {
        $elem.removeClass('chshr');
        $elem.addClass('chexp');
      }
    },
    create: function (user, title) {
      if (!title) title = user;
      var $child = $('<div/>', {'class': 'chwin chshr'}).data('user', user);
      var $chhead = $('<div class="chhead"><span class="chtitle">'+title+'</span></div>');
      $child.append($chhead);
      $chhead.append($('<div/>', {'class': 'chshrbtn'}).click(function (e) {
        bullechat.gui.updown($child);
      }));
      $chhead.append($('<div/>', {'class': 'chxbtn'}).click(function (e) {
        bullechat.gui.kill($child);
      }));
      var $chbody = $('<ul/>', {'class': 'chlist'});
      $child.append($chbody);
      $child.data('body', $chbody);
      $child.append($('<input>', {'type': 'text', 'class': 'chinput', 'placeholder': 'press <enter> to send'}).keypress(function (e) {
        if (e.which == 13) {
          var $item = bullechat.gui.addline($child, $(this).val(), 'You', false);
          if (!bullechat.socket.sendto(user, $(this).val())) $item.addClass('chfailed').click(function (e) {
              $(this).hide(750);
            });
          $(this).val('');
        }
      }));
      

      $child.draggable({
        create: function (e, ui) {
          $(this).css({
            position: 'fixed',
            bottom: 0,
            right: 0,
          });
        }
      });
      bullechat.gui.$windows[user] = $child;
      $('body').append($child);
      bullechat.gui.updown($child);
    },
    addline: function ($elem, msg, nick, recvd) {
      var $item;
      if (nick) {
        $item = $('<li/>', {'class': (recvd ? 'recvd' : 'sent')}).text(msg);
      } else {
        $item = $('<li/>', {'class': 'chspecial'}).text(msg);
      }
      $elem.data('body').append($item);
      return $item;
    },
    end: function () {
      $.each(bullechat.gui.$windows, function (k, v) {
        bullechat.gui.kill(v);
      });
    },
    kill: function (w) {
      w.hide(250);
      bullechat.gui.$windows[w.data('user')] = null;
    },
  },
  socket: {
    sockfd: null,
    server: 'chat.bulletinusa.com',
    port: 2442,
    send: function (data) {
      if (!bullechat.socket.sockfd) return false;
      bullechat.socket.sockfd.send(JSON.stringify(data));
      return true; // implement testing to check if it went through
    },
    sendto: function (user, msg) {
      return bullechat.socket.send({'user': user, 'msg': msg});
    },
    opened: function () {
      bullechat.socket.send(auth);
    },
    closed: function () {
      bullechat.gui.end();
    },
    error: function (e) {
      console.error(e);
    },
    message: function (e) {
      var data = JSON.parse(e.data);
      if (!data || !data['uname']) return;
      if (!bullechat.gui.$windows[data['uname']]) bullechat.gui.create(data['uname'], data['nick']);
      bullechat.gui.addline(bullechat.gui.$windows[data['uname']],
                            data['msg'], data['nick'], true);
    },
    start: function () {
      if (window.WebSocket) {
        bullechat.socket.sockfd = new WebSocket('wss://'+bullechat.socket.server+':'+bullechat.socket.port+'/bullechat');
        bullechat.socket.sockfd.onopen = bullechat.socket.opened;
        bullechat.socket.sockfd.onclose = bullechat.socket.closed;
        bullechat.socket.sockfd.onerror = bullechat.socket.error;
        bullechat.socket.sockfd.onmessage = bullechat.socket.message;
      }
    },
  },
  start: function () {
    bullechat.socket.start();
  }
};

$(function () {
  if (auth.id) {
    bullechat.start();
  }
});
