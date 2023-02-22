<div class="modal" id="editAdminPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Admin</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="text-danger print-error-msg" style="display:none">

                <ul></ul>
        
            </div>
            <form action="#" method="POST" id="adminFormDataEdit" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="_method" value="put" />
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" placeholder="Enter Name" name="name" id="edit_name">                
                            </div>
                        </div>         
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>National ID</label>
                                <input class="form-control cnic_mask" type="text" placeholder="Enter National ID" name="national_id" id="edit_national_id">                
                            </div>
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control mobile_mask" type="text" placeholder="Enter Phone" name="phone" id="edit_phone">                
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mobile</label>
                                <input class="form-control mobile_mask" type="text" placeholder="Enter Mobile" name="mobile" id="edit_mobile">                
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" type="text" placeholder="Enter Address" name="address" id="edit_address">                
                            </div>
                        </div>    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="text" placeholder="Enter Password" name="password">                
                            </div>
                        </div>   
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input class="form-control" type="date" placeholder="Enter Expiry date" name="expiry_date" id="edit_expiry_date">                
                            </div>
                        </div>  
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo</label>
                                <input class="form-control" type="file" accept="image/*" name="logo">                
                            </div>
                        </div>      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateAdmin" class="btn btn-outline-success">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>