@extends('layouts.master')
@section('content')

<!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-black d-inline">All Cities</h5>
                <button type="button" class="btn btn-primary d-inline float-end" data-bs-toggle="modal" data-bs-target="#addCityPopup">
                    <i class="bx bxs-plus-circle"></i>
                    &nbsp;
                    Add City
                  </button>
               
            </div>
          <div class="card-body">

            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <th scope="col">#</th>
                <th scope="col">City ID</th>
                <th scope="col">City Name</th>
                <th>Action</th>
              </thead>
              <tbody>
                @foreach($cities as $city)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $city->city_id }}</td>
                            <td>{{ $city->city_name }} </td>
                            <td>
                                <span data-toggle="tooltip" title="Edit City" class="badge bg-warning p-2"
                                style="font-size: 10px;" onclick="edit_city_id({{$city->id}})">
                                <i class="ri-edit-line"></i>
                                </span>

                                <span data-toggle="tooltip" title="Delete City" class="badge bg-danger p-2"
                                style="font-size: 10px;" onclick="delete_city_id({{$city->id}})">
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

{{-- <div class="page-content fade-in-up">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-black d-inline">All Cities</h3>
            <button type="button" class="btn btn-primary d-inline float-right" data-toggle="modal"
            data-target="#addCityPopup"><i class="fa fa-plus-circle"></i>
                &nbsp;Add City
            </button>
        </div>
        <div class="card-body">
            <div class="flexbox mb-4">
                <div class="flexbox"></div>
                <div class="input-group-icon input-group-icon-left mr-3">
                    <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
                    <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                        placeholder="Search ...">
                </div>
            </div>
            <div class="table-responsive row">
                <table class="table table-bordered table-striped table-hover mt-3" id="datatable">
                    <thead>
                        <th>#</th>
                        <th>City ID</th>
                        <th>City Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($cities as $city)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $city->city_id }}</td>
                            <td>{{ $city->city_name }} </td>
                            <td>
                                <span data-toggle="tooltip" title="Edit City" class="badge badge-warning p-2"
                                style="font-size: 10px;" onclick="edit_city_id({{$city->id}})">
                                <i class="fa fa-edit"></i>
                            </span>

                            <span data-toggle="tooltip" title="Delete City" class="badge badge-danger p-2"
                                style="font-size: 10px;" onclick="delete_city_id({{$city->id}})">
                                <i class="fa fa-trash"></i></span>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> --}}
@include('model.superadmin.create.city')
@include('model.superadmin.edit.city')
@include('model.superadmin.delete.city')
@endsection

@section('script')
<script>
    // Edit
    function edit_city_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#editCityPopup').modal('show');
        let edit_url = 'city/' + id + '/edit';
        let temp_status
        $.ajax({
            method: "GET",
            url: edit_url,
        }).done(function (res) {
            if (res.city) {
                $('#edit_id').val(res.city.id);
                $('#edit_city_name').val(res.city.city_name);

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
    function delete_city_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#deleteCityPopup').modal('show');
        document.getElementById('delete_id').value = id;
    }
    $(document).ready(function () {
     
        //Add 
        $("#addCity").click(function () {
            let form_data = $('#cityFormDataAdd');
            $.ajax({
                method: "POST",
                url: '{{route("city.store")}}',
                data: form_data.serialize(),

            }).done(function (res) {

                $(".print-success-msg").css('display', 'block');
                $(".print-success-msg").text(res.success);
                if (res.success) {
                    $("#cityFormDataAdd")[0].reset();
                    $('#addCityPopup').modal('hide');
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
        $('#updateCity').click(function () {
            let id = document.getElementById('edit_id').value;
            let form_data = $('#cityFormDataEdit');
            let edit_url = 'city/' + id;
            $.ajax({
                method: "PUT",
                url: edit_url,
                data: form_data.serialize(),
            }).done(function (res) {
                if (res.success) {
                    $('#editCityPopup').modal('hide');
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
        $('#deleteCity').click(function () {
            let form_data = $('#DeleteCityData');
            let id = document.getElementById('delete_id').value;
            let delete_url = '/city/' + id;
            $.ajax({
                method: "DELETE",
                url: delete_url,
                data: form_data.serialize(),
            }).done(function (res) {
                if (res.success) {
                    $('#deleteCityPopup').modal('hide');
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