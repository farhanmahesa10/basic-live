<template>
  <div>
    <div
      class="flex justify-center "
      v-if="!isWriting"
    >
      <div
        :class="inputColor"
        class="rounded-xl flex  items-center transition duration-300 ease-out-in  "
        style="width:600px; box-shadow: 0 0 5px 0px #888888; "
      >
        <input
          @click="writing"
          type="text"
          :placeholder="contentPlaceholder"
          :class="inputColor"
          class="w-11/12 h-11 mr-2 p-3 font-medium  transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none placeholder-gray-500 text-gray-600"
          style="font-size:17px;overflow:hidden"
        >
        <color-picker-component
          v-on:colorChange="changeInputColor"
          xPosition="left"
          yPosition="bottom"
        ></color-picker-component>
      </div>
    </div>
    <div
      class="flex justify-center"
      v-if="isWriting"
    >
      <div
        v-on-clickaway="setFalseWriting"
        :class="inputColor"
        class="rounded-xl transition duration-300 ease-out-in  "
        style="width:600px; box-shadow: 0 0 5px 0px #888888; "
      >
        <input
          type="text"
          :placeholder="titlePlaceholder"
          v-model="request.title"
          :class="inputColor"
          class="w-full p-3 font-medium transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none placeholder-gray-500 text-black"
          style="font-size:17px;overflow:hidden"
        >

        <div
          id="contents"
          @input="setContent"
          ref="contentArea"
          contenteditable="true"
          :placeholder="contentPlaceholder"
          :class="inputColor"
          class="w-full px-3 cursor-text  font-medium pb-3 transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none placeholder-gray-500 text-gray-600"
          style="font-size:15px;overflow:hidden;resize: none;"
        >
        </div>
        <div class="mx-3 mb-2 flex justify-between">
          <color-picker-component
            v-on:colorChange="changeInputColor"
            xPosition="right"
            yPosition="bottom"
          ></color-picker-component>
          <button
            class="font-medium text-gray-500 rounded-sm hover:bg-gray-100 hover:bg-opacity-25 px-3"
            @click="setFalseWriting"
          >Tutup</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { directive as onClickaway } from "vue-clickaway";
export default {
  props: ["titlePlaceholder", "contentPlaceholder"],
  mounted() {
    this.onComplete();
  },
  data() {
    return {
      isWriting: false,
      inputColor: "bg-white",
      content: "",
      request: {
        title: "",
        content: "",
        bg_color: "",
      },
    };
  },
  methods: {
    writing() {
      this.isWriting = true;
      setTimeout(() => {
        this.$refs.contentArea.focus();
      }, 50);
    },
    changeInputColor(color) {
      this.inputColor = color;
    },
    changeContentColor(color) {
      this.note.bg_color = color;
    },
    setFalseWriting() {
      this.isWriting = false;
      this.request.content = this.content;
      this.request.bg_color = this.inputColor;

      if (this.request.content || this.request.title) {
        let req = {
          title: this.request.title,
          content: this.request.content,
          bg_color: this.request.bg_color,
        };
        this.$emit("result", req);
        this.content = "";
        this.request.content = "";
        this.request.title = "";
      }
    },
    setContent(e) {
      let element = e.target.innerHTML;
      this.content = element;
    },
    onComplete() {},
  },
  directives: {
    onClickaway: onClickaway,
  },
};
</script>