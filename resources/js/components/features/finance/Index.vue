<template>
  <main-component>
    <div class="grid xl:grid-cols-2 md:grid-cols-1 gap-4 ">
      <finance-card-component
        :financeDatas="incomes"
        financeType="1"
        title="UANG MASUK"
        v-on:changingData="setFinance"
        color="#38c172"
        v-on:sorting="sorting"
        v-on:pageChange="pageChange"
      ></finance-card-component>
      <finance-card-component
        :financeDatas="outcomes"
        financeType="2"
        title="UANG KELUAR"
        v-on:changingData="setFinance"
        color="#e3342f"
        v-on:sorting="sorting"
        v-on:pageChange="pageChange"
      ></finance-card-component>
    </div>

    <div class="grid grid-cols-2 gap-4 ">
      <chart-component
        chartId="s"
        key="s"
        label="['sds']"
        value="[12]"
      ></chart-component>
      <chart-component
        key="a"
        chartId="a"
        label="['sds']"
        value="[12]"
      ></chart-component>
    </div>
  </main-component>
</template>
<script>
import { directive as onClickaway } from "vue-clickaway";
import moment from "moment";
import MainComponent from "../../layouts/MainComponent.vue";
export default {
  components: { MainComponent },
  mounted() {
    this.sortingValue = moment(new Date()).format("YYYY-MM-DD");
    this.setFinance(1);
    this.setFinance(2);
  },

  data() {
    return {
      incomes: {},
      outcomes: {},
      sortingValue: "",
    };
  },
  methods: {
    getFinanceByType(
      type,
      sorting,
      sortingValue = moment(new Date()).format("YYYY-MM-DD"),
      page = 1
    ) {
      return axios
        .get(
          "/api/finance/getfinancebytype?type=" +
            type +
            "&sort=" +
            sorting +
            "&sortingValue=" +
            sortingValue +
            "&page=" +
            page,
          this.$apiConfig()
        )
        .then((r) => {
          return r.data;
        });
    },
    setFinance(type = 1, sort = "date") {
      if (sort == "week") {
        this.sortingValue = moment(new Date()).week().toString();
      }
      this.getFinanceByType(type, sort, this.sortingValue).then((r) => {
        if (type == 1) {
          this.incomes = r;
        } else if (type == 2) {
          this.outcomes = r;
        }
      });
    },
    sorting(type = 1, calender) {
      let calenderValue = calender.value;
      if (calender.type == "week") {
        calenderValue = calender.weekValue;
      }

      this.getFinanceByType(type, calender.type, calenderValue).then((r) => {
        if (type == 1) {
          this.incomes = r;
        } else if (type == 2) {
          this.outcomes = r;
        }

        if (calender.type == "month") {
          console.log(r);
        }
      });
    },
    pageChange(type = 1, page, calender) {
      let calenderValue = calender.value;
      if (calender.type == "week") {
        calenderValue = calender.weekValue;
      }

      this.getFinanceByType(type, calender.type, calenderValue, page).then(
        (r) => {
          if (type == 1) {
            this.incomes = r;
          } else if (type == 2) {
            this.outcomes = r;
          }
        }
      );
    },
  },
  directives: {
    onClickaway: onClickaway,
  },
};
</script>