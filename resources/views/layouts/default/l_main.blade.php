@include('layouts.default.l_header')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">          
        <a href="{{route('dashboard.index')}}" class="logo">
            <span class="logo-mini"><b>{{config('app.name')}}</b></span>
            <span class="logo-lg"><b>{{config('app.name')}}</b></span>
        </a>              
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">0</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Anda punya 0 pesan</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <p>Belum ada pesan baru</p>                                        
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">Lihat semuanya</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">0</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Anda punya 0 notifikasi</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            Belum ada notif baru
                                        </a>
                                    </li>                                                             
                                </ul>
                            </li>
                            <li class="footer"><a href="#">Lihat semuanya</a></li>
                        </ul>
                    </li>                        
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{!!asset(Auth::user()->foto)!!}" class="user-image" alt="{{Auth::user()->username}}">
                            <span class="hidden-xs">{{Auth::user()->username}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{!!asset(Auth::user()->foto)!!}" class="img-circle" alt="{{Auth::user()->username}}">              
                                <p>
                                    {{Auth::user()->username}} - {{Auth::user()->role_name}}
                                    <small>Terdaftar sejak,  {{Auth::user()->created_at->format('M Y')}}</small>
                                </p>
                            </li>
                            <li class="user-body">
                                
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>            
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{!!asset(Auth::user()->foto)!!}" class="img-circle" alt="{{Auth::user()->username}}">
                </div>
                <div class="pull-left info">
                    <p>{{Auth::user()->username}}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <form action="#" method="post" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>DASHBOARD</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                        <ul class="treeview-menu">
                            <li class="header">RINGKASAN UMUM</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-map"></i> PERENCANAAN
                                </a>
                            </li>
                            <li class="header">PERENCANAAN</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-desktop"></i> REKAP PAGU INDIKATIF OPD
                                </a>
                            </li>
                        </ul>
                </li>
                <!-- END DASHBOARD -->

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-puzzle-piece"></i> 
                        <span>MASTERS</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    </a>
                        <ul class="treeview-menu">
                            <li class="header">DATA</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-institution"></i> KELOMPOK URUSAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-institution"></i> URUSAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-institution"></i> ORGANISASI
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-institution"></i> UNIT KERJA
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-institution"></i> PROGRAM
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-institution"></i> KEGIATAN
                                </a>
                            </li>
                            <li class="header">MAPPING</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-archive"></i> PROGRAM - OPD/SKPD
                                </a>
                            </li>
                            <li class="header">ANEKA DATA</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-hdd-o"></i> PAGU ANGGARAN OPD/ <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp SKPD
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-hdd-o"></i> PAGU ANGGARAN <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ANGGOTA DEWAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-hdd-o"></i> TAHUN PERENCANAAN/ <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ANGGARAN
                                </a>
                            </li>
                         </ul>
                </li>
                <!-- END MASTERS -->

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-plane"></i> 
                        <span>PERENCANAAN</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                        <ul class="treeview-menu">
                            <li class="header">RPJMD</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> VISI
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> MISI
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> TUJUAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> SASARAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> STRATEGI
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> PRIORITAS/ARAH <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp KEBIJAKAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> INDIKASI RENCANA <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp PROGRAM
                                </a>
                            </li>
                            <li class="header">RENSTRA OPD/SKPD</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> TUJUAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> SASARAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> STRATEGI
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> ARAH KEBIJAKAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> INDIKATOR SASARAN
                                </a>
                            </li>
                            <li class="header">POKIR/RESES</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> PEMILIK POKOK <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp PIKIRAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-plane"></i> POKOK PIKIRAN
                                </a>
                            </li>
                        </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bar-chart"></i> 
                        <span>WORKFLOW</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> ASPIRASI MUSRENBANG <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp DESA/KELURAHAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> PEMBAHASAN <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp MUSRENBANG <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp DESA/KELURAHAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> ASPIRASI MUSRENBANG <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp KECAMATAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> PEMBAHASAN <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp MUSRENBANG <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp KECAMATAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> USULAN PRA RENJA <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp OPD/SKPD
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> PEMBAHASAN PRA RENJA <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp OPD/SKPD
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> USULAN RAKOR BIDANG
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> PEMBAHASAN RAKOR <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp BIDANG
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> USULAN FORUM <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp OPD/SKPD
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> PEMBAHASAN FORUM <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp OPD/SKPD
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> USULAN MUSRENBANG <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp KAB.
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> PEMBAHASAN <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp MUSRENBANG KAB.
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> VERIFIKASI TAPD
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> RKPD
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> RKPD PERUBAHAN
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-download"></i> PEMBAHASAN RKPD <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp PERUBAHAN
                                </a>
                            </li>
                        </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder-o"></i> 
                        <span>LAPORAN</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                        <ul class="treeview-menu">
                            <li class="header">RENJA OPD/SKPD (MURNI)</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-folder-o"></i> RKPD PER OPD
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-folder-o"></i> RKPD PER OPD RINCI
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-folder-o"></i> PROGRAM RKPD PER OPD
                                </a>
                            </li>
                            <li class="header">RENJA OPD/SKPD (PERUBAHAN)</li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-folder-o"></i> RKPD PERUBAHAN <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp PER OPD
                                </a>
                            </li>
                            <li>
                                <a href="{!!route('permissions.index')!!}">
                                    <i class="fa fa-folder-o"></i> PROGRAM RKPD <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp PER OPD RINCI
                                </a>
                            </li>
                        </ul>
                </li>
                <!--<li>
                    <a href="#">
                        <i class="fa fa-gear"></i> 
                        <span>SETTING</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li> -->
                <li class="header">SETTING</li>
                @hasrole('superadmin') 
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>USERS</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @role('superadmin')
                        <li>
                            <a href="{!!route('permissions.index')!!}">
                                <i class="fa fa-circle-o"></i> PERMISSION
                            </a>
                        </li>
                        <li>
                            <a href="{!!route('roles.index')!!}">
                                <i class="fa fa-circle-o"></i> ROLES
                            </a>
                        </li>
                        @endrole
                        <li>
                            <a href="{!!route('users.index')!!}">
                                <i class="fa fa-circle-o"></i> USERS
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-database"></i> <span>PENYIMPANAN</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @role('superadmin')
                        <li>
                            <a href="{!!route('permissions.index')!!}">
                                <i class="fa fa-clone"></i> COPY DATA
                            </a>
                        </li>
                        <li>
                            <a href="{!!route('roles.index')!!}">
                                <i class="fa fa-refresh"></i> CLEAR CACHE
                            </a>
                        </li>
                        @endrole
                        <li>
                            <a href="{!!route('users.index')!!}">
                                <i class="fa fa-clipboard"></i> LOG
                            </a>
                        </li>
                    </ul>
                </li>         
                @endhasrole	         
            </ul>       
        </section>
    </aside>                  
    <div class="content-wrapper">
        @yield('page-info')
        <section class="content-header">
            <h1>
                @yield('page_header')                
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">
                    <i class="fa fa-dashboard"></i> HOME</a>
                </li>
                @yield('page_breadcrumb') 
            </ol>
        </section>              
        <section class="content">    
            @include('layouts.default.l_formmessages')           
            @yield('page_content')
        </section>                  
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0            
        </div>
        <strong>Copyright &copy; 2018-2019 <a href="http://bintankab.go.id">TIM IT KAB. BINTAN</a>.</strong> All rights reserved.
    </footer>
    @yield('page_sidebar')    
</div>              
@include('layouts.default.l_footer')