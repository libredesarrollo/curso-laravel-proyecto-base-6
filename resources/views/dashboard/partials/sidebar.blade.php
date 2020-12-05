<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset("dashboard/img/sidebar-1.jpg") }}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->

    <div class="logo"><a href="{{ route('post.index') }}" class="simple-text logo-normal">
        Larablog 
      </a></div>
    <div class="sidebar-wrapper">
      <ul class="nav">

        <li class="nav-item {{ Request::path() == 'dashboard/user' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('user.index') }}">
            <i class="material-icons">person</i>
            <p>Usuarios</p>
          </a>
        </li>
        <li class="nav-item {{ Request::path() == 'dashboard/category' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('category.index') }}">
            <i class="material-icons">list</i>
            <p>Categorias</p>
          </a>
        </li>
        <li class="nav-item {{ Request::path() == 'dashboard/post' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('post.index') }}">
            <i class="material-icons">insert_drive_file</i>
            <p>Posts</p>
          </a>
        </li>
        
      </ul>
    </div>
  </div>