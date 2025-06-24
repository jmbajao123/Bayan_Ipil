<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-xl">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Add Barangay Officials</h5>
				      </div>
				      <div class="modal-body">
				       <form method="post" action="b_o.php" enctype="multipart/form-data">
				       	 <div class="col-lg-12">
					        <div class="row">
					        	<?php
										include 'conn.php';

										// Fetch barangay names where status is 'Active'
										$query = "SELECT b_list_id, barangay_name FROM b_list WHERE status = 'Active'";
										$result = mysqli_query($conn, $query);

										if ($result) :
										?>
										    <div class="col-lg-3">
										        <label>
										            <h6>Barangay Name</h6>
										        </label>
										        <select name="b_list_id" class="form-control" required>
										            <option value="">Choose a Barangay</option>
										            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
										                <option value="<?php echo htmlspecialchars($row['b_list_id']); ?>">
										                    <?php echo htmlspecialchars($row['barangay_name']); ?>
										                </option>
										            <?php endwhile; ?>
										        </select>
										    </div>
										<?php
										    mysqli_free_result($result); // Free result set
										endif;

										mysqli_close($conn);
										?>

										<?php
											include 'conn.php';

											// Fetch barangay names where status is 'Active'
											$query = "SELECT b_positions_id, position_name FROM b_positions WHERE status = 'Available'";
											$result = mysqli_query($conn, $query);
											?>

											<div class="col-lg-3">
											    <label>
											        <h6>Barangay Position</h6>
											    </label>
											    <select name="b_positions_id" class="form-control" required>
											        <option value="">Choose a Barangay</option>
											        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
											            <option value="<?php echo htmlspecialchars($row['b_positions_id']); ?>">
											                <?php echo htmlspecialchars($row['position_name']); ?>
											            </option>
											        <?php endwhile; ?>
											    </select>
											</div>

											<?php
											mysqli_close($conn);
										?>
										<div class="col-lg-3">
										    <label>
										        <h6>Start Term</h6>
										    </label>
										    <input type="date" name="start_term" id="start_term" class="form-control" required>
										</div>
										<div class="col-lg-3">
										    <label>
										        <h6>End Term</h6>
										    </label>
										    <input type="date" name="end_term" id="end_term" class="form-control" readonly>
										</div>
										<?php include 'term_script.php'; ?>
										<div class="col-lg-12">
									        <br>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>First Name</h6>
								    	</label>
								    	<input type="text" name="first_name" id="first_name" placeholder="Input the First Name" class="form-control" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Middle Name</h6>
								    	</label>
								    	<input type="text" name="middle_name" id="middle_name" placeholder="Input the Middle Name" class="form-control" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Last Name</h6>
								    	</label>
								    	<input type="text" name="last_name" id="last_name" placeholder="Input the Last Name" class="form-control" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Suffix Name</h6>
								    	</label>
								    	<select class="form-control" name="suffix_name" id="suffix_name">
								    		<option selected disabled>Choose a Suffix Name</option>
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
								    		<h6>Contact Number</h6>
								    	</label>
								    	<input type="number" name="contact" id="contact" class="form-control" placeholder="Input the Contact Number" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Email Address</h6>
								    	</label>
								    	<input type="text" name="email" id="email" class="form-control" placeholder="Input the Email Address" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Password</h6>
								    	</label>
								    	<input type="password" name="password" id="password" class="form-control" placeholder="Input the Password" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Confirm Password</h6>
								    	</label>
								    	<input type="password" name="con_pass" id="con_pass" class="form-control" placeholder="Input the Confirm Password" required>
								    </div>
								    <div class="col-lg-12">
								    	<br>
								    </div>
								    <div class="col-lg-3">
							        <label><h6>Profile Picture</h6></label>
							        <input type="file" name="profile" id="profile" class="form-control" required>
							    	</div>
								    <div class="col-lg-3">
								      <label><h6>Official ID</h6></label>
								      <input type="number" name="official_id" id="official_id" class="form-control" placeholder="Official ID" readonly>
								    </div>
								    <?php include 'off_id.php'; ?>
								    <div class="col-lg-12">
								    </div>
								    <div class="col-lg-12">
						        	<br>
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