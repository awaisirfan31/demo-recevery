<div class="modal" id="deleteCityPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title">Delete City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="text-danger print-error-msg" style="display:block">
                <ul>
                    <span class="text-danger"></span>
                </ul>                    
            </div>
            <form action="#" method="POST" id="DeleteCityData">
                @csrf
                <input type="text" name="id" id="delete_id" hidden>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="modal-title">
                                Are you sure to delete this item
                            </h5>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  id="deleteCity" class="btn btn-outline-success save-data">Delete</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
        
            </form>
        </div>
    </div>
</div>



