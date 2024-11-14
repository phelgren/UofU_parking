<?php
  include('header.php');
  $page_roles = array('student','faculty','admin');
  require_once 'authx\checksession.php';
?>

<div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">View driver information  - Driver ID: 1234567 </div>
                        <div class="card-body">


                                    <label for="first-name" class="col-md-4 control-label">First Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="first-name" class="form-control" name="first-name" disabled>
                                    </div>

                                    <label for="last-name" class="col-md-4 control-label">Last Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="last-name" class="form-control" name="last-name" disabled>
                                    </div>

                                    <label for="email-address" class="col-md-4 control-label">Email Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email-address" class="form-control" name="email-address" disabled>
                                    </div>

                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password" disabled>
                                    </div>
                                    <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="address" class="form-control" name="address" disabled>
                                    </div>
                                    <label for="sel-type" class="col-md-4 col-form-label text-md-right">Driver type</label>
                                    <div class="col-md-6">
                                        <select aria-label="Select permit type" id="sel-type"  name="sel-type" disabled>
                                            <option value="student">Student</option>
                                            <option value="faculty">Faculty</option>
                                            <option value="guest">Guest</option>
                                        </select>
                                    </div>



                                <div class="col-md-3">
                                    <a href="edit-driver.php" class="btn btn-info" role="button">Delete this driver</a>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>      

                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php
  include('footer.php');
?>