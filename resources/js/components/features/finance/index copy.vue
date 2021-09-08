<template>
  <div>
    <div class="grid xl:grid-cols-2 md:grid-cols-1 gap-4">
      <div class="border border-gray-200 p-2">
        <div class="flex w-full">
          <div>
            <button
              class=" px-2 py-1 bg-green-500 rounded-sm mr-2 mt-1"
              @click="addIncome"
            >
              <i class="fa fa-plus text-white "></i>
            </button>
          </div>
          <span
            class="text-red-400 mt-2"
            v-if="incomeValidation"
            @click="incomeValidation = ''"
          >{{incomeValidation}}
            <i class="fa fa-times-circle   text-gray-400 text-xs rounded-sm px-1  cursor-pointer"></i>
          </span>
          <span
            class="text-green-500"
            v-if="incomeNotify"
            @click="incomeNotify = ''"
          >
            <i class="fa fa-check text-green-500 mt-3"></i>
            {{incomeNotify}} <i class="fa fa-times-circle   text-gray-400 text-xs rounded-sm px-1  cursor-pointer"></i>
          </span>
          <div
            v-if="showAddIncome"
            v-on-clickaway="store"
            class="w-full flex rounded-xl"
            style="box-shadow: 0 0 5px 0px #888888; "
          >
            <input
              placeholder="Keterangan..."
              ref="dreamInput"
              type="text"
              v-model="incomeReq.desc"
              class=" w-full  placeholder-gray-400 h-9 p-2 font-medium transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none  text-gray-600"
              style="font-size:17px;"
            >
            <input
              placeholder="Keterangan..."
              ref="dreamInput"
              type="date"
              v-model="incomeReq.date"
              class=" w-full  placeholder-gray-400 h-9 p-2 font-medium transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none  text-gray-600"
              style="font-size:17px;"
            >
            <input
              placeholder="Uang masuk..."
              ref="dreamInput"
              v-model="incomeReq.amount"
              type="number"
              class=" w-full text-right placeholder-gray-400 h-9 p-2 font-medium transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none  text-gray-600"
              style="font-size:17px;"
            >
          </div>
        </div>

        <h1 class="text-center font-semibold mt-2 text-3xl text-gray-600">UANG MASUK</h1>
        <div class="float-right">

          <div>
            <vs-select
              autocomplete
              color="#e7c000"
              v-model="sortingSelect"
              @change="sorting"
            >
              <vs-select-item
                color="#000"
                value="1"
                text="Hari ini"
              />
              <vs-select-item
                color="#000"
                value="2"
                text="Minggu ini"
              />
              <vs-select-item
                color="#000"
                value="3"
                text="Bulan ini"
              />
              <vs-select-item
                color="#000"
                value="4"
                text="Tahun ini"
              />
            </vs-select>
          </div>
        </div>
        <table class="w-full text-gray-600">
          <thead>
            <tr>
              <th class="text-left w-6/12 lg:w-5/12">Keterangan</th>
              <th class="text-left">Tanggal</th>
              <th class="text-center">Jumlah</th>
            </tr>
          </thead>
          <tbody
            v-for="income in incomes"
            :key="income.id"
          >
            <tr
              class="border-b"
              :class="{'shadow-lg rounded-lg' : incomeReqEditId == income.id}"
            >
              <td class="pl-2 py-2">
                <input
                  type="text"
                  v-if="incomeReqEditId == income.id"
                  v-model="income.desc"
                >
                <span v-if="incomeReqEditId != income.id"> {{income.desc}} </span>
              </td>
              <td class=" ">
                <input
                  type="date"
                  class="w-32"
                  v-if="incomeReqEditId == income.id"
                  v-model="income.date"
                >
                <span v-if="incomeReqEditId != income.id"> {{income.date}} </span>
              </td>
              <td class="w-52">
                <div class="w-full flex justify-between ">
                  <span class="text-left ">Rp.</span>
                  <div class="flex">
                    <input
                      type="number"
                      class="w-full text-right mr-2"
                      v-if="incomeReqEditId == income.id"
                      v-model="income.amount"
                    >
                    <span
                      v-if="incomeReqEditId != income.id"
                      class="mr-2"
                    >{{income.amount | numFormat }} </span>
                    <span v-if="incomeReqEditId != income.id">
                      <i
                        class="fas  fa-times-circle text-red-500 hover:text-red-300 cursor-pointer"
                        title="delete"
                        @click="destroyIncome(income.id)"
                      ></i>
                      <i
                        @click="editIncome(income)"
                        class="fas fa-edit text-blue-500 hover:text-blue-300 cursor-pointer"
                        title="edit"
                      ></i>
                    </span>
                    <span>
                      <i
                        class="fa fa-check-circle text-green-500 cursor-pointer hover:text-green-300"
                        v-if="incomeReqEditId == income.id"
                        @click="updateIncome(income)"
                      ></i>
                    </span>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th
                class="text-left"
                colspan="2"
              >Total </th>
              <th class="flex justify-between">
                <span>Rp. </span> <span>{{totalIncomeSorting | numFormat}}</span>
              </th>
            </tr>
            <tr>
              <th
                class="text-left"
                colspan="2"
              >Total Seluruh Uang Masuk</th>
              <th class="flex justify-between">
                <span>Rp. </span> <span>{{totalAllIncome | numFormat}}</span>
              </th>
            </tr>
            <tr>
              <td
                colspan="3"
                class="text-right "
              >
                <vs-pagination
                  :total="totalPage"
                  class="mt-4"
                  color="#38c172"
                  value="0"
                  v-model="pageActive"
                  @change="pageChange"
                ></vs-pagination>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import { directive as onClickaway } from "vue-clickaway";
import moment from "moment";
export default {
  mounted() {
    this.getallIncome();
    axios.get("/api/finance/sumtotalincome").then((r) => {
      this.totalAllIncome = r.data;
    });
    this.incomeReq.date = moment(new Date()).format("YYYY-MM-DD");
  },
  data() {
    return {
      incomes: [],
      outCome: [],
      showAddIncome: false,
      showEditIncome: false,
      showAddOutcome: false,
      showEditOutcome: false,
      incomeValidation: "",
      incomeNotify: "",
      outcomeValidation: "",
      outcomeNotify: "",
      totalAllIncome: 0,
      totalAllOutcome: 0,
      pageActive: 1,
      totalPage: 2,
      outcomePageActive: 1,
      totalOutcomePage: 2,
      incomeReq: {
        desc: "",
        type: 1,
        amount: "",
        date: "",
      },
      incomeEditId: "",
      totalIncomeSorting: 0,
      incomeReqEditId: "",
      sortingSelect: 1,
    };
  },
  methods: {
    getallIncome() {
      axios
        .get(
          "/api/finance/getallincome?sort=" +
            this.sortingSelect +
            "&page=" +
            this.pageActive
        )
        .then((r) => {
          this.incomes = r.data.finance.data;
          this.totalPage = r.data.finance.links.length - 2;
          this.totalIncomeSorting = r.data.total;
        });
    },
    sorting() {
      this.pageActive = 1;
      this.getallIncome();
    },
    pageChange() {
      this.getallIncome();
    },
    addIncome() {
      this.showAddIncome = true;
      this.incomeValidation = "";
      this.incomeNotify = "";
    },
    addOutcome() {
      this.showAddOutcome = true;
      this.outcomeValidation = "";
      this.outcomeNotify = "";
    },
    store() {
      this.showAddIncome = false;
      this.incomeValidation = "";
      if (this.incomeReq.desc && this.incomeReq.amount) {
        axios.post("/api/finance/store", this.incomeReq).then((r) => {
          this.incomeReq.desc = "";
          this.incomeReq.amount = "";
          this.incomeValidation = "";
          this.incomeNotify = "Uang masuk bertambah!";
          this.getallIncome();
        });
      } else {
        this.incomeValidation = "Kolom tidak boleh kosong";
      }
    },
    editIncome(income) {
      this.incomeReqEditId = income.id;
    },
    updateIncome(income) {
      this.incomeReqEditId = "";
      axios.post("/api/finance/update", income).then((r) => {
        this.incomeNotify = "Satu data diubah!";
      });
    },
    destroyIncome(id) {
      axios.post("/api/finance/destroy", { id }).then((r) => {
        this.getallIncome();
        this.$vs.notify({
          position: "bottom-left",
          title: `
            <div class="flex justify-between cursor-pointer">
              <span class='text-white  mr-4 '>Catatan dihapus, klik untuk</span>  <span class="text-yellow-400 font-bold">Urungkan</span>
            </div>
        `,
          color: "#000",
          click: () => {
            axios.post("/api/finance/delete/undo", { id }).then((r) => {
              this.getallIncome();
            });
          },
        });
      });
    },
  },
  directives: {
    onClickaway: onClickaway,
  },
};
</script>