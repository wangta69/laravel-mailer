<nav id="sidebar">
  <div class="sidebar-header">
    <h3><a href="{{ route('mailer.admin.dashboard') }}">OnStory</a></h3>
    <strong>ON</strong>
  </div>

  <ul class="list-unstyled components" id="navbar-sidebar">
    <li>
      <a href="#mailer-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['mailer.admin*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
          <i class="fa fa-envelope"></i>
          메일
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['mailer.admin*']) ? 'show' : '' }}" id="mailer-sub-menu">
        <li class="{{ request()->routeIs(['mailer.admin.index*']) ? 'current-page' : '' }}">
          <a href="{{ route('mailer.admin.index') }}">발송리스트</a>
        </li>
        <li class="{{ request()->routeIs(['mailer.admin.create*']) ? 'current-page' : '' }}">
          <a href="{{ route('mailer.admin.create') }}">메일 발송</a>
        </li>
      </ul>
    </li>

    
  </ul>
</nav>
