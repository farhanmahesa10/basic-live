<template>
  <auth-component>
    <div>
      <h2 class="text-5xl text-center">BASIC LIFE</h2>
      <h3 class="text-md  text-center  text-2xl mt-7">Login</h3>
      <div class="w-full">
        <label
          for="email"
          class=" text-xl text-gray-700 relative top-6 left-2 bg-white"
        >Email</label>
        <input
          type="text"
          id="email"
          v-model="email"
          @input="notify = ''"
          autocomplete="given-name"
          value=""
          class="mt-1 h-16 p-2 focus:text-lg focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
          style="font-size:20px;"
        >

      </div>
      <div>
        <label
          for="password"
          class=" text-xl text-gray-700 relative top-6 left-2 bg-white"
        >Password</label>
        <input
          type="password"
          v-model="password"
          @input="notify = ''"
          id="password"
          autocomplete="given-name"
          class="mt-1 h-16 p-1 focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
          style="font-size:20px;"
        >
      </div>
      <div class="w-full flex justify-center ">
        <span class="text-center text-red-400">
          {{notify}}
        </span>
      </div>
      <button
        class="bg-yellow-100 w-full p-2 rounded-full mt-4 h-14 text-2xl hover:bg-gray-200"
        @click="login"
      >LOGIN</button>
      <div class="text-xs text-center mt-4">
        Didn't have account?
        <router-link
          to="/register"
          class="hover:no-underline font-bold hover:text-gray-400"
        >
          Register
        </router-link>
      </div>
    </div>
  </auth-component>
</template>
<script>
export default {
  mounted() {
    if (localStorage.getItem("token")) {
      this.$router.push({ name: "Motivation Index" });
    }
  },
  data() {
    return {
      email: "",
      password: "",
      notify: "",
    };
  },
  methods: {
    login() {
      axios
        .post("/api/login", { email: this.email, password: this.password })
        .then((r) => {
          if (r.data.status == "failed") {
            this.notify = r.data.message;
          } else {
            localStorage.setItem("token", r.data.token);
            this.$router.push({ name: "Motivation Index" });
          }
        });
    },
  },
};
</script>