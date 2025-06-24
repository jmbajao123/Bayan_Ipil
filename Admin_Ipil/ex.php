<div class="col-lg-4">
                                <label><h6>Transcript of Records</h6></label>
                                <input type="file" name="tor" id="tor" class="form-control" placeholder="Input the Transcript of Records (TOR)" required accept=".pdf">
                                <small class="text-danger" id="torFileError" style="display: none;">Only PDF files are allowed.</small>
                            </div>
                            <?php include 'tor_only.php'; ?>
                            <div class="col-lg-4">
                                <label><h6>Certificate of Graduation</h6></label>
                                <input type="file" name="cog" id="cog" class="form-control" placeholder="Input the Certificate of Graduation" required accept=".pdf">
                                <small class="text-danger" id="cogFileError" style="display: none;">Only PDF files are allowed.</small>
                            </div>
                            <?php include 'cog_only.php'; ?>