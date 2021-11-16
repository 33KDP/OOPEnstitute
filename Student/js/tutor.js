$(document).ready(function(){
    $(".subject" ).autocomplete({
        source: 'subjectList.php',
        select: function (event, ui) {
            // Set autocomplete element to display the label
            this.value = ui.item.label;

            // Store value in hidden field
            $('#subId').val(ui.item.value);

            // Prevent default behaviour
            return false;
        }
    });
});

$("#profileImage").click(function(e) {
    $("#imageUpload").click();
  });
  
var loadFile = function(event) {
	var image = document.getElementById('profileImage');
	image.src = URL.createObjectURL(event.target.files[0]);
};