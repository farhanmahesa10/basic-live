<template>
  <div class="mt-2  text-center">
    <i
      :class="chartActivity.showIcon"
      class=" text-gray-500 cursor-pointer"
      @click="chartToggle"
    > </i> <span class="text-gray-500"><i>{{chartActivity.showText}}</i></span>
    <div
      id="canvas"
      v-show="chartActivity.show"
    >

    </div>

  </div>
</template>
<script>
import Chart from "chart.js/auto";

export default {
  props: ["chartId", "label", "value"],
  mounted() {
    document.getElementById(
      "canvas"
    ).innerHTML = `<canvas id="${this.chartId}"></canvas>`;
    const labels = this.label;
    console.log(this.chartId);
    const data = {
      labels: labels,
      datasets: [
        {
          label: "Uang Masuk",
          backgroundColor: "rgb(56, 193, 114)",
          borderColor: "rgb(56, 193, 114)",
          data: this.value,
        },
      ],
    };
    const config = {
      type: "line",
      data: data,
      options: {
        scales: {
          y: {
            grid: {
              color: "rgba(0, 0, 0, 0)",
            },
          },
          x: {
            grid: {
              color: "rgba(0, 0, 0, 0)",
            },
          },
        },
      },
    };
    var myChart = new Chart(document.getElementById(this.chartId), config);
  },
  data() {
    return {
      chartActivity: {
        show: true,
        showText: "Hide chart",
        showIcon: "fa fa-eye-slash",
      },
    };
  },
  methods: {
    chartToggle() {
      if (this.chartActivity.show) {
        this.chartActivity.show = false;
        this.chartActivity.showText = "Show chart";
        this.chartActivity.showIcon = "fa fa-eye";
      } else {
        this.chartActivity.show = true;
        this.chartActivity.showText = "Hide chart";
        this.chartActivity.showIcon = "fa fa-eye-slash";
      }
    },
  },
};
</script>