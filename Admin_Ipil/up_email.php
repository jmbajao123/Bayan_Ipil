<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $("input[name='barangay_name']").on("input", function() {
            let barangayName = $(this).val().toLowerCase().replace(/\s+/g, ''); // Remove spaces
            let email = barangayName ? barangayName + "@email.com" : ""; // Generate email
            $("input[name='email']").val(email);
        });
    });
</script>