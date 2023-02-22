<div class="modal" id="addUserPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="text-danger print-error-msg" style="display:none">

                <ul></ul>
        
            </div>
            <form action="#" method="POST" id="userFormDataAdd">
                @csrf
                <div class="modal-body">
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" placeholder="Enter Name" name="name">                
                            </div>
                        </div>              
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" placeholder="Enter Email" name="email">                
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>National ID</label>
                                <input class="form-control cnic_mask" type="text" placeholder="Enter National ID" name="national_id">                
                            </div>
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control mobile_mask" type="text" placeholder="Enter Phone" name="phone">                
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mobile</label>
                                <input class="form-control mobile_mask" type="text" placeholder="Enter Mobile" name="mobile">                
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" type="text" placeholder="Enter Address" name="address">                
                            </div>
                        </div>    
                       

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Package Name</label>
                                <input class="form-control" type="text" placeholder="Enter Package Name" name="package_name">                
                            </div>
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Package Price</label>
                                <input class="form-control" type="text" placeholder="Enter Package Price" name="package_price">                
                            </div>
                        </div>   

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addUser" class="btn btn-outline-success">Add</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>