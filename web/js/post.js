+function ($) {



  $("a.post").click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    var href = this.href;
    var parts = href.split('?');
    var url = parts[0];
    var params = parts[1].split('&');
    var pp, inputs = '';
    for(var i = 0, n = params.length; i < n; i++) {
      pp = params[i].split('=');
      inputs += '<input type="hidden" name="' + pp[0] + '" value="' + pp[1] + '" />';
    }
    $("body").append('<form action="'+url+'" method="post" id="poster">'+inputs+'</form>');
    $("#poster").submit();
  });


}(jQuery);
