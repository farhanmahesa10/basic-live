<template>
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm ">
    <div class="container-fluid my-2">
      <a
        href="#"
        class="text-xl font-semibold tracking-widest no-underline hover:no-underline text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline"
      >Basic Life</a>
      <ul class="navbar-nav ml-auto mr-10 absolute right-16">
        <!-- Authentication Links -->

        <li class="nav-item dropdown">
          <a
            id="navbarDropdown"
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            Akun
          </a>

          <div
            class="dropdown-menu dropdown-menu-right"
            aria-labelledby="navbarDropdown"
          >
            <a
              class="dropdown-item"
              href=""
            >
              Logout
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</template>