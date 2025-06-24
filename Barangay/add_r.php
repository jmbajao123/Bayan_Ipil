<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-xl">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Add Residence</h5>
				      </div>
				      <div class="modal-body">
				       <form method="post" action="resident.php" enctype="multipart/form-data">
				       	 <div class="col-lg-12">
					        <div class="row">
					        	<div class="col-lg-3">
	                                <label><h6>First Name</h6></label>
	                                <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" required>
	                            </div>
	                            <div class="col-lg-3">
	                                <label><h6>Middle Name</h6></label>
	                                <input type="text" name="middle_name" class="form-control" placeholder="Enter Middle Name" required>
	                            </div>
	                            <div class="col-lg-3">
	                                <label><h6>Last Name</h6></label>
	                                <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" required>
	                            </div>
	                            <div class="col-lg-3">
	                                <label><h6>Suffix Name</h6></label>
	                                <select class="form-control" name="suffix_name" required>
	                                    <option selected disabled>Choose a Suffix</option>
	                                    <option value="Sr.">Sr.</option>
	                                    <option value="Jr.">Jr.</option>
	                                    <option value="II">II</option>
	                                    <option value="III">III</option>
	                                    <option value="IV">IV</option>
	                                    <option value="V">V</option>
	                                    <option value="None">None</option>
	                                </select>
	                            </div>
	                            <div class="col-lg-12">
	                            	<br>
	                            </div>
	                            <div class="col-lg-3">
	                                <label>
	                                    <h6>Date of Birth</h6>
	                                </label>
	                                <input type="date" name="date_birth" id="date_birth" class="form-control" required>
	                            </div>
	                            <div class="col-lg-3">
	                                <label>
	                                    <h6>Age</h6>
	                                </label>
	                                <input type="number" name="age" id="age" class="form-control" readonly>
	                            </div>
	                            <?php include 'date_age.php'; ?>
	                            <div class="col-lg-3">
	                                <label><h6>Gender</h6></label>
	                                <select class="form-control" name="gender" id="gender" required>
	                                    <option selected disabled>Choose a Gender</option>
	                                    <option value="Male">Male</option>
	                                    <option value="Female">Female</option>
	                                    <option value="Others">Others</option>
	                                </select>
	                            </div>
	                            <div class="col-lg-3">
	                                <label><h6>Civil Status</h6></label>
	                                <select class="form-control" name="civil_status" id="civil_status" required>
	                                    <option selected disabled>Choose a Civil Status</option>
	                                    <option value="Married">Married</option>
	                                    <option value="Single">Single</option>
	                                    <option value="Divorce">Divorce</option>
	                                    <option value="Widowed">Widowed</option>
	                                </select>
	                            </div>
	                            <div class="col-lg-12">
	                            	<br>
	                            </div>
	                            <div class="col-lg-3">
	                                <label>
	                                    <h6>Contact Number</h6>
	                                </label>
	                                <input type="number" name="contact" id="contact" class="form-control" placeholder="Input the Contact Number" required>
	                            </div>
	                            <div class="col-lg-3">
							        <label><h6>Profile Picture</h6></label>
							        <input type="file" name="profile" id="profile" class="form-control" required>
							    </div>
								<div class="col-lg-3">
								    <label><h6>Residence ID</h6></label>
								    <input type="number" name="residence_id" id="residence_id" class="form-control" placeholder="Residence ID" readonly>
								</div>
								<?php include 'residence_id.php'; ?>
								<div class="col-lg-3">
									<label>
										<h6>Purok/Street</h6>
									</label>
									<select class="form-control" name="ps_list_id" required>
									    <option value="">Select an Option</option>
									    <?php
									    include 'conn.php';

									    // Fetch active data from ps_list table
									    $sql = "SELECT ps_list_id, ps_name FROM ps_list WHERE status = 'Active'";
									    $result = mysqli_query($conn, $sql);

									    if (mysqli_num_rows($result) > 0) {
									        while ($row = mysqli_fetch_assoc($result)) {
									            echo '<option value="' . htmlspecialchars($row['ps_list_id']) . '">' . htmlspecialchars($row['ps_name']) . '</option>';
									        }
									    }

									    // Close connection
									    mysqli_close($conn);
									    ?>
									</select>
								</div>
								<div class="col-lg-12">
									<br>
								</div>
								<div class="col-lg-3">
									<label>
										<h6>Nationality</h6>
									</label>
									<input type="text" name="nationality" id="nationality" class="form-control" placeholder="Input the Nationality" required>
								</div>
								<div class="col-lg-3">
									<label>
										<h6>Birthplace</h6>
									</label>
									<input type="text" name="birthplace" id="birthplace" class="form-control" placeholder="Input the Birthplace" required>
								</div>
								<div class="col-lg-3">
									<label>
										<h6>Email</h6>
									</label>
									<input type="text" name="email" id="email" class="form-control" placeholder="Input the Email" required>
								</div>
								<div class="col-lg-3">
									<label>
										<h6>Password</h6>
									</label>
									<input type="password" name="password" id="password" class="form-control" placeholder="Input the Password" required>
								</div>
								<div class="col-lg-12">
									<br>
								</div>
								<div class="col-lg-3">
									<label>
										<h6>Confirm Password</h6>
									</label>
									<input type="password" name="con_pass" id="con_pass" class="form-control" placeholder="Input the Confirm Password" required>
								</div>
								<div class="col-lg-3">
									<label>
										<h6>Status</h6>
									</label>
									<select class="form-control" name="status" id="status" required>
										<option selected disabled>Choose a Status</option>
										<option value="Active Residence">Active Residence</option>
										<option value="Inactive Residence">Inactive Residence</option>
									</select>
								</div>
					        </div>
					    </div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-outline-primary">Add now</button>
				      </div>
				      </form>
				    </div>
				  </div>
				</div>