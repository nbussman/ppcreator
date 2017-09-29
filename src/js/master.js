$(document).delegate('.tabAllowed', 'keydown', function(e) {
  var keyCode = e.keyCode || e.which;

  if (keyCode == 9) {
    e.preventDefault();
    var start = $(this).get(0).selectionStart;
    var end = $(this).get(0).selectionEnd;

    // set textarea value to: text before caret + tab + text after caret
    $(this).val($(this).val().substring(0, start)
                + "\t"
                + $(this).val().substring(end));

    // put caret at right position again
    $(this).get(0).selectionStart =
    $(this).get(0).selectionEnd = start + 1;
  }
});
$( window ).on( "load", function() {
  $( ".copyable" ).dblclick(function() {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val( $(this).val() ).select();
    var status = document.execCommand("copy");

    $(this).parent().append("<label>copied to your clipboard.</label>")

    $temp.remove();
  });
});
// var existsTextarea = $("copyable");
// existsTextarea.value = text;
// existsTextarea.select();
//
// try {
//     var status = document.execCommand('copy');
//     if(!status){
//         console.error("Cannot copy text");
//     }else{
//         console.log("The text is now on the clipboard");
//     }
// } catch (err) {
//     console.log('Unable to copy.');
// }
