$(function () {
  $('#chpic').change(function() {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#propic img').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    }
  });
  $('.private #propic').click(function () {
    $('#chpic').click();
  });
});
