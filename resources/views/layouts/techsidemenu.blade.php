@if(Auth::user()->usertype==1)	<li class="list-divider"></li>


<li class="submenu">
	<a href="#"><i class="fe fe-vector"></i> <span> Technical Setting</span> <span class="menu-arrow"></span></a>
	<ul style="display: none;">
		<li><a href="{{url('/sub-module/create')}}">Manage Sub-module</a></li>
		<li><a href="{{url('/module/create')}}">Manage Module</a></li>
		<li><a href="{{url('/assign-module/create')}}">User Privileges</a></li>
	</ul>
</li>
	
@endif
	
 