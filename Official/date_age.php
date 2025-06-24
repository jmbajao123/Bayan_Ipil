<script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    let dateInput = document.getElementById("date_birth");
                                    let ageInput = document.getElementById("age");

                                    // Restrict future dates
                                    let today = new Date().toISOString().split("T")[0];
                                    dateInput.setAttribute("max", today);

                                    // Calculate age on date selection
                                    dateInput.addEventListener("change", function () {
                                        let birthDate = new Date(this.value);
                                        let todayDate = new Date();
                                        
                                        let age = todayDate.getFullYear() - birthDate.getFullYear();
                                        let monthDiff = todayDate.getMonth() - birthDate.getMonth();
                                        let dayDiff = todayDate.getDate() - birthDate.getDate();

                                        // Adjust age if the birthday hasn't occurred yet this year
                                        if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                                            age--;
                                        }

                                        ageInput.value = age > 0 ? age : 0; // Ensure age doesn't go negative
                                    });
                                });
                            </script>