<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get profile input and residence_id input fields
        const profileInput = document.getElementById("profile");
        const residenceIdInput = document.getElementById("residence_id");

        profileInput.addEventListener("change", function () {
            // Generate a unique 6-digit ID
            let uniqueId;
            do {
                uniqueId = Math.floor(100000 + Math.random() * 900000); // 6-digit random number
            } while (isDuplicateId(uniqueId));

            // Set the generated ID in the residence ID input field
            residenceIdInput.value = uniqueId;

            // Store the generated ID to prevent duplicates
            storeResidenceId(uniqueId);
        });

        // Function to check if an ID already exists in localStorage
        function isDuplicateId(id) {
            let storedIds = JSON.parse(localStorage.getItem("residence_ids")) || [];
            return storedIds.includes(id);
        }

        // Function to store a new unique ID in localStorage
        function storeResidenceId(id) {
            let storedIds = JSON.parse(localStorage.getItem("residence_ids")) || [];
            storedIds.push(id);
            localStorage.setItem("residence_ids", JSON.stringify(storedIds));
        }
    });
</script>
