<script>
						document.addEventListener("DOMContentLoaded", function() {
						    const psListDropdown = document.getElementById("ps_list_id");
						    const residenceDropdown = document.getElementById("r_id");
						    const residenceData = document.getElementById("residence_data");
						    const householdNumberInput = document.getElementById("h_num");

						    // Filter residence options based on selected Purok/Street
						    psListDropdown.addEventListener("change", function() {
						        const selectedPsListId = this.value;
						        residenceDropdown.innerHTML = '<option selected disabled>Choose a Residence</option>';

						        Array.from(residenceData.options).forEach(option => {
						            if (option.getAttribute("data-ps_list_id") === selectedPsListId) {
						                residenceDropdown.appendChild(option.cloneNode(true));
						            }
						        });

						        // Reset household number when changing Purok/Street
						        householdNumberInput.value = "";
						    });

						    // Generate a unique 6-digit household number when a residence is selected
						    residenceDropdown.addEventListener("change", function() {
						        householdNumberInput.value = generateUniqueHouseholdNumber();
						    });

						    function generateUniqueHouseholdNumber() {
						        let uniqueNumber;
						        let usedNumbers = new Set(); // To ensure uniqueness in this session

						        do {
						            uniqueNumber = Math.floor(100000 + Math.random() * 900000); // Generate 6-digit number
						        } while (usedNumbers.has(uniqueNumber));

						        usedNumbers.add(uniqueNumber);
						        return uniqueNumber;
						    }
						});
						</script>