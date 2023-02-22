<div class="modal" id="addDealerPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Dealer</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="text-danger print-error-msg" style="display:none">

                <ul></ul>
        
            </div>
            <form action="#" method="POST" id="dealerFormDataAdd">
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
                                <label>username</label>
                                <input class="form-control" type="text" placeholder="Enter Usernme" name="username">                
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
                                <label>Password</label>
                                <input class="form-control" type="text" placeholder="Enter Password" name="password">                
                            </div>
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Area</label>   
                                <select class="form-control" name="area_id">
                                    <option value="">Select Area</option>
                                    @foreach ($areas as $area )
                                    <option value='{{$area->id}}'>{{$area->area_name}}</option>
                                    @endforeach
                                </select>               
                            </div>
                        </div>        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addDealer" class="btn btn-outline-success">Add</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>