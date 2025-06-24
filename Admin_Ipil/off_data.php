<div class="col-lg-12">
								    	<br>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Birth of Date</h6>
								    	</label>
								    	<input type="date" name="date_birth" id="date_birth" class="form-control" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Age</h6>
								    	</label>
								    	<input type="number" name="age" id="age" class="form-control" placeholder="Age" readonly>
								    </div>
								    <?php include 'birth_age.php'; ?>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Gender</h6>
								    	</label>
								    	<select class="form-control" name="gender" id="gender" required>
								    		<option selected disabled>Choose a Gender</option>
								    		<option value="Male">Male</option>
								    		<option value="Female">Female</option>
								    		<option value="Other">Other</option>
								    	</select>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Civil Status</h6>
								    	</label>
								    	<select class="form-control" name="civil_status" id="civil_status" required>
								    		<option selected disabled>Choose a Civil Status</option>
								    		<option value="Married">Married</option>
								    		<option value="Single">Single</option>
								    		<option value="Divorced">Divorced</option>
								    		<option value="Widowed">Widowed</option>
								    	</select>
								    </div>
								    <div class="col-lg-12">
						        	<center>
						        		<label>
							        		<h4>Emergency & Additional Information</h4>
							        	</label>
						        	</center>
						        </div>
						        <div class="col-lg-3">
						        	<label>
									    		<h6>First Name</h6>
									    	</label>
									    	<input type="text" name="f_name" id="f_name" class="form-control" placeholder="Input the First Name" required>
						        </div>
						        <div class="col-lg-3">
						        	<label>
									    		<h6>Middle Name</h6>
									    	</label>
									    	<input type="text" name="m_name" id="m_name" class="form-control" placeholder="Input the Middle Name" required>
						        </div>
						        <div class="col-lg-3">
						        	<label>
									    		<h6>Last Name</h6>
									    	</label>
									    	<input type="text" name="l_name" id="l_name" class="form-control" placeholder="Input the Last Name" required>
						        </div>
						        <div class="col-lg-3">
						        	<label>
									    		<h6>Suffix Name</h6>
									    	</label>
									    	<select class="form-control" name="s_name" id="s_name">
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
									    		<h6>Relationship to the Officials</h6>
									    	</label>
									    	<select class="form-control" name="r_officials" id="r_officials">
									    		<option selected disabled>Choose a Relationship</option>
									    		<option value="Wife">Wife</option>
									    		<option value="Husband">Husband</option>
									    		<option value="Brother">Brother</option>
									    		<option value="Sister">Sister</option>
									    		<option value="Mother">Mother</option>
									    		<option value="Father">Father</option>
									    		<option value="Relatives">Relatives</option>
									    	</select>
						        </div>
						        <div class="col-lg-3">
								    	<label>
								    		<h6>Contact Number</h6>
								    	</label>
								    	<input type="number" name="r_contact" id="r_contact" class="form-control" placeholder="Input the Contact Number" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Email Address</h6>
								    	</label>
								    	<input type="text" name="r_email" id="r_email" class="form-control" placeholder="Input the Email Address" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Profile Picture</h6>
								    	</label>
								    	<input type="file" name="r_profile" id="r_profile" class="form-control" placeholder="Input the Email Address" required>
								    </div>
								    <div class="col-lg-12">
								    	<br>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Province Name</h6>
								    	</label>
								    	<input type="text" name="province" id="province" class="form-control" placeholder="Input the Province Name" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Municipality Name</h6>
								    	</label>
								    	<input type="text" name="municipality" id="municipality" class="form-control" placeholder="Input the Municipality Name" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Barangay Name</h6>
								    	</label>
								    	<input type="text" name="barangay" id="barangay" class="form-control" placeholder="Input the Barangay Name" required>
								    </div>
								    <div class="col-lg-3">
								    	<label>
								    		<h6>Street Name</h6>
								    	</label>
								    	<input type="text" name="street" id="street" class="form-control" placeholder="Input the Street Name" required>
								    </div>
					        </div>
								    <?php
include 'conn.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!isset($_SESSION['a_id'])) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Unauthorized!',
                text: 'You must be logged in to perform this action.',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.location.href='login.php'; });
        </script>";
        exit;
    }

    $a_id = $_SESSION['a_id']; // Logged-in admin ID
    $date = date("Y-m-d H:i:s"); // Current timestamp

    // Function to sanitize input
    function sanitize($value) {
        return isset($_POST[$value]) ? trim($_POST[$value]) : '';
    }

    // Retrieve form data with sanitization
    $b_list_id = sanitize('b_list_id');
    $b_positions_id = sanitize('b_positions_id');
    $start_term = sanitize('start_term');
    $end_term = sanitize('end_term');
    $first_name = sanitize('first_name');
    $middle_name = sanitize('middle_name');
    $last_name = sanitize('last_name');
    $suffix_name = sanitize('suffix_name');
    $date_birth = sanitize('date_birth'); // Get raw date input
    $date_birth = date('Y-m-d', strtotime($date_birth)); // Convert to YYYY-MM-DD format
    $age = sanitize('age');
    $gender = sanitize('gender');
    $civil_status = sanitize('civil_status');
    $contact = sanitize('contact');
    $email = sanitize('email');
    $official_id = sanitize('official_id');

    $f_name = sanitize('f_name');
    $m_name = sanitize('m_name');
    $l_name = sanitize('l_name');
    $s_name = sanitize('s_name');
    $r_officials = sanitize('r_officials');
    $r_contact = sanitize('r_contact');
    $r_email = sanitize('r_email');
    $province = sanitize('province');
    $municipality = sanitize('municipality');
    $barangay = sanitize('barangay');
    $street = sanitize('street');

    // Debugging: Check if the date is correct before inserting
    echo "Debug: Date of Birth = $date_birth <br>";

    // File Upload Function
    function uploadFile($file, $folder) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $max_size = 2 * 1024 * 1024; // Max 2MB

        if (!empty($_FILES[$file]['name'])) {
            $file_tmp = $_FILES[$file]['tmp_name'];
            $file_ext = strtolower(pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION));
            $file_size = $_FILES[$file]['size'];
            $mime_type = mime_content_type($file_tmp);

            if (!in_array($file_ext, $allowed_types) || !str_starts_with($mime_type, "image/")) {
                return "";
            }

            if ($file_size > $max_size) {
                return "";
            }

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            $new_filename = uniqid() . "." . $file_ext;
            $file_path = "$folder/" . $new_filename;

            if (move_uploaded_file($file_tmp, $file_path)) {
                return $new_filename;
            }
        }
        return "";
    }

    // Upload Profile Image
    $profile = uploadFile('profile', 'officials');
    $r_profile = uploadFile('r_profile', 'officials');

    // Insert data using prepared statement
    $query = "INSERT INTO b_officials 
        (b_list_id, b_positions_id, start_term, end_term, first_name, middle_name, last_name, suffix_name, date_birth, age, gender, civil_status, contact, email, profile, official_id, a_id, f_name, m_name, l_name, s_name, r_officials, r_contact, r_email, r_profile, province, municipality, barangay, street,  date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iissssssisssssssisssssssssssss", $b_list_id, $b_positions_id, $start_term, $end_term, 
        $first_name, $middle_name, $last_name, $suffix_name, $date_birth, $age, $gender, 
        $civil_status, $contact, $email, $profile, $official_id, $a_id, $f_name, $m_name, $l_name, $s_name, $r_officials, $r_contact, $r_email, $r_profile, $province, $municipality, $barangay, $street, $date);

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>";
    if (mysqli_stmt_execute($stmt)) {
        echo "Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Barangay official added successfully!',
            confirmButtonColor: '#28a745'
        }).then(() => { window.location.href='b_o.php'; });";
    } else {
        echo "Swal.fire({
            icon: 'error',
            title: 'Database Error!',
            text: 'Could not save data! " . mysqli_error($conn) . "',
            confirmButtonColor: '#dc3545'
        }).then(() => { window.history.back(); });";
    }
    echo "</script>";

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>