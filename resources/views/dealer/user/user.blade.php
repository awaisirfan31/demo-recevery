@extends('layouts.master')
@section('content')
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-black d-inline">All Users</h5>
                <button type="button" class="btn btn-primary d-inline float-end" data-bs-toggle="modal" data-bs-target="#addUserPopup">
                    <i class="bx bxs-plus-circle"></i>
                    &nbsp;
                    Add User
                  </button>
               
            </div>
          <div class="card-body">

            <!-- Table with stripped rows -->
            <table class="table datatable">
                <thead>
                    <th>#</th>
                    <th>User ID</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Package Name</th>
                    <th>Package Price</th>
                    <th>Payment date</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>
                            @if($user->status == 1)
                            <span class="btn btn-success">{{ $user->user_id }}</span>
                            @else
                            <span class="btn btn-danger">{{ $user->user_id }}</span>
                            @endif
                            <span class="btn btn-secondary" >{{ $user->name }}</span>
                        </td>
                        <td>{{ $user->email }} </td>
                        <td>{{ $user->mobile }} </td>
                        <td>{{ $user->address }} </td>
                        <td>{{ $user->package_name }} </td>
                        <td>{{ $user->package_price }} </td>
                        <td>{{ $user->payment_date }} </td>
                        <td>
                            <span data-toggle="tooltip" title="User Payment" class="badge bg-primary p-2"
                                style="font-size: 10px;" onclick="payment_user_id({{$user->id}})">
                            <i class="ri-money-dollar-circle-line"></i>
                            </span>

                            <a href="{{ route('view-invoices',$user->id) }}" data-toggle="tooltip" title="User Invoice" 
                            class="badge bg-info p-2 border-0 d-inline"> <i class="bi bi-currency-dollar"></i></a>
 
                            <span data-toggle="tooltip" title="Edit User" class="badge bg-warning p-2"
                                style="font-size: 10px;" onclick="edit_user_id({{$user->id}})">
                                <i class="ri-edit-line"></i>
                            </span>

                            <span data-toggle="tooltip" title="Delete User" class="badge bg-danger p-2"
                                style="font-size: 10px;" onclick="delete_user_id({{$user->id}})">
                                <i class="ri-delete-bin-2-line"></i>
                            </span>
                            
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

@include('model.dealer.delete.user')
@include('model.dealer.create.user')
@include('model.dealer.extra.payment')
@include('model.dealer.edit.user')
@endsection

@section('script')
<script>
    // Number only
    function isNumber(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    // Payment 
    function payment_user_id(id)
    {
        let url = '/adjustment';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method: "POST",
            url: url,
            data:{
                id:id
            }
        }).done(function (res) {
            if (res.adjustment) {
                $('#previous_advance').text(res.adjustment.advance_payment);
                $('#previous_pending').text(res.adjustment.pending_payment);
                $('#package_name').text(res.package.package_name);
                
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'none');
                $('#paymentUserPopup').modal('show');
                document.getElementById('payment_id').value = id;

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
    // Edit
    function edit_user_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#editUserPopup').modal('show');
        let edit_url = '/user/' + id + '/edit';
        $.ajax({
            method: "GET",
            url: edit_url,
        }).done(function (res) {
            if (res.user) {
                $('#edit_id').val(res.user.id);
                $('#edit_name').val(res.user.name);
                $('#edit_email').val(res.user.email);
                $('#edit_national_id').val(res.user.national_id)
                $('#edit_phone').val(res.user.phone);
                $('#edit_mobile').val(res.user.mobile);
                $('#edit_address').val(res.user.address);
                $('#edit_package_name').val(res.user.package_name);
                $('#edit_package_price').val(res.user.package_price);
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
    function delete_user_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#deleteUserPopup').modal('show');
        document.getElementById('delete_id').value = id;
    }

    $(document).ready(function () {
        //Add 
        $("#addUser").click(function () {
            let form_data = $('#userFormDataAdd');
            $.ajax({
                method: "POST",
                url: '{{route("user.store")}}',
                data: form_data.serialize(),

            }).done(function (res) {

                $(".print-success-msg").css('display', 'block');
                $(".print-success-msg").text(res.success);
                if (res.success) {
                    $("#userFormDataAdd")[0].reset();
                    $('#addUserPopup').modal('hide');
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
                        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                    });
                    if(res.error_custom)
                    {
                        $(".print-error-msg").find("ul").append('<li>' + res.error_custom + '</li>');
                    }
                }
            });
        })

        //Payment 
        $("#paymentUser").click(function () {
            let form_data = $('#userFormDataPayment');
            $.ajax({
                method: "POST",
                url: '{{route("payment")}}',
                data: form_data.serialize(),

            }).done(function (res) {

                $(".print-success-msg").css('display', 'block');
                $(".print-success-msg").text(res.success);
                if (res.success) {
                    $("#userFormDataPayment")[0].reset();
                    $('#paymentUserPopup').modal('hide');
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
                        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                    });
                    if(res.error_custom)
                    {
                        $(".print-error-msg").find("ul").append('<li>' + res.error_custom + '</li>');
                    }
                }
            });
        })

        // Update
        $('#updateUser').click(function () {
            let id = document.getElementById('edit_id').value;
            let form_data = $('#userFormDataEdit');
            let edit_url = '/user/' + id;
            $.ajax({
                method: "PUT",
                url: edit_url,
                data: form_data.serialize(),
            }).done(function (res) {
                if (res.success) {
                    $('#editUserPopup').modal('hide');
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
        $('#deleteUser').click(function () {
            let form_data = $('#DeleteUserData');
            let id = document.getElementById('delete_id').value;
            let delete_url = '/user/' + id;
            $.ajax({
                method: "DELETE",
                url: delete_url,
                data: form_data.serialize(),
            }).done(function (res) {
                if (res.success) {
                    $('#deleteUserPopup').modal('hide');
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