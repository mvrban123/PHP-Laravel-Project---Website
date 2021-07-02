 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="" href="{{ route('dashboard') }}">
		<div class="text-center">
			<img class="w-75" src="{{ asset('assets/images/logo.png') }}" alt="logo">
		</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
		<a class="nav-link" href="{{ route('dashboard') }}">
			<i class="fas fa-home fa-fw"></i>
			<span>Naslovnica</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Nav Item - Obitelji -->
	<li class="nav-item {{ Request::is('admin/obitelji') ? 'active' : '' }}">
		<a class="nav-link" href="{{ route('obitelji.index') }}">
			<i class="fas fa-users fa-fw"></i>
			<span>Obitelji</span></a>
	</li>

	<!-- Nav Item - Predlosci -->
	<li class="nav-item {{ Request::is('predlosci/svi') ? 'active' : '' }}">
		<a class="nav-link" href="{{ route('sviPredlosciIndex') }}">
			<i class="fab fa-firstdraft"></i>
			<span>Predlošci</span></a>
	</li>

	<!-- Nav Item - Automatske poruke -->
	<li class="nav-item {{ Request::is('email/postavke') ? 'active' : '' }}">
		<a class="nav-link" href="{{ route('emailPostavke') }}">
			<i class="fas fa-mail-bulk"></i>
			<span>Automatske poruke</span></a>
	</li>

	 <!-- Generiranje izbornika po ulozi za sada bruteforcano -->
	@if(session()->has('listaStranica'))
	@if(session('listaStranica')[0] != 'Prazna lista')
	@foreach(session('listaStranica') as $page)
	<li class="nav-item {{ Request::is($page) ? 'active' : '' }}">
		<a class="nav-link" href="{{ route($page)}}">
			<i class="fas fa-home fa-fw"></i>
			<span>{!!$page!!}</span></a>
	</li>
	@endforeach
	@endif
	@endif

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Nav Item - Sign out -->
	<li class="nav-item">
		<a class="nav-link" href="" id="a_sign_out" data-toggle="modal" data-target="#logoutModal">
			<i class="fas fa-sign-out-alt fa-fw"></i>
			<span>Odjava</span></a>
	</li>

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
 

</ul>
<!-- End of Sidebar -->