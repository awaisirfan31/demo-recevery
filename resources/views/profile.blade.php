@extends('layouts.master')
@section('content')

<section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            @if($logo!=null)
            <img src="{{asset('assets/img/logos/admin/'.$logo->image_path)}}" alt="Profile" class="rounded-circle">
            @endif

            <h2>{{ $profile->username }}</h2>
            <h3>{{ $profile->email }}</h3>
   
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>
             @if (Auth::user()->id == $profile->id)                 
             <li class="nav-item">
               <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
             </li>
             @endif

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{ $profile->name }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8">{{$profile->address}}</div>
                </div>


                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8">{{$profile->phone}}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Mobile</div>
                  <div class="col-lg-9 col-md-8">{{$profile->mobile}}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Dealers</div>
                  <div class="col-lg-9 col-md-8">0</div>
                </div>

              </div>

           

             
              @if (Auth::user()->id == $profile->id)    
              <div class="tab-pane fade pt-3" id="profile-change-password">
                <div class="text-danger print-error-msg-password" style="display:none">
        
                    <ul></ul>
    
                </div>
                <!-- Change Password Form -->
                <form action="#" id="updatePasswordAdmin">
                    @csrf
                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="old_password" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="newPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password_confirmation" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="button" id="updatePassword" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->
              @endif
              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>

@endsection


@section('script')
<script type="text/javascript">
    $(document).ready(function () {

        // Update Password
        $('#updatePassword').click(function () {
            // $(".print-error-msg-password").text('');
            $.ajax({
                method: "POST",
                url: "{{route('self-password')}}",
                data: $('#updatePasswordAdmin').serialize(),
                
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
                    //Here the status code can be retrieved like;
                    
                    if(xhr.status == 402)
                    {
                        $(".print-error-msg-password").find("ul").html('');
                        $(".print-error-msg-password").css('display', 'block');
                        $.each(jQuery.parseJSON(xhr.responseText), function (key, values) {
                            $.each(values, function (key, value) {
                            $(".print-error-msg-password").find("ul").append('<li>' + value +
                                '</li>');
                        });
                           
                        });
                    }
                    else
                    {
                        console.log(jQuery.parseJSON(xhr.responseText)); 
                        $.each(jQuery.parseJSON(xhr.responseText), function (key, values) {
                            console.log(values)
                            $(".print-error-msg-password").find("ul").append('<li>' + values +
                                '</li>');
                        });
                    }
                    //The message added to Response object in Controller can be retrieved as following.
                   
                }
            })
            
            
            
            
            
            
            
            
            
            // .done(function(res) {
              
            // }).fail(function(jqXHR, textStatus, errorThrown) {
            //     console.log(jqXHR);
            //     $(".print-error-msg-password").find("ul").html('');
            //         $(".print-error-msg-password").css('display', 'block');
            //         $.each(res.error, function (key, value) {
            //             $(".print-error-msg-password").find("ul").append('<li>' + value +
            //                 '</li>');
            //         });
            //         if(res.custom_error)
            //         {
            //             $(".print-error-msg-password").find("ul").append('<li>' + res.custom_error +'</li>');
            //         }

            // })

        
            
                 

        })

      
              


    });

</script>

@endsection