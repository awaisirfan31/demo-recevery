@extends('layouts.master')
@section('content')
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-black d-inline">Ledger</h5>
               
               
            </div>
          <div class="card-body">

            <!-- Table with stripped rows -->
            <table class="table datatables">
              <thead>
                <th>#</th>
                <th>Type</th>
                <th>Received By</th>
                <th>Paid By</th>
                <th>Payment Date</th>
                <th>OTC</th>
                <th>Payment</th>
                <th>Received Payment</th>
                <th>Advance Payment</th>
                <th>Pending Payment</th>
              </thead>
              <tbody>
                @foreach($ledgers as $ledger)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $ledger->type }}</td>
                        <td><span class="badge bg-success">{{ $ledger->admin_id }}</span>
                            <span class="badge bg-secondary" >{{ $ledger->admin_name }}</span>
                        </td>
                        <td><span class="badge bg-success">{{ $ledger->user_id }}</span>
                            <span class="badge bg-secondary" >{{ $ledger->user_name }}</span>
                        </td>
                        <td>{{ $ledger->created_at }}</td>
                        <td>{{ $ledger->otc }}</td>
                        <td>{{ $ledger->payment }}</td>
                        <td>{{ $ledger->otc + $ledger->payment }}</td>
                        <td>{{ $ledger->advance_payment }}</td>                           
                        <td>{{ $ledger->pending_payment }}</td>
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

@endsection
@section('script')
<script>

  $(document).ready(function () {
    alert('true');
    $('.datatables').DataTable( {
          dom: 'Bfrtip',
          bLengthChange: true,
           
    //         ajax: {
    //     url: '/ledger',
    //     dataSrc: 'ledger',
    // },
    // columns: [ 
    //   {data: 'type'},
    //   {data: 'admin_id'},
    //   {data: 'admin_name'},
    //   {data: 'user_name'},
    //   {data: 'created_at'},
    //   {data: 'payment'},
    //   {data: 'otc' + 'payment'},
    //   {data: 'advance_payment'},
    //   {data: 'pending_payment'},
    //  ]
        } );

  });
</script>
@endsection