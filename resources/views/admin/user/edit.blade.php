@extends('admin.layouts.app')

@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    @include('admin.layouts.pagehead')

  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Update Customer Info</h3>
          </div>

          @include('includes.messages')
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="{{ route('user.update',$user->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="box-body">
              <div class="col-lg-offset-3 col-lg-6">
                <div class="form-group">
                  <label for="name">Customer Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Customer Name"
                    value="@if (old('name')){{ old('name') }}@else{{ $user->name }}@endif">
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="email"
                    value="@if (old('email')){{ old('email') }}@else{{ $user->email }}@endif">
                </div>

                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="phone"
                    value="@if (old('phone')){{ old('phone') }}@else{{ $user->phone }}@endif">
                </div>

                <div class="form-group">
                  <label for="password">Pickup</label>
                  <input type="text" class="form-control" name="pickup" placeholder="Pickup"
                    value="@if (old('pickup')){{ old('pickup') }}@else{{ $user->pickup }}@endif">
                </div>

                <div class="form-group">
                  <label for="destination">Destination</label>
                  <input type="text" class="form-control" name="destination" placeholder="destination"
                    value="@if (old('destination')){{ old('destination') }}@else{{ $user->destination }}@endif">
                </div>

                <div class="form-group">
                  <label for="nop">No. of Passengers</label>
                  <input type="text" class="form-control" name="nop" placeholder="No. of Passengers"
                    value="@if (old('nop')){{ old('nop') }}@else{{ $user->nop }}@endif">
                </div>

                <div class="form-group">
                  <label for="nol">No. of Lugages</label>
                  <input type="text" class="form-control" name="nol" placeholder="No. of Lugages"
                    value="@if (old('nol')){{ old('nol') }}@else{{ $user->nol }}@endif">
                </div>

                <div class="form-group">
                  <label for="no_of_vehicles">No. of Vehicles</label>
                  <input type="text" class="form-control" name="no_of_vehicles" placeholder="No. of Vehicles"
                    value="@if (old('no_of_vehicles')){{ old('no_of_vehicles') }}@else{{ $user->no_of_vehicles }}@endif">
                </div>

                <div class="form-group">
                  <label for="no_of_vehicles">Flight No.</label>
                  <input type="text" class="form-control" name="flight_no" placeholder="Flight No."
                    value="@if (old('flight_no')){{ old('flight_no') }}@else{{ $user->flight_no }}@endif">
                </div>

                <div class="form-group">
                  <label for="destination">Price($)</label>
                  <input type="text" class="form-control" name="price" placeholder="price"
                    value="@if (old('price')){{ old('price') }}@else{{ $user->actual_price }}@endif">
                </div>

                <div class="form-group">
                  <label for="tip">Tip($)</label>
                  <input type="number" class="form-control" name="tip" placeholder="Tip"
                    value="@if (old('tip')){{ old('tip') }}@else{{ $user->tip }}@endif">
                </div>

                <div class="form-group">
                  <label for="toll">Toll($)</label>
                  <input type="number" class="form-control" name="toll" placeholder="Toll"
                    value="@if (old('toll')){{ old('toll') }}@else{{ $user->toll }}@endif">
                </div>

                <div class="form-group">
                  <label for="process_fee">Processing Fee($)</label>
                  <input type="number" class="form-control" name="process_fee" placeholder="Processing Fee"
                    value="@if (old('process_fee')){{ old('process_fee') }}@else{{ $user->process_fee }}@endif">
                </div>

                <div class="form-group">
                  <label for="discount">Discount</label>
                  <input type="number" class="form-control" name="discount" placeholder="Discount"
                    value="@if (old('discount')){{ old('discount') }}@else{{ $user->discount }}@endif">
                </div>

                <div class="form-group">
                  <label for="destination">Date/Time</label>
                  <input type="datetime-local" class="form-control" name="date" placeholder="Date/time"
                    value="@if (old('date')){{ old('date') }}@else{{ $user->date }}@endif">
                </div>

                <div class="form-group" style="margin-top:18px;">
                  <label>Select Vehicle</label>
                  <select class="form-control select2 select2-hidden-accessible" data-placeholder="Vehicle"
                    style="width: 100%;" tabindex="-1" aria-hidden="true" name="vehicle">
                    <option value="Black Car Service" @if($user->vehicle == 'Black Car Service') selected="selected"
                      @endif>Black Car Service</option>
                    <option value="Executive Black Car Service" @if($user->vehicle == 'Executive Black Car Service')
                      selected="selected" @endif>Executive Black Car Service</option>
                    <option value="Black SUV Service" @if($user->vehicle == 'Black SUV Service') selected="selected"
                      @endif>Black SUV Service</option>
                    <option value="Strech limo" @if($user->vehicle == 'Strech limo') selected="selected"
                      @endif>Strech limo</option>
                    <option value="Van" @if($user->vehicle == 'Van') selected="selected"
                      @endif>Van</option>
                    <option value="Bus" @if($user->vehicle == 'Bus') selected="selected"
                      @endif>Bus</option>
                    <option value="Sprinter" @if($user->vehicle == 'Sprinter') selected="selected"
                      @endif>Sprinter</option>
                  </select>
                </div>

                <div class="form-group" style="margin-top:18px;">
                  <label>Select Plan</label>
                  <select class="form-control select2 select2-hidden-accessible" data-placeholder="Vehicle"
                    style="width: 100%;" tabindex="-1" aria-hidden="true" name="plan">
                    <option @if($user->plan == 'Airport Pick up') selected="selected" @endif value="Airport Pick up"
                      >Airport Pick up</option>
                    <option @if($user->plan == 'Airport Drop off') selected="selected" @endif value="Airport Drop
                      off">Airport Drop off</option>
                    <option @if($user->plan == 'Sight Seeing') selected="selected" @endif value="Sight Seeing">Sight
                      Seeing</option>
                    <option @if($user->plan == 'Nightout') selected="selected" @endif value="Nightout">Nightout</option>
                    <option @if($user->plan == 'Wedding') selected="selected" @endif value="Wedding">Wedding</option>
                    <option @if($user->plan == 'Bachelor Party') selected="selected" @endif value="Bachelor
                      Party">Bachelor Party</option>
                    <option @if($user->plan == 'Others(As Directed)') selected="selected" @endif value="Others(As
                      Directed)">Others(As Directed)</option>
                  </select>
                </div>
                @if(isset($user->price_reason))
                @php
                $extras = explode('|',$user->price_reason);
                @endphp
                @foreach($extras as $key=>$extra)
                @php
                $spl = explode(':',$extra);
                @endphp
                <div class="required_inp">
                  <div class="form-group">
                    <label for="destination">Extra Price($)</label>
                    <input type="text" class="form-control" name="price_reason[]" value="{{ $spl[0] }}"
                      placeholder="Price for?" required="required">
                    <label for="destination"></label>
                    <input type="text" class="form-control" name="extra_price[]" value="{{ $spl[1] }}"
                      placeholder="price" required="required">
                  </div>
                  <input type="button" class="inputRemove" value="Remove" />
                </div>
                <label for="destination"></label>
                @php
                @endphp
                @endforeach
                @endif

                <div class="form-group" style="margin-top:18px;">
                  <label>Payment Type</label>
                  <select class="form-control custom-select" data-placeholder="pay_type" style="width: 100%;"
                    tabindex="-1" aria-hidden="true" name="pay_type">
                    <option value="Credit Card" @if($user->pay_type == 'Credit Card') selected="selected" @endif>Credit
                      Card</option>
                    <option value="Cash Payment" @if($user->pay_type == 'Cash Payment') selected="selected" @endif>Cash
                      Payment</option>
                  </select>
                </div>

                <div class="form-group" style="margin-top:18px;">
                  <label>Additional Message</label>
                  <textarea name="addt_msg" id="addt_msg" cols="30" rows="10"
                    class="form-control">@if (old('addt_msg')){{ old('addt_msg') }}@else{{ $user->addt_msg }}@endif</textarea>
                </div>

                <div class="form-group submit-button">
                  <button type="submit" class="btn btn-primary">Save & Update</button>
                  <a href='javascript:void(0);' id="addmore" class="btn btn-success">Extra Price</a>
                  <a href="{{ route('user.index') }}" class="btn btn-danger">Back</a>
                </div>

              </div>

            </div>

          </form>
        </div>
        <!-- /.box -->


      </div>
      <!-- /.col-->
    </div>
    <!-- ./row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

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