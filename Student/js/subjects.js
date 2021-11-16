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
