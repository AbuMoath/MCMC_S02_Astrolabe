@php
	$currentRoute = Route::currentRouteName();
	$homeActive = $currentRoute === 'agency.home';
	$profileActive = $currentRoute === 'agency.profile';
	$securityActive = $currentRoute === 'agency.security';
	$displayActive = $currentRoute === 'agency.view.display.inquiry' || str_starts_with((string) $currentRoute, 'agency.inquiry.');
@endphp

<aside class="sidebar">
	<nav class="sidebar-nav">
		<a href="{{ route('agency.home') }}" class="sidebar-link {{ $homeActive ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Home</a>
		<a href="{{ route('agency.profile') }}" class="sidebar-link {{ $profileActive ? 'active' : '' }}"><i class="fa-solid fa-user"></i> Profile</a>
		<a href="{{ route('agency.security') }}" class="sidebar-link {{ $securityActive ? 'active' : '' }}"><i class="fa-solid fa-shield-halved"></i> Security</a>
		<a href="{{ route('agency.view.display.inquiry') }}" class="sidebar-link {{ $displayActive ? 'active' : '' }}"><i class="fa-regular fa-clipboard"></i> Display and Approve</a>
		<a href="{{ route('login') }}" class="sidebar-link logout-link"><i class="fa-solid fa-right-from-bracket"></i> Back to login</a>
	</nav>
</aside>