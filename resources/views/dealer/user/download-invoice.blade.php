<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Payment Paid</title>
</head>

<body style="font-family: 'Open Sans', sans-serif;
         font-weight: 400;">
    <main id="main" class="main">
        <div class="page-content fade-in-up">
            <div class="card shadow mb-4">
                <div class="card-body" style="overflow:auto">
                    <div style="width:450px;" class="border border-secondary">
                        <div class="m-5">
                            @if($payment)
                            <div class="text-center">
                                <img src="{{asset('assets/img/logos/admin/').'/'.$logo->image_path}}" alt="logo" style="width:150px"class="mb-2">
                                <h6>{{ $admin->name }}</h6>
                                <h6>Tel: +{{ $admin->mobile }}</h6>
                                <h6>{{ $admin->email }}</h6>
                                <hr>
                                <h6 style="display: flex; justify-content: space-between;">
                                    <p class="text-left ml-2">
                                        {{ $user->name }}
                                    </p>
                                   
                                    <p class="text-right mr-2">
                                        {{ $payment->created_at->format('F-Y') }}
                                    </p>
                                   
                                </h6>
                            </div>
                            <table class="table table-borderless">
                                <tbody>
                                   
                                    <tr>
                                        <th>OTC</th>
                                        <td class="text-right">Rs. {{ $payment->otc }}</td>
                                    </tr>
                                   
                                   
                                    <tr>
                                        <th>Payment</th>
                                        <td class="text-right">Rs. {{ $payment->payment }}</td>
                                    </tr>
                                   
                                   
                                    <tr>
                                        <th>Advance Payment</th>
                                        <td class="text-right">Rs. {{ $payment->advance_payment }}</td>
                                    </tr>
                                   
                                   
                                    <tr>
                                        <th>Received Payment</th>
                                        <th class="text-right">Rs. {{ ($payment->otc + $payment->payment + $payment->advance_payment)- $payment->pending_payment }}</th>
                                    </tr>
                                   
                                    
                                    <tr>
                                        <th>Pending Payment</th>
                                        <td class="text-right">Rs. {{ $payment->pending_payment }}</td>
                                    </tr>
                                   
                                <tbody>
                            </table>
                            @else
                            <div class="text-center">No Invoice Found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>