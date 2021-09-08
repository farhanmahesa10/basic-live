<template>
  <div>
    <div class="border border-gray-200 p-2">
      <div class="flex w-full">
        <div>
          <button
            class=" px-2 py-1  rounded-sm mr-2 mt-1"
            :style="{'background-color' : color}"
            @click="addFinance"
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
          v-if="financeNotify"
          @click="financeNotify = ''"
        >
          <i class="fa fa-check text-green-500 mt-3"></i>
          {{financeNotify}} <i class="fa fa-times-circle   text-gray-400 text-xs rounded-sm px-1  cursor-pointer"></i>
        </span>
        <div
          v-if="showAddInput"
          v-on-clickaway="store"
          class="w-full flex rounded-xl"
          style="box-shadow: 0 0 5px 0px #888888; "
        >
          <input
            placeholder="Keterangan..."
            ref="dreamInput"
            type="text"
            v-model="financeReq.desc"
            class=" w-full  placeholder-gray-400 h-9 p-2 font-medium transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none  text-gray-600"
            style="font-size:17px;"
          >
          <input
            placeholder="Keterangan..."
            ref="dreamInput"
            type="date"
            v-model="financeReq.date"
            class=" w-full  placeholder-gray-400 h-9 p-2 font-medium transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none  text-gray-600"
            style="font-size:17px;"
          >
          <input
            :placeholder="title + '...'"
            ref="dreamInput"
            v-model="financeReq.amount"
            type="number"
            class=" w-full text-right placeholder-gray-400 h-9 p-2 font-medium transition duration-300 ease-out-in drop-shadow-lg rounded-xl focus:outline-none  text-gray-600"
            style="font-size:17px;"
          >
        </div>
      </div>

      <h1 class="text-center font-semibold mt-2 text-3xl text-gray-600">{{title}}</h1>
      <div class="float-right flex my-2">
        <date-picker
          v-model="calender.value"
          valueType="format"
          :formatter="myFormat"
          :type="calender.type"
          :placeholder="calender.placeholder"
          class="mr-2"
          @input="dateChange"
        ></date-picker>
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
              text="Harian"
            />
            <vs-select-item
              color="#000"
              value="2"
              text="Mingguan"
            />
            <vs-select-item
              color="#000"
              value="3"
              text="Bulanan"
            />
            <vs-select-item
              color="#000"
              value="4"
              text="Tahunan"
            />
          </vs-select>
        </div>
      </div>
      <table class="w-full text-gray-600">
        <thead>
          <tr class="border-b">
            <th class="text-left w-6/12 lg:w-5/12">Keterangan</th>
            <th class="text-left">Tanggal</th>
            <th class="text-center">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="finance in finances"
            :key="finance.id"
            class="border-b"
            :class="{'shadow-lg rounded-lg' : financeReqEditId == finance.id}"
          >
            <td class="pl-2 py-2">
              <input
                type="text"
                v-if="financeReqEditId == finance.id"
                v-model="finance.desc"
              >
              <span v-if="financeReqEditId != finance.id"> {{finance.desc}} </span>
            </td>
            <td class=" ">
              <input
                type="date"
                class="w-32"
                v-if="financeReqEditId == finance.id"
                v-model="finance.date"
              >
              <span v-if="financeReqEditId != finance.id"> {{finance.date}} </span>
            </td>
            <td class="w-52">
              <div class="w-full flex justify-between ">
                <span class="text-left ">Rp.</span>
                <div class="flex">
                  <input
                    type="number"
                    class="w-full text-right mr-2"
                    v-if="financeReqEditId == finance.id"
                    v-model="finance.amount"
                  >
                  <span
                    v-if="financeReqEditId != finance.id"
                    class="mr-2"
                  >{{finance.amount | numFormat }} </span>
                  <span v-if="financeReqEditId != finance.id">
                    <i
                      class="fas  fa-times-circle text-red-500 hover:text-red-300 cursor-pointer"
                      title="delete"
                      @click="destroyFinance(finance.id)"
                    ></i>
                    <i
                      @click="editFinance(finance)"
                      class="fas fa-edit text-blue-500 hover:text-blue-300 cursor-pointer"
                      title="edit"
                    ></i>
                  </span>
                  <span>
                    <i
                      class="fa fa-check-circle text-green-500 cursor-pointer hover:text-green-300"
                      v-if="financeReqEditId == finance.id"
                      @click="updateFinance(finance)"
                    ></i>
                  </span>
                </div>
              </div>
            </td>
          </tr>
          <tr v-if="finances.length < 1 ">
            <td
              colspan="3"
              class="text-center border-b pl-2 py-2"
            > Belum ada data!</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th
              class="text-left"
              colspan="2"
            >Total </th>
            <th class="flex justify-between">
              <span>Rp. </span> <span>{{totalSorting| numFormat}}</span>
            </th>
          </tr>
          <tr>
            <th
              class="text-left"
              colspan="2"
            >Total Seluruh Uang Masuk</th>
            <th class="flex justify-between">
              <span>Rp. </span> <span>{{totalAllAmount | numFormat}}</span>
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
                :color="color"
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
</template>
<script>
import { directive as onClickaway } from "vue-clickaway";
import moment from "moment";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
  components: { DatePicker },
  props: {
    financeDatas: {
      type: Object,
      default: {},
    },
    financeType: {
      type: String,
    },
    title: {
      type: String,
    },
    color: {
      type: String,
    },
  },
  mounted() {},
  watch: {
    financeDatas(newVal, oldVal) {
      this.finances = newVal.finance.data;
      this.totalSorting = newVal.total;
      this.totalPage = newVal.finance.links.length - 2;
    },
  },
  created() {
    this.financeReq.type = this.financeType;
    this.financeReq.date = moment(new Date()).format("YYYY-MM-DD");
    axios
      .get(
        "/api/finance/totalallamount?type=" + this.financeType,
        this.$apiConfig()
      )
      .then((r) => {
        this.totalAllAmount = r.data;
      });
  },
  data() {
    return {
      myFormat: {
        // Date to String
        stringify: (date) => {
          if (this.calender.type == "date") {
            return moment(date).format("YYYY-MM-DD");
          } else if (this.calender.type == "week") {
            let weekValue = `${moment(date).format("YYYY-MM,")}${
              moment(date).week() - moment(date).startOf("month").week() + 1
            }`;
            this.calender.weekValue = weekValue;
            return moment(date).week().toString();
          } else if (this.calender.type == "month") {
            return moment(date).format("YYYY-MM");
          } else if (this.calender.type == "year") {
            return moment(date).format("YYYY");
          }
          // return;
        },
      },
      calender: {
        type: "date",
        value: moment(new Date()).format("YYYY-MM-DD"),
        placeholder: "Pilih hari",
        weekValue: "",
      },
      finances: [],
      totalSorting: 0,
      showAddInput: false,
      incomeValidation: "",
      financeNotify: "",
      totalAllAmount: 0,
      pageActive: 1,
      totalPage: 1,
      financeReq: {
        desc: "",
        type: 1,
        amount: "",
        date: "",
      },
      financeReqEditId: "",
      sortingSelect: 1,
    };
  },
  methods: {
    dateChange() {
      this.$emit("sorting", this.financeType, this.calender);
    },
    sorting() {
      this.pageActive = 1;
      if (this.sortingSelect == 1) {
        this.calender.type = "date";
        this.calender.value = moment(new Date()).format("YYYY-MM-DD");
        this.calender.placeholder = "Pilih hari";
      } else if (this.sortingSelect == 2) {
        this.calender.type = "week";
        this.calender.value = moment(new Date()).week().toString();
        this.calender.weekValue = `${moment(new Date()).format("YYYY-MM,")}${
          moment(new Date()).week() -
          moment(new Date()).startOf("month").week() +
          1
        }`;
        this.calender.placeholder = "Pilih minggu";
      } else if (this.sortingSelect == 3) {
        this.calender.type = "month";
        this.calender.value = moment(new Date()).format("YYYY-MM");
        this.calender.placeholder = "Pilih bulan";
      } else if (this.sortingSelect == 4) {
        this.calender.type = "year";
        this.calender.value = moment(new Date()).format("YYYY");
        this.calender.placeholder = "Pilih tahun";
      }
      this.$emit("sorting", this.financeType, this.calender);
    },
    pageChange() {
      this.$emit(
        "pageChange",
        this.financeType,
        this.pageActive,
        this.calender
      );
    },
    addFinance() {
      this.showAddInput = true;
      this.incomeValidation = "";
      this.financeNotify = "";
    },
    store() {
      this.showAddInput = false;
      this.incomeValidation = "";
      if (this.financeReq.desc && this.financeReq.amount) {
        axios
          .post("/api/finance/store", this.financeReq, this.$apiConfig())
          .then((r) => {
            this.financeReq.desc = "";
            this.financeReq.amount = "";
            this.incomeValidation = "";
            this.financeNotify = `${this.title} bertambah!`;
            this.$emit("changingData", this.financeType, this.calender.type);
          });
      } else {
        this.incomeValidation = "Kolom tidak boleh kosong";
      }
    },
    editFinance(finance) {
      this.financeReqEditId = finance.id;
    },
    updateFinance(finance) {
      this.financeReqEditId = "";
      axios
        .post("/api/finance/update", finance, this.$apiConfig())
        .then((r) => {
          this.financeNotify = "Satu data telah diubah!";
        });
    },
    destroyFinance(id) {
      axios
        .post("/api/finance/destroy", { id }, this.$apiConfig())
        .then((r) => {
          this.$emit("changingData", this.financeType, this.calender.type);
          this.$vs.notify({
            position: "bottom-left",
            title: `
            <div class="flex justify-between cursor-pointer">
              <span class='text-white  mr-4 '>Catatan dihapus, klik untuk</span>  <span class="text-yellow-400 font-bold">Urungkan</span>
            </div>
        `,
            color: "#000",
            click: () => {
              axios
                .post("/api/finance/delete/undo", { id }, this.$apiConfig())
                .then((r) => {
                  this.$emit(
                    "changingData",
                    this.financeType,
                    this.calender.type
                  );
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