



function funfetch() {
var id = document.getElementById("wevname").value;
console.log("con7");

$.ajax({
url: 'weaver_return_fe.php',
method: 'POST',
data: { id: id },
dataType: 'json',
success: function (work) {
  var myData = work.wev_nam;
  console.log(myData);
  document.getElementById("loom").value = work.wev_nam;
  document.getElementById("silk").value = work.silk_nam;
  document.getElementById("color").value = work.slk_colnam;
  document.getElementById("silk_wght").value = work.silk_wght;
  document.getElementById("silk_qty").value = work.silk_qty;
  document.getElementById("jari_wght").value = work.jari_wght;
  document.getElementById("jari_qty").value = work.jari_qty;
  document.getElementById("particulars").value = work.particulars;
  //document.getElementById("zari").value = work.jari_id;
}
});
}


var to = document.getElementById('to');
var hiddenColor = document.getElementById('selectedloc');
to.addEventListener('change', function() {
  var selectedloc = to.options[to.selectedIndex].text;
  console.log(selectedloc);
  document.getElementById('selectedloc').value=selectedloc;
});

