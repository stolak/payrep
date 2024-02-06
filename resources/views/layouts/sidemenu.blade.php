<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="active">
                    <a href="/"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                </li>

                @php
                    $userModule = DB::table('assign_role_modules')
                        ->join('submodules', 'submodules.id', '=', 'assign_role_modules.submoduleid')
                        ->join('modules', 'modules.id', '=', 'submodules.moduleid')
                        ->where('assign_role_modules.roleid', '=', Auth::user()->userrole)
                        ->where('submodules.status', '=', 1)
                        ->groupBy('submodules.moduleid')
                        ->groupBy('modules.module')
                        ->groupBy('modules.id')
                        ->select('modules.module', 'modules.id')
                        ->groupBy('modules.module')
                        ->groupBy('modules.id')
                        ->orderBy('modules.module_rank', 'ASC')
                        ->get();
                @endphp
                @if ($userModule)
                    @foreach ($userModule as $module)
                        @php
                            $userLinks = DB::table('assign_role_modules')
                                ->join('submodules', 'submodules.id', '=', 'assign_role_modules.submoduleid')
                                ->join('modules', 'modules.id', '=', 'submodules.moduleid')
                                ->where('assign_role_modules.roleid', '=', Auth::user()->userrole)
                                ->where('submodules.moduleid', '=', $module->id)
                                ->where('submodules.status', '=', 1)
                                ->distinct()
                                ->select('submodules.*')
                                ->orderBy('submodules.rank', 'ASC')
                                ->get();
                        @endphp
                        <li class="submenu">
                            <a href="#"><i class="fe fe-vector"></i> <span> {{ $module->module }}</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @foreach ($userLinks as $route)
                                    <li><a href="{!! url($route->links) !!}">{{ $route->submodule }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach

                @endif
                @include('layouts.techsidemenu')
            </ul>
        </div>
    </div>
</div>
