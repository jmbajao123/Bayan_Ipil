<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $("#barangay_name").on("input", function() {
        let barangayName = $(this).val().trim().toLowerCase().replace(/\s+/g, '');
        if (barangayName.length > 0) {
            $("#email").val(barangayName + "@email.com");
        } else {
            $("#email").val(""); // Clear email input if barangay_name is empty
        }
    });
});
</script>