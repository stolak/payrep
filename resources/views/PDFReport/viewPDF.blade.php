<!DOCTYPE html>
<html>

<head>

	<title>Hi</title>

</head>

<body>
    @php  
                                           
       $complainant = DB::table('tblcomplainant')->where('caseid',$decidedcases->caseID)->get();
       $defendant = DB::table('tbldefendant')->where('caseid',$decidedcases->caseID)->get();  
       $date_decide = DB::table('tblcase_progress')->where('case_id',$decidedcases->caseID)->where('judgement_status',1)->first();  
                                           
    @endphp
<div style="font-size:12px;">
	<h3>IN THE NATIONAL INDUSTRIAL COURT OF NIGERIA</h3>
    <p><span style="font-weight:bold">Suit No.:</span> {{ $decidedcases->suit_no }}</p>
    <p><span style="font-weight:bold">Case Title:</span> {{ $decidedcases->case_title }}</p>
    
    <p><span style="font-weight:bold">Petitioner:</span> @foreach($complainant as $compl) {{ $compl->names }} &nbsp;&nbsp;  @endforeach</p>
    
    <p><span style="font-weight:bold">Respondents:</span> @foreach($defendant as $def) {{ $def->names }}&nbsp;&nbsp;  @endforeach</p>
	<p><span style="font-weight:bold">Date Delivered:</span> {{ $date_decide->update_at }}</p>
	<p><span style="font-weight:bold">Judge:</span> {{ $decidedcases->judgetitile }} {{ $decidedcases->judgename }}</p>
	<p style="text-align:justify"><span style="font-weight:bold">Ruling Delivered:</span> {!! $decidedcases->final_judgement !!}</p>
	<p style="text-align:justify"><span style="font-weight:bold">Signature:</span> {{ $decidedcases->judgetitile }} {{ $decidedcases->judgename }}</p>
</div>
</body>

</html>