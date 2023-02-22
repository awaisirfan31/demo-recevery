@extends('layouts.master')
@section('content')


<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">TOTAL USERS</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-emoji-smile"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $all_users }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">ADVANCE PAYMENTS</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $advance_payments }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">PENDING PAYMENTS</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $pending_payments }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">PAYMENTS RECIEVED</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $received_payments }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">PAYMENTS REMAINING</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $remaining_payment }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">TOTAL RECOVERY</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-credit-card-2-back"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $received_payments + $remaining_payment }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->






                <!-- Reports -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Column Chart</h5>

                            <!-- Column Chart -->
                            <div id="columnChart"></div>


                            <!-- End Column Chart -->

                        </div>
                    </div>
                </div>
                <!-- End Reports -->

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">


                        <div class="card-body">
                            <h5 class="card-title">Recent Sales</h5>

                            <table class="table table-border table-striped datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Invoice_id</th>
                                        <th scope="col">username</th>
                                        <th scope="col">Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resent_sale as $item)

                                    <tr>
                                        <th>{{ $loop->index+1 }}</th>
                                        <th>{{ $item->invoice_id }}</th>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->payment }}</td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div><!-- End Recent Sales -->


            </div>
        </div><!-- End Left side columns -->



    </div>
</section>
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $.ajax({
            method: "GET",
            url: 'dashboard-graph',
        }).done(function (res) {
            console.log(res.months)
            new ApexCharts(document.querySelector("#columnChart"), {
                series: [{
                    name: 'Sales',
                    data: res.sales
                }, {
                    name: 'Revenue',
                    data: res.revinue
                }, {
                    name: 'Users',
                    data: res.users
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: res.months
                },
                yaxis: {
                    title: {
                        text: '$ (thousands)'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val 
                        }
                    }
                }
            }).render();
        });

    });
</script>
@endsection