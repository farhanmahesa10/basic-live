<template>
  <main-component>
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
          placeholder="Buat catatan..."
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
          placeholder="Judul..."
          v-model="request.title"
          :class="inputColor"
          class="w-full mr-2 p-3 font-medium transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none placeholder-gray-500 text-black"
          style="font-size:17px;overflow:hidden"
        >

        <div
          id="contents"
          @input="setContent"
          ref="contentArea"
          contenteditable="true"
          placeholder="Buat catatan..."
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
    <div>
      <draggable
        v-model="notes"
        ghost-class="ghost"
        :options="{animation:150}"
        @end="onDragEnd"
      >

        <transition-group
          class="mt-4 grid lg:grid-cols-3 xl:grid-cols-6 sm:grid-cols-2 gap-2 "
          type="transition"
          :class="{'cursor-move' : dragger}"
        >
          <div
            v-for="note in notes"
            :key="note.id"
            :class="note.bg_color"
            class="border rounded-xl w-full cursor-pointer hover:shadow-md  p-2  "
          >
            <div
              @click="noteClicked(note)"
              class="overflow-hidden "
              style="height: 4rem; "
            >
              <h3
                class="font-medium"
                v-html="note.title"
              ></h3>
              <p v-html="note.content"></p>
            </div>
            <dropdown-icon-component>
              <li
                class="hover:bg-gray-200  p-2"
                @click="destroy(note.id)"
              >Hapus</li>
            </dropdown-icon-component>
          </div>
        </transition-group>
      </draggable>
    </div>

    <modal-component
      :show="showModal"
      @closeModal="closeModal"
      :bgColor="note.bg_color"
    >
      <input
        type="text"
        placeholder="Judul"
        v-model="note.title"
        :class="note.bg_color"
        class="w-full mr-2  transition duration-300 ease-out-in  font-medium focus:outline-none placeholder-gray-500 text-black"
        style="font-size:17px;overflow:hidden"
      >
      <div
        contenteditable="true"
        ref="contentEdited"
        v-html="note.content"
        placeholder="Buat catatan..."
        class="w-full mt-2 text-lg cursor-text   overflow-hidden
        focus:outline-none placeholder-gray-500 text-gray-600"
      >
      </div>

      <template v-slot:footer>
        <div class=" px-4 py-2 sm:px-6 sm:flex sm:flex-row-reverse justify-between">
          <button
            class="font-medium text-gray-500 rounded-sm hover:bg-gray-100 hover:bg-opacity-25 px-3"
            @click="closeModal"
          >Tutup</button>
          <color-picker-component
            v-on:colorChange="changeContentColor"
            xPosition="right"
            yPosition="bottom"
          ></color-picker-component>
        </div>
      </template>
    </modal-component>

  </main-component>
</template>
<script>
import { directive as onClickaway } from "vue-clickaway";
import MainComponent from "../../layouts/MainComponent.vue";
export default {
  components: { MainComponent },
  mounted() {
    this.notes = this.getAllNotes();
  },
  data() {
    return {
      content: "",
      isWriting: false,
      inputColor: "bg-white",
      notes: [],
      note: {},
      request: {
        title: "",
        content: "",
        bg_color: "",
      },
      dragger: false,
      showModal: false,
      changeContent: "",
    };
  },
  methods: {
    noteClicked(note) {
      this.showModal = true;
      this.note = note;
    },

    onDragEnd(e) {
      let data = this.notes.map((r, i) => {
        i = i + 1;
        r.order = i;
        return { order: r.order, id: r.id };
      });
      this.notes = this.notes.map((r, i) => {
        i = i + 1;
        r.order = i;
        return r;
      });
      axios.post("/api/note/order", data, this.$apiConfig());
    },
    changeInputColor(color) {
      this.inputColor = color;
    },
    changeContentColor(color) {
      this.note.bg_color = color;
    },
    setContent(e) {
      let element = e.target.innerHTML;
      this.content = element;
    },
    writing() {
      this.isWriting = true;
      setTimeout(() => {
        this.$refs.contentArea.focus();
      }, 50);
    },
    setFalseWriting() {
      this.isWriting = false;
      this.request.content = this.content;
      this.request.bg_color = this.inputColor;
      if (this.request.content || this.request.title) {
        axios
          .post("/api/note/store", this.request, this.$apiConfig())
          .then((r) => {
            this.notes.push(r.data);
            this.content = "";
            this.request.content = "";
            this.request.title = "";
          });
      }
    },
    getAllNotes() {
      axios.get("/api/allnotes", this.$apiConfig()).then((r) => {
        this.notes = r.data;
      });
    },
    closeModal() {
      this.showModal = false;
      this.note.content = this.$refs.contentEdited.innerHTML;
      axios
        .post("/api/note/update", this.note, this.$apiConfig())
        .then((r) => {});
    },
    destroy(id) {
      let req = { id };
      axios.post("/api/note/delete", req, this.$apiConfig()).then((r) => {});
      this.notes = this.notes.filter((r) => r.id != id);
      this.$vs.notify({
        position: "bottom-left",
        title: `
            <div class="flex justify-between cursor-pointer">
              <span class='text-white  mr-4 '>Data dihapus, klik untuk</span>  <span class="text-yellow-400 font-bold">Urungkan</span>
            </div>
        `,
        color: "#000",
        click: () => {
          axios
            .post("/api/note/delete/undo", req, this.$apiConfig())
            .then((r) => {
              this.getAllNotes();
            });
        },
      });
    },
  },
  directives: {
    onClickaway: onClickaway,
  },
  computed: {
    dragOptions() {
      return {
        animation: 200,
        group: "description",
        disabled: false,
        ghostClass: "ghost",
      };
    },
  },
};
</script>