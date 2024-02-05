@extends('admin.layouts.app')

@section('main-content')

<div class="content-wrapper">

  <section class="content-header">
    @include('admin.layouts.pagehead')
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Add Customer Information</h3>
          </div>

          @include('includes.messages')

          <form role="form" action="{{ route('user.store') }}" method="post">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="col-lg-offset-3 col-lg-6 req_input">
                <div class="form-group">
                  <label for="name">Customer Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Customer Name"
                    value="{{ old('name') }}">
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                    value="{{ old('email') }}">
                </div>

                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone"
                    value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                  <label for="password">Pickup</label>
                  <input type="text" class="form-control" name="pickup" placeholder="Pickup"
                    value="{{ old('pickup') }}">
                </div>

                <div class="form-group">
                  <label for="destination">Destination</label>
                  <input type="text" class="form-control" name="destination" placeholder="Destination"
                    value="{{ old('destination') }}">
                </div>

                <div class="form-group">
                  <label for="nop">No. of Passengers</label>
                  <input type="text" class="form-control" name="nop" placeholder="No. of Passengers"
                    value="{{ old('nop') }}">
                </div>

                <div class="form-group">
                  <label for="nol">No. of Lugages</label>
                  <input type="text" class="form-control" name="nol" placeholder="No. of Lugages"
                    value="{{ old('nol') }}">
                </div>

                <div class="form-group">
                  <label for="no_of_vehicles">No. of Vehicles</label>
                  <input type="number" class="form-control" name="no_of_vehicles" placeholder="No. of Vehicles"
                    value="{{ old('no_of_vehicles') }}">
                </div>

                <div class="form-group">
                  <label for="flight_no">Flight No.</label>
                  <input type="text" class="form-control" name="flight_no" placeholder="Fligt No."
                    value="{{ old('flight_no') }}">
                </div>

                <div class="form-group">
                  <label for="price">Price($)</label>
                  <input type="text" class="form-control" name="price" placeholder="Price" value="{{ old('price') }}">
                </div>

                <div class="form-group">
                  <label for="tip">Tip($)</label>
                  <input type="number" class="form-control" name="tip" placeholder="Tip" value="{{ old('tip') }}">
                </div>

                <div class="form-group">
                  <label for="toll">Toll($)</label>
                  <input type="number" class="form-control" name="toll" placeholder="Toll" value="{{ old('toll') }}">
                </div>

                <div class="form-group">
                  <label for="process_fee">Processing Fee($)</label>
                  <input type="number" class="form-control" name="process_fee" placeholder="Processing Fee"
                    value="{{ old('process_fee') }}">
                </div>

                <div class="form-group">
                  <label for="discount">Discount</label>
                  <input type="number" class="form-control" name="discount" placeholder="Discount"
                    value="{{ old('discount') }}">
                </div>

                <div class="form-group">
                  <label for="destination">Date/Time</label>
                  <input type="datetime-local" class="form-control" name="date" placeholder="Date/time"
                    value="{{ old('date') }}">
                </div>

                <div class="form-group" style="margin-top:18px;">
                  <label>Select Vehicle</label>
                  <select class="form-control select2 select2-hidden-accessible" data-placeholder="Vehicle"
                    style="width: 100%;" tabindex="-1" aria-hidden="true" name="vehicle">
                    <option value="Black Car Service">Black Car Service</option>
                    <option value="Executive Black Car Service">Executive Black Car Service</option>
                    <option value="Black SUV Service">Black SUV Service</option>
                    <option value="Strech limo">Strech limo</option>
                    <option value="Van">Van</option>
                    <option value="Bus">Bus</option>
                    <option value="Sprinter">Sprinter</option>
                  </select>
                </div>

                <div class="form-group" style="margin-top:18px;">
                  <label>Select Plan</label>
                  <select class="form-control select2 select2-hidden-accessible" data-placeholder="Vehicle"
                    style="width: 100%;" tabindex="-1" aria-hidden="true" name="plan">
                    <option value="Airport Pick up">Airport Pick up</option>
                    <option value="Airport Drop off">Airport Drop off</option>
                    <option value="Sight Seeing">Sight Seeing</option>
                    <option value="Nightout">Nightout</option>
                    <option value="Wedding">Wedding</option>
                    <option value="Bachelor Party">Bachelor Party</option>
                    <option value="Others(As Directed)">Others(As Directed)</option>
                  </select>
                </div>

                <div class="form-group" style="margin-top:18px;">
                  <label>Payment Type</label>
                  <select class="form-control custom-select" data-placeholder="pay_type" style="width: 100%;"
                    tabindex="-1" aria-hidden="true" name="pay_type">
                    <option value="Credit Card">Credit Card</option>
                    <option value="Cash Payment">Cash Payment</option>
                  </select>
                </div>

                <div class="form-group" style="margin-top:18px;">
                  <label>Additional Message</label>
                  <textarea name="addt_msg" id="addt_msg" cols="30" rows="10" class="form-control"></textarea>
                </div>

                <div class="form-group submit-button">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href='javascript:void(0);' id="addmore" class="btn btn-success">Extra Price</a>
                  <a href="{{ route('user.index') }}" class="btn btn-warning">Back</a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
  $("#addmore").click(function() {
    $('<div class="required_inp"><div class="form-group"><label for="destination">Extra Price($)</label><input type="text" class="form-control"  name="price_reason[]" placeholder="Price for?" required="required"><label for="destination"></label><input type="text" class="form-control"  name="extra_price[]" placeholder="price" required="required"></div>' + '<input type="button" class="inputRemove" value="Remove"/></div><label for="destination"></label>').insertBefore(".submit-button");
  });
  $('body').on('click','.inputRemove',function() {
    $(this).parent('div.required_inp').remove()
  });
});
      
</script>
@endsection