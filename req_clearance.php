<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-md">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Request Certificate</h5>
				      </div>
				      <div class="modal-body">
				       <form method="post" action="c_c.php" enctype="multipart/form-data">
				       	 <div class="col-lg-12">
					        <div class="row">
					        	<div class="col-lg-12">
	                                <label><h6>Purpose</h6></label>
	                                <input type="text" name="purpose" class="form-control" placeholder="Enter First Name" required>
	                            </div>
	                            <div class="col-lg-12">
	                            	<br>
	                            </div>
	                            <div class="col-lg-12">
	                                <label><h6>Certificate</h6></label>
	                                <select name="cert_id" class="form-control" required>
									    <option selected disabled>Choose a Certificate</option>
									    <?php
									    include 'conn.php'; // Database connection

									    if (isset($_SESSION['b_list_id'])) {
									        $b_list_id = $_SESSION['b_list_id'];

									        // Fetch certificates based on the current user's b_list_id
									        $query = "SELECT cert_id, c_name FROM certificate WHERE b_list_id = '$b_list_id'";
									        $result = mysqli_query($conn, $query);

									        if (mysqli_num_rows($result) > 0) {
									            while ($row = mysqli_fetch_assoc($result)) {
									                echo "<option value='{$row['cert_id']}'>{$row['c_name']}</option>";
									            }
									        } else {
									            echo "<option disabled>No certificates available</option>";
									        }
									    } else {
									        echo "<option disabled>Session expired. Please log in again.</option>";
									    }

									    mysqli_close($conn);
									    ?>
									</select>

	                            </div>
					        </div>
					    </div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-outline-primary">Request Now</button>
				      </div>
				      </form>
				    </div>
				  </div>
				</div>