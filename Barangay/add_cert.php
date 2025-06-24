<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Certificate </h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
              </div>
              <div class="modal-body">
               <form method="post" action="cert.php" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>
                                    <h6>Certificate Name</h6>
                                </label>
                                <input type="text" name="c_name" id="c_name" class="form-control" placeholder="Input the Certificate Name" required>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <h6>Status</h6>
                                </label>
                                <select class="form-control" name="status" id="status" required>
                                    <option selected disabled>Choose a Status</option>
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
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