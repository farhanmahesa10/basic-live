<template>
  <div
    v-on:click="toggle()"
    class="relative"
  >
    <button class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
      <span>{{name}}</span>
      <svg
        fill="currentColor"
        viewBox="0 0 20 20"
        :class="{ 'rotate-180': open, 'rotate-0': !open }"
        class="inline w-4 h-4 mt-1  transition-transform duration-200 transform md:-mt-1"
      >
        <path
          fill-rule="evenodd"
          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
          clip-rule="evenodd"
        />
      </svg>
    </button>
    <div
      v-if="open"
      class="absolute right-0 w-full  mt-2 ml-2 origin-top-right rounded-md "
    >
      <div class="px-2 py-2 bg-white ml-4 mr-4 rounded-md shadow dark-mode:bg-gray-800">
        <a
          v-for="(item,i) in items"
          :key="i"
          class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
          :href="item.link"
        >{{item.title}}</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      default: "name",
    },
    items: {
      default: () => {
        return [
          {
            link: "/",
            title: "title",
          },
        ];
      },
    },
  },
  data() {
    return {
      open: false,
    };
  },
  methods: {
    toggle() {
      this.open = this.open ? false : true;
    },
  },
};
</script>