<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link type="text/css" href="{{asset('public/css/jquery-ui.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/jquery.signature.css')}}">

    <script type="text/javascript" src="{{asset('public/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/js/jquery.signature.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js">
    </script>

    <style>
        .kbw-signature {
            width: 100%;
            height: 300px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
        }
    </style>
</head>

<body>

    <div class="mb-4" style="background:black">
        <div class="d-flex justify-content-center">
            <div class="p-3">
                <img src="https://areacarservice.com/wp-content/uploads/2023/09/area-carlogo-white-blue.png" alt="">
            </div>
        </div>
    </div>

    <div class="container">
        <form method="POST" action="{{ route('admin.signature.upload', $id) }}"> {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for=""><b>Legal Name</b></label>
                        <input type="text" name="legal_name" id="legal_name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="" for=""><b>Signature</b></label>
                    <div id="sig" class="mt-2 mb-2"></div>
                    <button id="clear" class="btn btn-danger float-left">Clear</button>
                    <button class="btn btn-success float-right">Save & Submit</button>
                    <textarea id="signature64" name="signed" style="display: none"></textarea>
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
            $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
    </script>


</body>

</html>