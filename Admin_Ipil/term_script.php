<!-- JavaScript to Auto-Calculate End Term -->
						<script>
						    document.getElementById("start_term").addEventListener("change", function () {
						        let startDate = new Date(this.value);
						        if (!isNaN(startDate.getTime())) {
						            // Add 5 years to the selected start date
						            let endDate = new Date(startDate);
						            endDate.setFullYear(startDate.getFullYear() + 5);

						            // Format the date as YYYY-MM-DD
						            let formattedEndDate = endDate.toISOString().split("T")[0];

						            // Set the end term input value
						            document.getElementById("end_term").value = formattedEndDate;
						        }
						    });
						</script>