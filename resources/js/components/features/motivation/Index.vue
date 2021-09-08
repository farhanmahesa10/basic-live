<template>
  <main-component>
    <div class="">
      <create-content-component
        titlePlaceholder="Judul..."
        contentPlaceholder="Buat motivasi..."
        v-on:result="store"
      ></create-content-component>
    </div>

    <div>
      <draggable
        v-model="motivations"
        ghost-class="ghost"
        :options="{animation:150}"
        @end="onDragEnd"
      >

        <transition-group
          class="mt-4 grid lg:grid-cols-3 xl:grid-cols-2 sm:grid-cols-2 gap-2 "
          type="transition"
          :class="{'cursor-move' : dragger}"
        >
          <div
            v-for="motivation in motivations"
            :key="motivation.id"
            :class="motivation.bg_color"
            class="border rounded-xl w-full cursor-pointer hover:shadow-md  p-2  "
          >
            <div
              @click="motivationClicked(motivation)"
              class="overflow-hidden "
              style="height: 4rem; "
            >
              <h3
                class="font-medium"
                v-html="motivation.title"
              ></h3>
              <p v-html="motivation.content"></p>
            </div>
            <dropdown-icon-component>
              <li
                class="hover:bg-gray-200  p-2"
                @click="destroy(motivation.id)"
              >Hapus</li>
            </dropdown-icon-component>
          </div>
        </transition-group>
      </draggable>
    </div>

    <modal-component
      :show="showModal"
      @closeModal="closeModal"
      :bgColor="req.bg_color"
    >
      <input
        type="text"
        placeholder="Judul"
        v-model="req.title"
        :class="req.bg_color"
        class="w-full mr-2  transition duration-300 ease-out-in  font-medium focus:outline-none placeholder-gray-500 text-black"
        style="font-size:17px;overflow:hidden"
      >
      <div
        contenteditable="true"
        ref="contentEdited"
        v-html="req.content"
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
export default {
  props: [],
  mounted() {
    this.setMotivations();
  },
  data() {
    return {
      motivations: [],
      motivation: {},
      showModal: false,
      req: {
        bg_color: "bg-white",
        title: "",
        content: "",
      },
      dragger: false,
    };
  },
  methods: {
    setMotivations() {
      this.getAllMotivations().then((r) => {
        this.motivations = r;
      });
    },
    getAllMotivations() {
      return axios
        .get("/api/motivation/getall", this.$apiConfig())
        .then((r) => {
          return r.data;
        });
    },
    store(req) {
      axios.post("/api/motivation/store", req, this.$apiConfig()).then((r) => {
        this.motivations.push(r.data.data);
      });
    },
    motivationClicked(item) {
      this.showModal = true;
      this.req = item;
    },
    destroy(id) {
      axios
        .post("/api/motivation/destroy", { id }, this.$apiConfig())
        .then((r) => {
          this.setMotivations();
          this.$vs.notify({
            position: "bottom-left",
            title: `
            <div class="flex justify-between cursor-pointer">
              <span class='text-white  mr-4 '>Motivasi dihapus, klik untuk</span>  <span class="text-yellow-400 font-bold">Urungkan</span>
            </div>
        `,
            color: "#000",
            click: () => {
              this.destroyUndo(id);
            },
          });
        });
    },
    destroyUndo(id) {
      axios
        .post("/api/motivation/destroyundo", { id }, this.$apiConfig())
        .then((r) => {
          this.setMotivations();
        });
    },
    closeModal() {
      this.showModal = false;
      this.req.content = this.$refs.contentEdited.innerHTML;
      axios
        .post("/api/motivation/update", this.req, this.$apiConfig())
        .then((r) => {
          this.setMotivations();
        });
    },
    onDragEnd(e) {
      this.motivations.map((r, i) => {
        i = i + 1;
        r.order = i;
      });
      axios
        .post(
          "/api/motivation/updateorder",
          {
            motivations: this.motivations,
          },
          this.$apiConfig()
        )
        .then((r) => {});
    },
    changeContentColor(color) {
      this.req.bg_color = color;
    },
  },
};
</script>