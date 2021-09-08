<template>
  <main-component>
    <div class="flex">
      <div
        class="center con-selects mr-2"
        v-if="!showDreamInput"
      >
        <vs-select
          autocomplete
          color="#e7c000"
          v-model="dreamSelected"
          width="420px"
          @change="dreamChange"
        >
          <vs-select-item
            color="#000"
            v-for="item,index in dreamOptions"
            :key="index"
            :value="item.id"
            :text="item.dream"
          />
        </vs-select>
      </div>
      <button
        class="mr-2"
        v-if="!showDreamInput"
        @click="addDream"
        title="Tambah tujuan"
      ><i class="fas fa-plus"></i>
      </button>
      <button
        class="mr-2"
        v-if="!showDreamInput && this.dreamSelected"
        @click="destroyDream"
        title="Hapus tujuan"
      ><i class="fas fa-trash"></i>
      </button>
      <input
        v-if="showDreamInput"
        v-on-clickaway="storeDream"
        v-focus
        v-model="dreamInput"
        placeholder="Buat tujuan..."
        ref="dreamInput"
        type="text"
        class="w-96 placeholder-gray-400 h-9 p-2 font-medium transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none  text-gray-600"
        style="font-size:17px;overflow:hidden;box-shadow: 0 0 5px 0px #888888; "
      >
    </div>

    <div class="mt-4">
      <create-content-component
        titlePlaceholder="Judul..."
        contentPlaceholder="Buat tugas..."
        v-on:result="storeTodolist"
      ></create-content-component>
    </div>

    <div
      class="grid grid-cols-3 gap-4 mt-4"
      v-if="!isLoading"
    >
      <div class=" w-full rounded-md p-2 bg">
        <h1 class="font-medium text-center">LIST</h1>
        <div class="bg-gray-100 w-full rounded-md p-2 mt-2 ">
          <draggable
            ghost-class="ghost"
            class="list-group"
            group="people"
            :list="todolist"
            :options="{animation:150}"
            @end="onDragEnd"
          >
            <transition-group
              class=""
              type="transition"
              :class="{'cursor-move' : dragger}"
            >
              <div
                v-for="item in todolist"
                :key="item.id"
                :class="item.bg_color"
                class="border rounded-xl w-full cursor-pointer hover:shadow-md  p-2 mb-2 "
              >
                <div
                  @click="itemClicked(item)"
                  class="overflow-hidden "
                  style="height: 4rem; "
                >
                  <h3
                    class="font-medium"
                    v-html="item.title"
                  ></h3>
                  <p v-html="item.todo"></p>
                </div>
                <dropdown-icon-component>
                  <li
                    class="hover:bg-gray-200  p-2"
                    @click="destroyList(item.id)"
                  >Hapus</li>
                </dropdown-icon-component>
              </div>
            </transition-group>
          </draggable>
        </div>

      </div>
      <div class=" w-full rounded-md p-2">
        <h1 class="font-medium text-center">PROCESS</h1>
        <div class="bg-gray-100 w-full rounded-md p-2 mt-2">
          <draggable
            ghost-class="ghost"
            class="list-group"
            :list="todoprocess"
            group="people"
            :options="{animation:150}"
            @end="onDragEnd"
          >
            <transition-group
              class=""
              type="transition"
              :class="{'cursor-move' : dragger}"
            >
              <div
                v-for="item in todoprocess"
                :key="item.id"
                :class="item.bg_color"
                class="border rounded-xl w-full cursor-pointer hover:shadow-md  p-2 mb-2 "
              >
                <div
                  @click="itemClicked(item)"
                  class="overflow-hidden "
                  style="height: 4rem; "
                >
                  <h3
                    class="font-medium"
                    v-html="item.title"
                  ></h3>
                  <p v-html="item.todo"></p>
                </div>
                <dropdown-icon-component>
                  <li
                    class="hover:bg-gray-200  p-2"
                    @click="destroy(item.id)"
                  >Hapus</li>
                </dropdown-icon-component>
              </div>
            </transition-group>
          </draggable>
        </div>
      </div>
      <div class=" w-full rounded-md p-2">
        <h1 class="font-medium text-center">DONE</h1>
        <div class="bg-gray-100 w-full rounded-md p-2 mt-2">
          <draggable
            ghost-class="ghost"
            class="list-group"
            :list="tododone"
            group="people"
            :options="{animation:150}"
            @end="onDragEnd"
          >
            <transition-group
              class=""
              type="transition"
              :class="{'cursor-move' : dragger}"
            >
              <div
                v-for="item in tododone"
                :key="item.id"
                :class="item.bg_color"
                class="border rounded-xl w-full cursor-pointer hover:shadow-md p-2 mb-2 "
              >
                <div
                  @click="itemClicked(item)"
                  class="overflow-hidden "
                  style="height: 4rem; "
                >
                  <h3
                    class="font-medium"
                    v-html="item.title"
                  ></h3>
                  <p v-html="item.todo"></p>
                </div>
                <dropdown-icon-component>
                  <li
                    class="hover:bg-gray-200  p-2"
                    @click="destroy(item.id)"
                  >Hapus</li>
                </dropdown-icon-component>
              </div>
            </transition-group>
          </draggable>
        </div>
      </div>
    </div>
    <div
      class="grid grid-cols-3 gap-4 mt-4"
      v-if="isLoading"
    >
      <PuSkeleton :count="5" />
      <PuSkeleton :count="5" />
      <PuSkeleton :count="5" />
    </div>
    <modal-component
      :show="showModal"
      @closeModal="closeModal"
      :bgColor="list.bg_color"
    >
      <input
        type="text"
        placeholder="Judul"
        v-model="list.title"
        :class="list.bg_color"
        class="w-full mr-2  transition duration-300 ease-out-in  font-medium focus:outline-none placeholder-gray-500 text-black"
        style="font-size:17px;overflow:hidden"
      >
      <div
        contenteditable="true"
        ref="contentEdited"
        v-html="list.todo"
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
import { Skeleton } from "vue-loading-skeleton";
export default {
  mounted() {
    this.getAllDreams();
  },
  data() {
    return {
      showDreamInput: false,
      isLoading: true,
      dreamOptions: [],
      dreamSelected: "",
      dreamInput: "",
      dragger: false,
      todolist: [],
      todoprocess: [],
      tododone: [],
      tmpDeletedDreamId: "",
      showModal: false,
      list: {},
    };
  },
  methods: {
    closeModal() {
      this.showModal = false;
      this.list.content = this.$refs.contentEdited.innerHTML;
      axios
        .post("/api/todolist/update", this.list, this.$apiConfig())
        .then((r) => {
          this.getTodolist(this.dreamSelected);
        });
    },
    changeContentColor(color) {
      this.list.bg_color = color;
    },
    onDragEnd(e) {
      this.todolist.map((r, i) => {
        i = i + 1;
        r.order = i;
      });
      this.todoprocess.map((r, i) => {
        i = i + 1;
        r.order = i;
      });
      this.tododone.map((r, i) => {
        i = i + 1;
        r.order = i;
      });
      axios.post(
        "/api/todolist/updateorder",
        {
          list: this.todolist,
          process: this.todoprocess,
          done: this.tododone,
        },
        this.$apiConfig()
      );
    },
    itemClicked(e) {
      this.showModal = true;
      this.list = e;
    },
    dreamChange() {
      this.getTodolist(this.dreamSelected);
    },
    getAllDreams() {
      axios.get("/api/dream/getall", this.$apiConfig()).then((r) => {
        if (r.data.length > 0) {
          this.dreamSelected = r.data[0].id;
        } else {
          this.dreamSelected = "";
        }
        this.dreamOptions = r.data;
      });
    },
    getTodolist(dreamId) {
      if (dreamId) {
        this.isLoading = true;
        axios
          .get("/api/todolist/getbydream/" + dreamId, this.$apiConfig())
          .then((r) => {
            this.todolist = r.data.filter((res) => res.status == 1);
            this.todoprocess = r.data.filter((res) => res.status == 2);
            this.tododone = r.data.filter((res) => res.status == 3);
            this.isLoading = false;
          });
      }
    },
    addDream() {
      this.showDreamInput = true;
    },
    destroyDream() {
      this.tmpDeletedDreamId = this.dreamSelected;
      axios
        .post(
          "/api/dream/destroy",
          { dreamId: this.dreamSelected },
          this.$apiConfig()
        )
        .then((r) => {
          this.getAllDreams();
        });
      this.$vs.notify({
        position: "bottom-left",
        title: `
            <div class="flex justify-between cursor-pointer">
              <span class='text-white  mr-4 '>Tujuan dihapus, klik untuk</span>  <span class="text-yellow-400 font-bold">Urungkan</span>
            </div>
        `,
        color: "#000",
        click: () => {
          this.destroyDreamUndo();
        },
      });
    },
    destroyDreamUndo() {
      axios
        .post(
          "/api/dream/destroyundo",
          { dreamId: this.tmpDeletedDreamId },
          this.$apiConfig()
        )
        .then((r) => {
          this.getAllDreams();
        });
    },

    storeDream() {
      this.showDreamInput = false;
      if (this.dreamInput) {
        axios
          .post(
            "/api/dream/store",
            { dreamInput: this.dreamInput },
            this.$apiConfig()
          )
          .then((r) => {
            this.dreamOptions.unshift(r.data);
            this.dreamSelected = r.data.id;
          });
        this.dreamInput = "";
      }
    },
    destroyList(listId) {
      axios.post("/api/todolist/destroy", { id: listId }, this.$apiConfig());
      this.getTodolist(this.dreamSelected);
      this.$vs.notify({
        position: "bottom-left",
        title: `
            <div class="flex justify-between cursor-pointer">
              <span class='text-white  mr-4 '>Tujuan dihapus, klik untuk</span>  <span class="text-yellow-400 font-bold">Urungkan</span>
            </div>
        `,
        color: "#000",
        click: () => {
          this.destroyTodolistUndo(listId);
          this.getTodolist(this.dreamSelected);
        },
      });
    },
    destroyTodolistUndo(listId) {
      axios.post(
        "/api/todolist/destroyUndo",
        { id: listId },
        this.$apiConfig()
      );
    },
    storeTodolist(result) {
      if (this.dreamSelected) {
        result.dream_id = this.dreamSelected;
        axios
          .post("/api/todolist/store", result, this.$apiConfig())
          .then((r) => {
            this.todolist.push(r.data.todo);
          });
      }
    },
  },
  directives: {
    onClickaway: onClickaway,
    focus: {
      inserted: function (el) {
        el.focus();
      },
    },
  },
};
</script>