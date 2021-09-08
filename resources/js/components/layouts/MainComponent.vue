<template>
  <!-- Sidebar -->
  <div class="md:flex flex-col md:flex-row md:min-h-screen w-full font-sans ">
    <div class="flex flex-col w-full md:w-64 text-gray-700 bg-white flex-shrink-0  md:h-screen fixed top-0">
      <div class="flex-shrink-0 px-8 py-3 flex flex-row items-center justify-between bg-white shadow-sm w-screen relative sm:right-1">
        <a
          href="#"
          class="text-xl font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline"
        >Basic Live</a>

        <ul class="navbar-nav ml-auto mr-10 absolute right-5">
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
              <i class="fa fa-user"></i>
            </a>

            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="navbarDropdown"
            >
              <a
                class="dropdown-item"
                href=""
              >
                Akun
              </a>
              <button
                class="dropdown-item"
                @click="logout"
              >
                Logout
              </button>
            </div>
          </li>
        </ul>

        <button
          class="md:hidden rounded-lg focus:outline-none  focus:shadow-outline"
          v-on:click="open = !open"
        >
          <i
            class="fa fa-bars"
            aria-hidden="true"
          ></i>
        </button>
      </div>
      <nav
        :class="{ block: open, hidden: !open }"
        class="flex-grow md:block md:pb-0 md:overflow-y-auto mt-2"
      >
        <template v-for="(menu,i) in menus">
          <router-link
            @click.native="changeActive(menu.link)"
            v-if="!menu.dropdown"
            :key="i"
            :class="{'bg-yellow-100' : activeLink == menu.link}"
            class="block px-4 py-3 rounded-br-full rounded-tr-full
             hover:bg-gray-200 hover:no-underline  text-md font-semibold text-gray-900 
               hover:text-gray-900 focus:text-gray-900  focus:bg-yellow-100 focus:outline-none focus:shadow-outline"
            :to="menu.link"
          >{{menu.title}} </router-link>
          <dropdown-component
            v-if="menu.dropdown"
            @click.native="changeActive(menu.dropdown.link)"
            :key="i"
            :name="menu.dropdown.name"
            :items="menu.dropdown.items"
          />
        </template>
      </nav>
    </div>
    <div
      class="container mt-24  md:px-4  md:ml-80 "
      id="container"
    >
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    if (!this.$apiConfig()) {
      this.$router.push({ name: "Login" });
    }
    this.activeLink = this.$route.fullPath;
  },
  data() {
    return {
      open: false,
      activeLink: "",
      menus: [
        {
          link: "/app/motivation",
          title: "Motivasi",
        },
        {
          link: "/app/todolist",
          title: "To Do List",
        },
        {
          link: "/app/notes",
          title: "Catatan",
        },
        {
          dropdown: {
            name: "Dropdown",
            items: [
              {
                link: "/app/home",
                title: "Home",
              },
              {
                link: "/app/home",
                title: "About",
              },
            ],
          },
        },
        {
          link: "/app/finance",
          title: "Keuangan",
        },
      ],
    };
  },
  methods: {
    toggle() {
      this.open = this.open ? false : true;
    },
    changeActive(link) {
      this.activeLink = link;
    },
    logout() {
      let config = this.$apiConfig();
      axios.post("/api/logout", {}, config);
      localStorage.removeItem("token");
      this.$router.push({ name: "Login" });
    },
  },
};
</script>
