 <script>
        $(document).ready(function(){
            $("#barangay_name").on("input", function(){
                let barangayName = $(this).val().trim();
                
                if(barangayName !== "") {
                    let code = generateRandomCode(); // Generate a code
                    $("#b_code").val(code); // Immediately display the code

                    // Check if the generated code is unique
                    checkUniqueCode(code);
                } else {
                    $("#b_code").val(""); // Clear code if barangay name is empty
                }
            });

            function generateRandomCode() {
                return Math.floor(100000 + Math.random() * 900000); // Generate a 6-digit number
            }

            function checkUniqueCode(code) {
                $.ajax({
                    url: "check_code.php", // Backend file to check for duplicate codes
                    type: "POST",
                    data: { b_code: code },
                    success: function(response) {
                        if (response === "exists") {
                            let newCode = generateRandomCode(); // Generate a new code if duplicate exists
                            $("#b_code").val(newCode);
                            checkUniqueCode(newCode); // Re-check uniqueness
                        }
                    }
                });
            }
        });
    </script>