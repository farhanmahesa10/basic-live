<template>
  <auth-component>
    <div>
      <h2 class="text-5xl text-center">BASIC LIFE</h2>
      <h3 class="text-md  text-center  text-2xl mt-7">Register</h3>
      <div class="w-full">
        <label
          for="name"
          class=" text-xl text-gray-700 relative top-6 left-2 bg-white"
        >Nama</label>
        <input
          type="text"
          id="name"
          v-model="name"
          @input="nameValidation"
          class=" h-12 p-2 focus:text-lg focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
          style="font-size:15px;"
        >
        <span class="text-red-400">{{errors.name}}</span>
      </div>
      <div class="w-full">
        <label
          for="email"
          class=" text-xl text-gray-700 relative top-6 left-2 bg-white"
        >Email</label>
        <input
          type="text"
          id="email"
          v-model="email"
          @input="emailValidation"
          class=" h-12 p-2 focus:text-lg focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
          style="font-size:15px;"
        >
        <span class="text-red-400">{{errors.email}}</span>

      </div>
      <div>
        <label
          for="password"
          class=" text-xl text-gray-700 relative top-6 left-2 bg-white"
        >Password</label>
        <input
          type="password"
          v-model="password"
          id="password"
          autocomplete="given-name"
          class=" h-12 p-1 focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
          style="font-size:15px;"
        >
      </div>
    </div>
    <div>
      <label
        for="password2"
        class=" text-xl text-gray-700 relative top-6 left-2 bg-white"
      >Konfirmasi password</label>
      <input
        type="password"
        v-model="password_confirm"
        id="password2"
        @input="passwordValidation"
        autocomplete="given-name"
        class=" h-12 p-1 focus:outline-none border focus:shadow-md block w-full sm:text-sm border-gray-300 rounded-md"
        style="font-size:15px;"
      >
      <span class="text-red-400">{{errors.password}}</span>
    </div>
    <div class="w-full flex justify-center ">
      <span class="text-center text-red-400">
        {{notify}}
      </span>
    </div>
    <button
      class="bg-yellow-100 w-full p-2 rounded-full mt-4 h-14 text-2xl hover:bg-gray-200"
      @click="register"
    >Register</button>
    <div class="text-xs text-center mt-4">
      Already have account?
      <router-link
        to="/login"
        class="hover:no-underline font-bold hover:text-gray-400"
      >
        Login
      </router-link>
    </div>
  </auth-component>
</template>
<script>
import validator from "validator";
export default {
  mounted() {},
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirm: "",
      errors: {
        name: "",
        email: "",
        password: "",
      },
      notify: "",
    };
  },
  methods: {
    register() {
      if (!this.errors.email && !this.errors.password && !this.errors.email) {
        axios
          .post("/api/register", {
            email: this.email,
            name: this.name,
            password: this.password,
          })
          .then((r) => {
            localStorage.setItem("token", r.data.token);
            this.$router.push({ name: "Motivation Index" });
          });
      }
    },

    nameValidation() {
      if (!this.name) {
        this.errors.name = "Nama tidak boleh kosong";
      } else {
        this.errors.name = "";
      }
    },
    passwordValidation() {
      if (this.password != this.password_confirm) {
        this.errors.password = "Password tidak cocok";
      } else {
        this.errors.password = "";
      }
    },
    emailValidation() {
      if (!validator.isEmail(this.email)) {
        this.errors.email = "Format email salah";
      } else {
        this.errors.email = "";
      }
    },
  },
  computed: {
    emailError() {
      return this.errors.email;
    },
  },
};
</script>