<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Test</title>
    @stack('styles')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<style>
.profile-image2 img {
    width: 32px;
    height: 32px;
    object-fit: cover;
    border-radius: 50%;
}

.custom-pagination {
    display: flex;
    justify-content: center;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.custom-pagination .page-item {
    margin: 0 5px;
}

.custom-pagination .page-item .page-link {
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    color: #007bff;
}

.custom-pagination .page-item .page-link:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.custom-pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.select2-container .select2-selection--single {
    height: 38px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>

<body class="hold-transition sidebar-mini">

    @include('sweetalert::alert')

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/profile" class="nav-link">Profile</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <!-- (optional) -->
                <!-- Notifications Dropdown Menu -->
                <!-- (optional) -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link">
                <img src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">A Team UIR</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="profile-image2 image">
                        @if ($user->profile_image)
                        <img src="{{ asset('images/profile/' . $user->profile_image) }}" class="img-circle elevation-2"
                            alt="User Image">
                        @else
                        <img src="{{ asset('images/default-profile.png') }}" class="img-circle elevation-2"
                            alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="profile" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <!-- (optional) -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="/" class="nav-link">
                                <i class="nav-icon fa-solid fa-gauge-high"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                        @if(auth()->user()->role === 'admin')
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/pegawai" class="nav-link">
                                        <i class="nav-icon fa-solid fa-angle-right ml-2"></i>
                                        <p>Pegawai</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/bidang" class="nav-link">
                                        <i class="nav-icon fa-solid fa-angle-right ml-2"></i>
                                        <p>Bidang</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/dpa" class="nav-link">
                                        <i class="nav-icon fa-solid fa-angle-right ml-2"></i>
                                        <p>DPA</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kegiatan" class="nav-link">
                                        <i class="nav-icon fa-solid fa-angle-right ml-2"></i>
                                        <p>Kegiatan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/uraian" class="nav-link">
                                        <i class="nav-icon fa-solid fa-angle-right ml-2"></i>
                                        <p>Uraian</p>
                                    </a>
                                </li>
                            </ul>
                        @endif
                        </li>
                        <li class="nav-item">
                            <a href="/notulen" class="nav-link">
                                <i class="nav-icon fa-solid fa-pen-to-square"></i>
                                <p>Notulen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/jadwal-rapat" class="nav-link">
                                <i class="nav-icon fa-solid fa-calendar-days"></i>
                                <p>Jadwal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/profile" class="nav-link">
                                <i class="nav-icon fa-solid fa-user"></i>
                                <p>Account</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="log-out ml-3" href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-power-off" style="color: red;"></i> Logout
                                <form action="/logout" method="POST" id="logging-out">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')

        <!-- Content Wrapper. Contains page content -->
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>&copy; {{ date('Y') }} A Team UIR</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <!-- Select2 -->
    <script src="/assets/plugins/select2/js/select2.full.min.js"></script>
    <!-- Page specific script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                });
            @endif

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                });
            @endif
        });
    </script>
    <script>
        $(function() {
            var url = window.location;
            // for single sidebar menu
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');

            // for sidebar menu and treeview
            $('ul.nav-treeview a').filter(function() {
                    return this.href == url;
                }).parentsUntil(".nav-sidebar > .nav-treeview")
                .css({
                    'display': 'block'
                })
                .addClass('menu-open').prev('a')
                .addClass('active');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                responsive: true
            });

        });
    </script>
    
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

        //Logout event handler
        $(document).ready(function () {
            $('.log-out').click(function (e) {
                e.preventDefault();
                $('#logging-out').submit();
            });
        });
    </script>
    <script>
        $(function() {
            var url = window.location;
            // for single sidebar menu
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');

            // for sidebar menu and treeview
            $('ul.nav-treeview a').filter(function() {
                    return this.href == url;
                }).parentsUntil(".nav-sidebar > .nav-treeview")
                .css({
                    'display': 'block'
                })
                .addClass('menu-open').prev('a')
                .addClass('active');
        });
    </script>
    @stack('scripts')
</body>

</html>
