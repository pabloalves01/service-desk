<template>
  <div class="text-white p-4 rounded-lg border">
    <h2 class="text-lg font-semibold mb-4">Crypto Analytics</h2>
    <Chart type="bar" :data="chartData" :options="chartOptions" class="h-[30rem]" />

  </div>
  <div class="mt-4">
    <Button label="Submit" />
    <Slider v-model="value" class="w-56" />
  </div>
</template>

<script>
import Chart from 'primevue/chart';
import Button from "primevue/button";
import Slider from 'primevue/slider';

export default {
  data() {
    return {
      value: 0,
      chartData: {
        labels: [
          'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
          'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ],
        datasets: [
          {
            label: 'Personal Wallet',
            backgroundColor: '#94a3b8', // slate-400
            data: [3000, 5000, 7000, 2000, 5000, 3000, 6000, 8000, 7000, 5000, 7000, 4000],
            barPercentage: 1,
            categoryPercentage: 0.5
          },
          {
            label: 'Corporate Wallet',
            backgroundColor: '#cbd5e1', // slate-300
            data: [4000, 7000, 9000, 5000, 6000, 7000, 9000, 10000, 9500, 9000, 9500, 6000],
            barPercentage: 1,
            categoryPercentage: 0.5
          },
          {
            label: 'Investment Wallet',
            backgroundColor: '#e2e8f0', // slate-200
            data: [3000, 8000, 4000, 5000, 5000, 6000, 8000, 11000, 9500, 8000, 9500, 5000],
            borderRadius: {
              topLeft: 10,
              topRight: 10,
              bottomLeft: 0,
              bottomRight: 0
            },
            barPercentage: 1,
            categoryPercentage: 0.5
          }
        ]
      },
      chartOptions: {
        plugins: {
          legend: {
            labels: {
              color: '#ffffff'
            }
          }
        },
        responsive: true,
        scales: {
          x: {
            stacked: true,
            ticks: {
              color: '#ffffff'
            },
            grid: {
              color: 'rgba(255,255,255,0.1)'
            }
          },
          y: {
            stacked: true,
            ticks: {
              color: '#ffffff'
            },
            grid: {
              color: 'rgba(255,255,255,0.1)'
            }
          }
        }
      }
    };
  },
  components: {
    Button,
    Slider,
    Chart
  }
};
</script>
