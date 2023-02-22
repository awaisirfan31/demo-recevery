@extends('layouts.master')
@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-black d-inline">All Admins</h5>
                    <button type="button" class="btn btn-primary d-inline float-end" data-bs-toggle="modal"
                        data-bs-target="#addAdminPopup">
                        <i class="bx bxs-plus-circle"></i>
                        &nbsp;
                        Add Admin
                    </button>

                </div>
                <div class="card-body">

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <th>#</th>
                            <th>Admin ID</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Expiry date</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>
                                    @if($admin->status == 0)
                                    <a href="{{ route('profile',Crypt::encrypt($admin->id)) }}"
                                        class="btn btn-success">{{ $admin->admin_id }}</a>
                                    @else
                                    <a href="{{ route('profile',Crypt::encrypt($admin->id)) }}"
                                        class="btn btn-danger">{{ $admin->admin_id }}</a>
                                    @endif
                                    <a href="{{ route('profile',Crypt::encrypt($admin->id)) }}"
                                        class="btn btn-secondary">{{ $admin->name }}</a>
                                </td>
                                <td>{{ $admin->email }} </td>
                                <td>{{ $admin->mobile }} </td>
                                <td>{{ $admin->address }} </td>
                                <td>{{ $admin->expiry_date }} </td>
                                <td>
                                    @if ($admin->status == 0)
                                    <button onclick="admin_status(1,{{ $admin->id }})" data-toggle="tooltip" title="Disable Admin"
                                        type="button" class="status btn btn-sm btn-danger"><i
                                            class="bi bi-exclamation-octagon"></i></button>
                                    @else
                                    <button onclick="admin_status(0,{{ $admin->id }})" title="Enable Admin" type="button"
                                        class="status btn btn-sm btn-success"><i class="bi bi-check-circle"></i></button>
                                    @endif
                                    {{-- <span data-id="{{$admin->id}}" class="toggle-class" type="checkbox"
                                    role="switch" data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                    data-on="Active" data-off="InActive">
                                    </span> --}}
                                    <span data-toggle="tooltip" title="Edit Admin" class="badge bg-warning p-2"
                                        style="font-size: 10px;" onclick="edit_admin_id({{$admin->id}})">
                                        <i class="ri-edit-line"></i>
                                    </span>

                                    <span data-toggle="tooltip" title="Delete Admin" class="badge bg-danger p-2"
                                        style="font-size: 10px;" onclick="delete_admin_id({{$admin->id}})">
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

@include('model.superadmin.create.admin')
@include('model.superadmin.edit.admin')
@include('model.superadmin.delete.admin')
@endsection

@section('script')
<script>
    // Edit
   
    function edit_admin_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#editAdminPopup').modal('show');
        let edit_url = '/admin/' + id + '/edit';
        let temp_status
        $.ajax({
            method: "GET",
            url: edit_url,
        }).done(function (res) {
            if (res.admin) {
                $('#edit_id').val(res.admin.id);
                $('#edit_name').val(res.admin.name);
                $('#edit_phone').val(res.admin.phone);
                $('#edit_national_id').val(res.admin.national_id)
                $('#edit_mobile').val(res.admin.mobile);
                $('#edit_address').val(res.admin.address);
                $('#edit_expiry_date').val(res.admin.expiry_date);
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
    function delete_admin_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#deleteAdminPopup').modal('show');
        document.getElementById('delete_id').value = id;
    }
    function admin_status(status,id) {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            method: "POST",
            url: 'change-status',
            data:
            {
                status: status ,
                id:id
            },
            success: function(res) {
                   Swal.fire({
                       icon: 'success',
                       title: res.success,
                       showConfirmButton: false,
                       timer: 2000
                   })
                   setTimeout("location.reload(true);", 2000);
                   // $(".print-error-msg-password").css('display', 'none'); 
               //Do something with the returned json object.
               },
               error: function (xhr, status, errorThrown) {
                Swal.fire({
                       icon: 'error',
                       title: jQuery.parseJSON(xhr.responseText),
                       showConfirmButton: false,
                       timer: 2000
                   })
               }
        })

        
    }
    $(document).ready(function () {
        //Add 
        $('#adminFormDataAdd').on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: '{{route("admin.store")}}',
                data: new FormData(this),
                processData: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',

            }).done(function (res) {

                $(".print-success-msg").css('display', 'block');
                $(".print-success-msg").text(res.success);
                if (res.success) {
                    $("#adminFormDataAdd")[0].reset();
                    $('#addAdminPopup').modal('hide');
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
                    if (res.error_custom) {
                        $(".print-error-msg").find("ul").append('<li>' + res.error_custom +
                            '</li>');
                    }
                }
            });
        })

        // Update
        $('#adminFormDataEdit').on('submit', function (event) {
            let id = document.getElementById('edit_id').value;
            let form_data = $('#adminFormDataEdit');
            let edit_url = '/admin/' + id;

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                method: "POST",
                url: edit_url,
                data: new FormData(this),
                processData: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
            }).done(function (res) {
                if (res.success) {
                    $('#editAdminPopup').modal('hide');
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
                    if (res.error_custom) {
                        $(".print-error-msg").find("ul").append('<li>' + res.error_custom +
                            '</li>');
                    }
                }
            });
        })
        // Delete
        $('#deleteAdmin').click(function () {
            let form_data = $('#DeleteAdminData');
            let id = document.getElementById('delete_id').value;
            let delete_url = '/admin/' + id;
            $.ajax({
                method: "DELETE",
                url: delete_url,
                data: form_data.serialize(),
            }).done(function (res) {
                if (res.success) {
                    $('#deleteAdminPopup').modal('hide');
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