<div class="modal fade" id="addCityPopup" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add City</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="text-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>
        <form action="#" method="POST" id="cityFormDataAdd">
            @csrf
            <div class="modal-body ">
                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>City Name</label>
                            <input class="form-control" type="text" placeholder="Enter City Name" name="city_name">                
                        </div>
                    </div>                        
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="addCity" class="btn btn-outline-success">Add</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
       
      </div>
    </div>
  </div>
