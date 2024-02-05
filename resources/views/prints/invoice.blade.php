<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice - {{$confirmation_no}}</title>
    <style>
        table,
        th,
        td {
            border: 1px solid;
            border-collapse: collapse;
            padding: 5px
        }
    </style>
</head>

<body>
    @if ($clear)
    <div style="left:40%; top:30%; position:absolute;">
        <img src="{{asset('public/images/paid.png')}}" style="width:150px">
    </div>
    @endif

    <table style="text-align: center;">
        <tbody>
            <tr style="background-color: black;">
                <td style="text-align: center; padding:20px" colspan="2">
                    <img style="height: 50px;width: auto;text-align: center" src="{{asset('public/images/logo.png')}}"
                        alt="">
                </td>
            </tr>

            <tr>
                <th>Booking Confirmation</th>
                <td><b>#{{$confirmation_no}}</b></td>
            </tr>

            <tr>
                <th>Booking Date</th>
                <td>{{$booking_date}}</td>
            </tr>

            @if (isset($pickup_location))
            <tr>
                <th>Pickup Location</th>
                <td>{{$pickup_location}}</td>
            </tr>
            @endif

            @if (isset($dropoff_location))
            <tr>
                <th>Dropoff Location</th>
                <td>{{$dropoff_location}}</td>
            </tr>
            @endif

            @if (isset($flight_no))
            <tr>
                <th>Flight No</th>
                <td>{{$flight_no}}</td>
            </tr>
            @endif

            @if (isset($vehicle))
            <tr>
                <th>Vehicle</th>
                <td>{{$vehicle}}</td>
            </tr>
            @endif

            @if (isset($addt_msg))
            <tr>
                <th>Additional Message</th>
                <td>{{$addt_msg}}</td>
            </tr>
            @endif

            @if (isset($payment_type))
            <tr>
                <th>Payment Type</th>
                <td>{{$payment_type}}</td>
            </tr>
            @endif

            @if (isset($base_fare))
            <tr>
                <th>Base Fare</th>
                <td>${{$base_fare}}</td>
            </tr>
            @endif

            @if (isset($toll))
            <tr>
                <th>Toll</th>
                <td>${{$toll}}</td>
            </tr>
            @endif

            @if (isset($tip))
            <tr>
                <th>Tip</th>
                <td>${{$tip}}</td>
            </tr>
            @endif

            @if (isset($processing_fee))
            <tr>
                <th>Processing Fee</th>
                <td>${{$processing_fee}}</td>
            </tr>
            @endif

            @if (isset($discount))
            <tr>
                <th>Discount</th>
                <td>${{$discount}}</td>
            </tr>
            @endif

            @if (isset($price_reason))
            <tr>
                <th>Price Reason</th>
                <td>${{$price_reason}}</td>
            </tr>
            @endif

            @if (isset($total_price))
            <tr>
                <th>Total Price</th>
                <td>${{$total_price}}</td>
            </tr>
            @endif

            <tr style="text-align: left !important">
                <td colspan="2">
                    Note:
                    <ol>
                        <li>The ride is only confirmed if the customer paid at least 24 hours before booking,
                            and the payment is refunded only if the customer cancels the ride before 24 hours of
                            booking.</li>
                        <li>
                            Liability: The Company shall not be liable for any damages, injury, or loss of any kind
                            arising out of or in connection
                            with the limousine service.
                        </li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="font-size: 14px;">
                        P:(914)410-6312 E:info@areacarservice.com A:Scarsdale, NY
                    </p>
                    <p style="font-size: 14px;">&copy; {{date("Y")}} Area Car Service Inc. ,
                        All rights reserved. <span style="font-size: 8px;">We are third
                            party provider.</span></p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>