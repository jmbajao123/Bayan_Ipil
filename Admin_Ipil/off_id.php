<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get profile input and official_id input fields
        const profileInput = document.getElementById("profile");
        const officialIdInput = document.getElementById("official_id");

        profileInput.addEventListener("change", function () {
            // Generate a unique 6-digit ID
            let officialId;
            do {
                officialId = Math.floor(100000 + Math.random() * 900000); // 6-digit random number
            } while (checkDuplicateId(officialId));

            // Set the generated ID in the input field
            officialIdInput.value = officialId;

            // Store the generated ID to prevent duplicates
            storeOfficialId(officialId);
        });

        // Function to check if an ID already exists
        function checkDuplicateId(id) {
            let storedIds = JSON.parse(localStorage.getItem("official_ids")) || [];
            return storedIds.includes(id);
        }

        // Function to store a new unique ID
        function storeOfficialId(id) {
            let storedIds = JSON.parse(localStorage.getItem("official_ids")) || [];
            storedIds.push(id);
            localStorage.setItem("official_ids", JSON.stringify(storedIds));
        }
    });
</script>