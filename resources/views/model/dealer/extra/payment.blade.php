<div class="modal" id="paymentUserPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Payment</h5>
                <h5 id="package_name"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="text-danger print-error-msg" style="display:none">

                <ul></ul>
        
            </div>
            <form action="#" method="POST" id="userFormDataPayment">
                @csrf
                <input type="hidden" name="id" id="payment_id">
                <div class="modal-body">
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>OTC</label>
                                <input class="form-control" type="text" onkeypress="return isNumber(event)"
                                 placeholder="Enter OTC" name="otc">                
                            </div>
                        </div>              
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Package Price</label>
                                <input class="form-control" type="text" onkeypress="return isNumber(event)"
                                 placeholder="Enter Package Price" name="package_price">                
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Advance Payment</label>
                                <input class="form-control" type="text" onkeypress="return isNumber(event)"
                                 placeholder="Enter Advance Payment" name="advance_payment">       
                                 Previous advance payment: <span class="font-weight-bold" id="previous_advance">0</span>        
                            </div>
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pending Payment</label>
                                <input class="form-control" type="text" onkeypress="return isNumber(event)"
                                 placeholder="Enter Pending Payment" name="pending_payment">     
                                 Previous pending payment: <span class="font-weight-bold" id="previous_pending">0</span>            
                            </div>
                        </div> 
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Next Recovery Date</label>
                                <input class="form-control" type="date" name="next_recovery_date">                
                            </div>
                        </div>  
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="paymentUser" class="btn btn-outline-success">Pay</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>