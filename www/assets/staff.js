$(function () {
  $('.secret form').submit(function (e) {
    e.preventDefault();
    if(confirm('Are you sure?')) {
      var el = $(this);
      $.ajax({
        url: el.attr('action'),
        data: el.serialize(),
        type: 'post',
        success: function () {
          el.closest('.secret').fadeOut(1000);
        },
        error: function (data) {
          alert("Error deleting: " + data);
        }
      })
    }
  });
});
