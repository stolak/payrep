<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    <div class="panel-body">
        <center>
            <h3>{{ env('Coy_Name') }} </h3>
        </center>
        <center>
            <h5>Summary Transaction from {{ date('d/m/Y', strtotime($fromdate)) }} to
                {{ date('d/m/Y', strtotime($todate)) }} </h5>
        </center>
        <div class="table-responsive" style="font-size: 11px; padding:10px;" id="tableData">
            <table class="table table-bordered table-striped table-highlight">
                <thead>
                    <tr bgcolor="#c7c7c7">
                        <th>Transaction Date</th>
                        <th>Amount</th>
                        <th>Ref No</th>
                        <th>Auto-Ref No</th>
                        <th>System Date</th>
                    </tr>
                </thead>

                @foreach ($Trans_Summary as $data)
                    <tr>
                        <td>{{ $data->transdate }}</td>
                        <td style="text-align: right; ">{{ number_format(abs($data->sum_total), 2, '.', ',') }} </td>
                        <td>{{ $data->manual_ref }}</td>
                        <td>&nbsp;{{ $data->ref }} </td>
                        <td>{{ $data->createdat }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
