<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <script>
        var murl = "{{ url('/') }}";
    </script>

    {{-- <link href="{{ asset('assets/css/demo/nifty-demo.min.css') }}" rel="stylesheet"> --}}
    @yield('styles')
    {{-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'> --}}
    {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/nifty.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/demo/nifty-demo-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/pace/pace.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"> --}}

</head>

<body>

    @yield('content')


    <script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/nifty.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.resize.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('jsPDF-1.3.2/jspdf.js') }}"></script>
    <script src="{{ asset('jsPDF-1.3.2/plugins/from_html.js') }}"></script>
    <script src="{{ asset('jsPDF-1.3.2/plugins/split_text_to_size.js') }}"></script>
    <script src="{{ asset('jsPDF-1.3.2/plugins/standard_fonts_metrics.js') }}"></script>

    <!--Sparkline [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Specify page [ SAMPLE ]-->
    <script src="{{ asset('assets/js/demo/dashboard.js') }}"></script>
    @yield('scripts')



</body>

</html>
