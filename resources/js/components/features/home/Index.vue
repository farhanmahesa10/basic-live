<template>
  <div>
    <div class="h-screen flex bg-white justify-center mt-10">
      <div>
        <div class="text-center mb-8">
          <h1 class="text-5xl">BASIC LIFE</h1>
          <h2>Make your disciplined life</h2>
        </div>
        <div class="text-center ">
          <div class="mt-3 text-lg">
            <router-link to="/login">Login </router-link> / <router-link to="/register">Register </router-link>
          </div>
          <div class="grid grid-cols-2 gap-20 p-6 ">
            <div>
              <img
                :src="`/icon/note.png`"
                alt=""
                style="height:150px;"
              >
              <h5 class="text-center text-lg">Catatan</h5>
            </div>
            <div>
              <img
                :src="`/icon/todolist.png`"
                alt=""
                style="height:150px;"
              >
              <h5 class="text-center text-lg">To do list</h5>
            </div>

          </div>
          <div class="flex justify-center mb-2">
            <div>
              <img
                :src="`/icon/money.png`"
                alt=""
                style="height:150px;"
              >
              <h5 class="text-center text-lg">Keuangan Harian</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: [],
  mounted() {},
  data() {
    return {
      menus: [
        { name: "note", icon: "note.png" },
        { name: "To do list", icon: "todolist.png" },
        { name: "Keuangan harian", icon: "money.png" },
      ],
    };
  },
  methods: {},
};
</script>