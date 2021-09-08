<template>
  <!-- This example requires Tailwind CSS v2.0+ -->
  <div
    v-if="show"
    class="fixed  z-10 inset-0 overflow-y-auto transition duration-300 ease-out-in "
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0  ">
      <div
        class="fixed inset-0 bg-gray-500 bg-opacity-75  "
        aria-hidden="true"
      >
      </div>

      <span
        class="hidden sm:inline-block sm:h-screen"
        aria-hidden="true"
      >&#8203;</span>

      <div
        v-on-clickaway="closeModal"
        :class="bgColor"
        class="inline-block w-full rounded-lg text-left  shadow-xl transform transition duration-300 ease-out-in sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full"
      >
        <div
          class="flex justify-end pr-2 pt-2 cursor-pointer text-gray-600"
          @click="closeModal"
        >
          <i class="fa fa-times"></i>
        </div>
        <div
          class=" px-4 pb-4  transition duration-300 ease-out-in rounded-lg"
          :class="bgColor"
        >
          <slot></slot>
        </div>

        <slot name="footer"></slot>
      </div>
    </div>
  </div>
</template>
<script>
import { directive as onClickaway } from "vue-clickaway";
export default {
  props: {
    show: {
      default: false,
    },
    bgColor: {
      default: "bg-white",
    },
  },
  mounted() {
    this.bgColor = "bg-white";
  },
  data() {
    return {};
  },
  methods: {
    changeInputColor(color) {
      this.bgcolor = color;
    },
    closeModal() {
      this.$emit("closeModal", false);
    },
    showModal() {
      this.show = true;
    },
  },
  directives: {
    onClickaway: onClickaway,
  },
};
</script>