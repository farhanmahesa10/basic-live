<template>
  <div class="flex ">
    <div>
      <button
        class="hover:bg-gray-100 h-8 w-8 rounded-full "
        @mouseover="showColor = true"
        @mouseleave="showColor = false"
      >
        <i class="fa fa-paint-brush text-lg text-gray-600 "></i>
      </button>
      <div class="relative bottom-2 ">
        <transition name="fade">
          <div
            v-if="showColor"
            @mouseover="showColor = true"
            @mouseleave="showColor = false"
            :class="[(yPosition == 'top') ?'bottom-8':'top-3',(xPosition == 'right') ?'left-0':'right-0']"
            class="absolute  bg-white  p-2 rounded-md "
            style=" box-shadow: 0 0 5px 0px #888888; "
          >
            <div class="grid gap-2 grid-cols-4 w-32 ">
              <button
                class=" rounded-full h-8 w-8 border hover:opacity-50 "
                v-for="(color,i) in colors"
                :key="i"
                :class="color.bgcolor"
                @click="activeColorChange(color.bgcolor)"
              >
                <i
                  class="fa fa-check text-xs"
                  v-if="color.bgcolor == activeColor"
                ></i>
              </button>
            </div>
            <button class="mt-2 text-gray-600 hover:text-gray-400">
              Set Default
            </button>
          </div>
        </transition>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["yPosition", "xPosition"],
  mounted() {},
  data() {
    return {
      activeColor: "bg-white",
      showColor: false,
      colors: [
        { bgcolor: "bg-white" },
        { bgcolor: "bg-red-300" },
        { bgcolor: "bg-yellow-300" },
        { bgcolor: "bg-green-200" },
        { bgcolor: "bg-red-100" },
        { bgcolor: "bg-green-300" },
        { bgcolor: "bg-blue-300" },
        { bgcolor: "bg-yellow-500" },
        { bgcolor: "bg-blue-400" },
        { bgcolor: "bg-yellow-200" },
        { bgcolor: "bg-red-400" },
        { bgcolor: "bg-gray-200" },
      ],
    };
  },

  methods: {
    activeColorChange(color) {
      this.activeColor = color;
      this.$emit("colorChange", color);
    },
  },
};
</script>