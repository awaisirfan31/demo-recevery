@extends('layouts.master')
@section('content')
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-black d-inline">All Areas</h5>
                <button type="button" class="btn btn-primary d-inline float-end" data-bs-toggle="modal" data-bs-target="#addAreaPopup">
                    <i class="bx bxs-plus-circle"></i>
                    &nbsp;
                    Add Area
                  </button>
               
            </div>
          <div class="card-body">

            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <th>#</th>
                <th>Area Name</th>
                <th>Action</th>
              </thead>
              <tbody>
                @foreach($areas as $area)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $area->area_name }} </td>
                    <td>
                        <span data-toggle="tooltip" title="Edit Area" class="badge bg-warning p-2"
                        style="font-size: 10px;" onclick="edit_area_id({{$area->id}})">
                        <i class="ri-edit-line"></i>
                    </span>

                    <span data-toggle="tooltip" title="Delete Area" class="badge bg-danger p-2"
                        style="font-size: 10px;" onclick="delete_area_id({{$area->id}})">
                        <i class="ri-delete-bin-2-line"></i></span>
                        
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

      </div>
    </div>
  </section>

@include('model.admin.create.area')
@include('model.admin.edit.area')
@include('model.admin.delete.area')
@endsection

@section('script')
<script>
    // Edit
    function edit_area_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#editAreaPopup').modal('show');
        let edit_url = 'area/' + id + '/edit';
        let temp_status
        $.ajax({
            method: "GET",
            url: edit_url,
        }).done(function (res) {
            if (res.area) {
                $('#edit_id').val(res.area.id);
                $('#edit_area').val(res.area.area_name);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong',
                    showConfirmButton: false,
                    timer: 1500
                })
            }

        });
    }
    // Delete
    function delete_area_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#deleteAreaPopup').modal('show');
        document.getElementById('delete_id').value = id;
    }
    $(document).ready(function () {
        //Add 
        $("#addArea").click(function () {
            let form_data = $('#areaFormDataAdd');
            $.ajax({
                method: "POST",
                url: '{{route("area.store")}}',
                data: form_data.serialize(),

            }).done(function (res) {

                $(".print-success-msg").css('display', 'block');
                $(".print-success-msg").text(res.success);
                if (res.success) {
                    $("#areaFormDataAdd")[0].reset();
                    $('#addAreaPopup').modal('hide');
                    $(".print-success-msg").css('display', 'block');
                    Swal.fire({

                        icon: 'success',
                        title: res.success,
                        showConfirmButton: false,
                        timer: 1500

                    })
                    setTimeout("location.reload(true);", 1500);
                } else {
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display', 'block');
                    $.each(res.error, function (key, value) {
                        $(".print-error-msg").find("ul").append('<li>' + value +
                            '</li>');
                    });
                    if (res.error_other) {
                        $(".print-error-msg").find("ul").append('<li>' + res.error_other +
                            '</li>');
                    }
                }
            });
        })

        // Update
        $('#updateArea').click(function () {
            let id = document.getElementById('edit_id').value;
            let form_data = $('#areaFormDataEdit');
            let edit_url = 'area/' + id;
            $.ajax({
                method: "PUT",
                url: edit_url,
                data: form_data.serialize(),
            }).done(function (res) {
                if (res.success) {
                    $('#editAreaPopup').modal('hide');
                    $(".print-success-msg").css('display', 'block');
                    Swal.fire({

                    icon: 'success',
                    title: res.success,
                    showConfirmButton: false,
                    timer: 1500

                    })
                    setTimeout("location.reload(true);", 1500);
                } else {
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display', 'block');
                    $.each(res.error, function (key, value) {

                        $(".print-error-msg").find("ul").append('<li>' + value +
                            '</li>');

                    });
                    if(res.error_custom)
                    {
                        $(".print-error-msg").find("ul").append('<li>' + res.error_custom + '</li>');
                    }
                }
            });
        })

          // Delete
          $('#deleteArea').click(function () {
            let form_data = $('#DeleteAreaData');
            let id = document.getElementById('delete_id').value;
            let delete_url = '/area/' + id;
            $.ajax({
                method: "DELETE",
                url: delete_url,
                data: form_data.serialize(),
            }).done(function (res) {
                if (res.success) {
                    $('#deleteAreaPopup').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: res.success,
                        showConfirmButton: false,
                        timer: 1500

                    })
                    // window.location.reload();
                    setTimeout("location.reload(true);", 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.error,
                        showConfirmButton: true,
                        timer: 5000

                    })
                }
            });
        })
    });
</script>
@endsection