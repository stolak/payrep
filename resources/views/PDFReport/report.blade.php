@extends('Layouts.layout')
@section('pageTitle')
    Cases Report
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4 mb-4">
        <div class="col-md-12">
                @include('PartialView.messageAlert')
                <div class="card">
                <div class="card-header bg-success text-white">{{ __('Cases') }}</div>
                <div class="card-body p-5">
                   
                            {{ csrf_field() }} 
                <div class="row">
                   
                       <p>&nbsp;</p>
                            <div class=" table-responsive col-md-12">
                                
                                
                                
                                        <table  id="mytable" class="table table-condensed" style="font-size:14px;font-weight:bold">
                                            <thead style="font-weight:bold;color:green;font-size:15px;">
                                              <tr>
                                               
                                                
                                                <th>SN</th>
                                                <th>Case Title</th>
                                                <th>Suit No</th>
                                                <th>Parties</th>
                                                <th>Judges</th>
                                                <th>Date of Judgement</th>
                                                <th>Attachment</th>
                                                <th></th>
                                               
                                              </tr>
                                            </thead>
                                             @php $i = 1; @endphp
                                             
                                        @foreach($decidedcases as $a)
                                         
                                           @php  
                                           
                                           $complainant = DB::table('tblcomplainant')->where('caseid',$a->caseID)->first();
                                           $defendant = DB::table('tbldefendant')->where('caseid',$a->caseID)->first();  
                                           
                                           $countc = DB::table('tblcomplainant')->where('caseid',$a->caseID)->count();
                                           $countd = DB::table('tbldefendant')->where('caseid',$a->caseID)->count();  
                                           
                                           $date_decide = DB::table('tblcase_progress')->where('case_id',$a->caseID)->where('judgement_status',1)->first();  
                                           
                                           @endphp
                                            <tbody>
                                               
                                                @php $pic= '/hearingDocument/'; @endphp 
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $a->case_title }}</td>
                                                <td>{{ $a->suit_no }}</td>
                                                <td>@if($countc>1) {{ $complainant->names }} & {{ $countc-1 }} other(s) @else {{ $complainant->names }} @endif <span style="color:red">Versus</span> @if($countd>1) {{ $defendant->names }} & {{ $countd-1 }} other(s) @else {{ $defendant->names }}  @endif</td>
                                                <td>{{ $a->judgetitile }} {{ $a->judgename }}</td>
                                                <td>{{ $date_decide->update_at }}</td>
                                                <td>@if($date_decide->upload==null) <i style="color:green;font-size:20px">[ no attachment]</i> @else <a href="{{ $pic.$date_decide->upload }}" data-toggle="tooltip" title="Download report" style="color:green;font-size:20px" target="_blank"><i class="fa fa-file"></i> </a> @endif</td>
     </td>
                                                <td><a href="view-report/{{$a->caseID}}" target="_blank"><i style="color:red;font-size:20px;cursor:pointer" class="fas fa-file-pdf" data-toggle="tooltip" title="View report in PDF"></i></a></td>
                                            </tr>
                                              
                                            </tbody>
                                        @endforeach
                                            
                                          </table>
                                       
                            </div>
                        

                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style type="text/css">
.pos{
    padding-left:26px;
    padding-right:26px;
}
</style>

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/font-awesome/fontawesome/all.min.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
@stop

@section('scripts')
<script src="{{asset('assets/font-awesome/fontawesome/all.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script>
 
 $(document).ready(function() {
    $('#').DataTable();
  } );

  $(document).ready(function() {
      $('#mytable').DataTable( {
          dom: 'Bfrtip',
          "pageLength": 50,
          buttons: [
              {
                  extend: 'print',
                  customize: function ( win ) {
                      $(win.document.body)
                          .css( 'font-size', '10pt' )
                          .prepend(
                              ''
                          );
   
                      $(win.document.body).find( 'table' )
                          .addClass( 'compact' )
                          .css( 'font-size', 'inherit' );
                  }
              }
          ]
      } );
  } );

</script>
<script>

function delfunc(x)
    {
        //alert(x);
        var y = confirm('Do you want to delete Judge?');
        
        if(y==true)
            {
                document.location="delete-judge/"+x;
            }
            
        //document.getElementById('id').value = x;
        //$("#myModal").modal('show')
    }
    
function fixfunc()
    {
        alert('Please close the current date before fixing new hearing date');
        
    }
    
function decidefunc()
    {
        alert('New hearing cannot be fixed! Case has been decided.');
        
    }


function closefunc(x,y,z)
    {
        document.getElementById('PID').value = x;
        document.getElementById('caseID').value = y;
        document.getElementById('date').value = z;
        //document.getElementById('caseStatus').value = a;
        
        
        $("#myModal").modal('show')
    }

function editfunc2(x)
    {
        document.getElementById('caseID2').value = x;
        
        $("#myModal2").modal('show')
    }
    
function funceditcomment(x,y)
    {
        document.getElementById('ePID').value = x;
        document.getElementById('ecomment').value = y;
        
        $("#editComment").modal('show')
    }
    
function editfunc(x,y,z,a,b)
    {
        document.getElementById('PIDedit').value = x;
        document.getElementById('caseIDedit').value = y;
        document.getElementById('preinformation').value = z;
        document.getElementById('commentedit').value = a;
        document.getElementById('dateedit').value = b;
        
        $("#editModal").modal('show')
    }


$(document).ready(function(){

    $("#state").change(function(e){
    
        //console.log(e);
        var state_id = e.target.value;
       // var state_id = $(this).val();
        
        //alert(state_id);
        //$token = $("input[name='_token']").val();
        //ajax
        $.get('/get-lga-from-state?state_id='+state_id, function(data){
         $('#lga').empty();
        //console.log(data);
        //$('#lga').append( '<option value="">Select</option>' );
        $.each(data, function(index, obj){
        $('#lga').append( '<option value="'+obj.lgaId+'">'+obj.lga+'</option>' );
        });
        
        
        })
    });
    

});
 
 
 $(document).ready(function(){

    $("#court").change(function(e){
    
        //console.log(e);
        var court_id = e.target.value;
       // var state_id = $(this).val();
        
        //alert(state_id);
        //$token = $("input[name='_token']").val();
        //ajax
        $.get('/get-division-from-court?court_id='+court_id, function(data){
         $('#division').empty();
        //console.log(data);
        //$('#lga').append( '<option value="">Select</option>' );
        $.each(data, function(index, obj){
        $('#division').append( '<option value="'+obj.id+'">'+obj.division+'</option>' );
        });
        
        
        })
    });
    

});
 

</script>
<script>
    function toggle()
    {
        var i = document.getElementById('usercategory').value;
        //alert(i);
        if(i==2)
        {
            document.getElementById("toggle").style.display = "block";
        }
        else if(i==1)
        {
            //alert(i);
            document.getElementById("toggle").style.display = "none";
        }
    }
</script>
<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
@stop