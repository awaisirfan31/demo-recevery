<div class="modal" id="addAreaPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Area</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="text-danger print-error-msg" style="display:none">

                <ul></ul>
        
            </div>
            <form action="#" method="POST" id="areaFormDataAdd">
                @csrf
                <div class="modal-body ">
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Area Name</label>
                                <input class="form-control" type="text" placeholder="Enter Area Name" name="area_name">                
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addArea" class="btn btn-outline-success">Add</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>