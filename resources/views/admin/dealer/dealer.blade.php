@extends('layouts.master')
@section('content')
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-black d-inline">All Dealers</h5>
                <button type="button" class="btn btn-primary d-inline float-end" data-bs-toggle="modal" data-bs-target="#addDealerPopup">
                    <i class="bx bxs-plus-circle"></i>
                    &nbsp;
                    Add Dealers
                  </button>
               
            </div>
          <div class="card-body">

            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <th>#</th>
                <th>Dealer ID</th>
                <th>Area</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Expiry date</th>
                <th>Action</th>
              </thead>
              <tbody>
                @foreach($dealers as $dealer)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>
                        @if($dealer->status == 0)
                        <span class="btn btn-success">{{ $dealer->admin_id }}</span>
                        @else
                        <span class="btn btn-danger">{{ $dealer->admin_id }}</span>
                        @endif
                        <span class="btn btn-secondary" >{{ $dealer->name }}</span>
                    </td>
                    <td>{{$dealer->area_name }}</td>
                    <td>{{ $dealer->email }} </td>
                    <td>{{ $dealer->mobile }} </td>
                    <td>{{ $dealer->address }} </td>
                    <td>{{ $dealer->expiry_date }} </td>
                    <td>
                        @if ($dealer->status == 0)
                        <button onclick="admin_status(1,{{ $dealer->id }})" data-toggle="tooltip" title="Disable Admin"
                            type="button" class="status btn btn-sm btn-danger"><i
                                class="bi bi-exclamation-octagon"></i></button>
                        @else
                        <button onclick="admin_status(0,{{ $dealer->id }})" title="Enable Admin" type="button"
                            class="status btn btn-sm btn-success"><i class="bi bi-check-circle"></i></button>
                        @endif
                        <span data-toggle="tooltip" title="Edit Dealer" class="badge bg-warning p-2"
                        style="font-size: 10px;" onclick="edit_dealer_id({{$dealer->id}})">
                        <i class="ri-edit-line"></i>
                    </span>

                    <span data-toggle="tooltip" title="Delete Dealer" class="badge bg-danger p-2"
                        style="font-size: 10px;" onclick="delete_dealer_id({{$dealer->id}})">
                        <i class="ri-delete-bin-2-line"></i></span>
                        
                    </td>
                </tr>
                @include('model.admin.edit.dealer')
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
        
    </div>
</div>

</div>
</div>
</section>

@include('model.admin.create.dealer')
{{-- @include('model.admin.edit.dealer') --}}
@include('model.admin.delete.dealer')
@endsection

@section('script')
<script>
    // Edit
    function edit_dealer_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#editDealerPopup').modal('show');
        let edit_url = '/dealer/' + id + '/edit';
        $.ajax({
            method: "GET",
            url: edit_url,
        }).done(function (res) {
            if (res.dealer) {
                $('#edit_id').val(res.dealer.id);
                $('#edit_name').val(res.dealer.name);
                $('#edit_phone').val(res.dealer.phone);
                $('#edit_national_id').val(res.dealer.national_id)
                $('#edit_mobile').val(res.dealer.mobile);
                $('#edit_address').val(res.dealer.address);

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
    function delete_dealer_id(id) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'none');
        $('#deleteDealerPopup').modal('show');
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
        $("#addDealer").click(function () {
            let form_data = $('#dealerFormDataAdd');
            $.ajax({
                method: "POST",
                url: '{{route("dealer.store")}}',
                data: form_data.serialize(),

            }).done(function (res) {

                $(".print-success-msg").css('display', 'block');
                $(".print-success-msg").text(res.success);
                if (res.success) {
                    $("#dealerFormDataAdd")[0].reset();
                    $('#addDealerPopup').modal('hide');
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
        $('#updateDealer').click(function () {
            let id = document.getElementById('edit_id').value;
            let form_data = $('#dealerFormDataEdit');
            let edit_url = '/dealer/' + id;
            // console.log(form_data.serialize());
            $.ajax({
                method: "PUT",
                url: edit_url,
                data: form_data.serialize(),
            }).done(function (res) {
                if (res.success) {
                    $('#editDealerPopup').modal('hide');
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
        $('#deleteDealer').click(function () {
            let form_data = $('#DeleteDealerData');
            let id = document.getElementById('delete_id').value;
            let delete_url = '/dealer/' + id;
            $.ajax({
                method: "DELETE",
                url: delete_url,
                data: form_data.serialize(),
            }).done(function (res) {
                if (res.success) {
                    $('#deleteDealerPopup').modal('hide');
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