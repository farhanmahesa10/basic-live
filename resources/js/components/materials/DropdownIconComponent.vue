<template>
  <div
    class="flex justify-end"
    v-on-clickaway="handler"
  >
    <i
      class="fa fa-ellipsis-v text-xs hover:bg-gray-200 rounded-full p-1 px-2"
      @click="show = true"
    ></i>
    <div
      class="bg-white rounded-md border absolute mr-3 mt-3 w-40"
      v-if="show"
    >
      <ul class="list-none">
        <slot></slot>
      </ul>
    </div>
  </div>
</template>

<script>
import { directive as onClickaway } from "vue-clickaway";
export default {
  data() {
    return {
      show: false,
    };
  },
  methods: {
    handler() {
      this.show = false;
    },
  },
  directives: {
    onClickaway: onClickaway,
  },
};
</script>