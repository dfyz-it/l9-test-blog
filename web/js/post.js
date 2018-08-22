+function ($) {
$("input.post").click(function() {
    var chkArray = [];

    $(".chk:checked").each(function() {
      chkArray.push($(this).val());
    });

  var dataString = "id="+ chkArray;
    if(dataString.length > 0){
      $.ajax({
        type: "POST",
        url: "/admin/masscheck",
        dataType:'json',
        data: dataString,
        cache: false,
      });
      location.reload();

    }else{
      alert("Please at least check one of the checkbox");
    }
  });
}(jQuery);
