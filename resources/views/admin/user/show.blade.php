@extends('admin.layouts.app')

@section('headSection')
{{--
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}"> --}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
@endsection
@section('main-content')
<style>
  .reminded {
    background-color: #FFDDC4 !important;
  }

  .cleared {
    background-color: #B8FFCC !important;
  }
</style>
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
        @include('includes.messages')
      </div>
    </div>
    <div class="row" style="margin-bottom:10px">
      <div class="col-md-12">
        <h2 style="float:left">Manage Inquiries</h2>
        <a href="{{ route('user.create') }}" style="float: right" class="btn btn-success">Add Enquiry</a>
      </div>
    </div>
    <div>
      <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>S.No</th>
            <th>Customer Name</th>
            <th>Pickup</th>
            <th>Price</th>
            <th>Destination</th>
            <th>Vehicle</th>
            <th>Datetime</th>
            <th>Clearance</th>
            <th>Edit</th>
            <th>Download</th>
            <th>Email & SMS</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
          <tr @if($user->clear == 1)class="cleared" @elseif($user->reminder == 1)class="reminded" @endif>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $user->name }}</td>

            <td>{{ $user->pickup}}</td>
            <td>${{ $user->price}}</td>
            <td>{{ $user->destination}}</td>
            <td>{{ $user->vehicle}}</td>
            <td>{{ date('m/d/Y h:i A', strtotime($user->date))}}</td>
            <td><a href="{{ route('admin.clear',$user->id) }}"><span class="glyphicon glyphicon-ok"></span></a>
              &nbsp;&nbsp;&nbsp;
              <a href="{{ route('admin.reminder',$user->id) }}"><span class="glyphicon glyphicon-bell"></span></a>
            </td>
            <td><a href="{{ route('user.edit',$user->id) }}"><span class="glyphicon glyphicon-edit"></span></a>
            </td>
            <td>
              <a href="{{route('invoice', $user->id)}}" class="btn btn-success btn-xs" style="margin: 2px">
                <span class="glyphicon glyphicon-download"></span> Invoice</a>
              @if ($user->signature_date)
              <a href="{{route('admin.generate', $user->id)}}" class="btn btn-success btn-xs">
                <span class="glyphicon glyphicon-download"></span> Customer Contract</a>
              @endif
            </td>
            <td>
              <a href="{{route('admin.resendInvoiceConfirmationMail', $user->id)}}" class="btn btn-warning btn-xs"
                style="margin:2px">Send Invoice Email</a>

              <a href="{{route('admin.send-sms', $user->id)}}" class="btn btn-warning btn-xs" style="margin:2px">Send
                SMS</a>
            </td>
            <td>
              <form id="delete-form-{{ $user->id }}" method="post" action="{{ route('user.destroy',$user->id) }}"
                style="display: none">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
              </form>
              <a href="" onclick="
                                                                                          if(confirm('Are you sure, You Want to delete this?'))
                                                                                              {
                                                                                                event.preventDefault();
                                                                                                document.getElementById('delete-form-{{ $user->id }}').submit();
                                                                                              }
                                                                                              else{
                                                                                                event.preventDefault();
                                                                                              }"><span
                  class="glyphicon glyphicon-trash"></span></a>
            </td>
          </tr>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('footerSection')
{{-- <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
  var table = $('#example').DataTable( {
  responsive: true
  } );
  
  new $.fn.dataTable.FixedHeader( table );
  } );
</script>
@endsection