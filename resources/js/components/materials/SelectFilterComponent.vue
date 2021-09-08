<template>
  <div class="center con-selects">
    <vs-select
      class="selectExample"
      autocomplete
      color="#e7c000"
      v-model="value"
      width="420px"
      @input-change="selected"
    >
      <vs-select-item
        color="#000"
        v-for="item,index in options"
        :key="index"
        :value="item.value"
        :text="item.label"
      />
    </vs-select>
  </div>
</template>

<script>
export default {
  props: ["options", "selected"],
  data() {
    return {
      value: "3",
    };
  },
  selected() {},
};
</script>