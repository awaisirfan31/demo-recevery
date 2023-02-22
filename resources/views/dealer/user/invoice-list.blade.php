@extends('layouts.master')
@section('content')

<!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-black d-inline">All Invoices</h5>
                </div>
                <div class="card-body">

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Invoice No</th>
                            <th>Action</th>
                          </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $invoice->invoice_id }}</td>
                                <td>
                                    <form action="{{ route('view-invoice') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$invoice->id}}">
                                        <button type="submit" data-toggle="tooltip" title="User Invoice" 
                                        class="badge bg-info p-2 border-0 d-inline"> <i class="bi bi-currency-dollar"></i></button>
                                    </form>
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
@endsection