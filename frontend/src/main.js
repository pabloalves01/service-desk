import "./assets/main.css";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router/routes.js";
import PrimeVue from "primevue/config";
import "primeicons/primeicons.css";
import Aura from "@primeuix/themes/aura";
import Breadcrumb from "./components/comum/breadcrumb/breacrumb.vue";
import globals from "./globals";
const app = createApp(App);

app.config.globalProperties.$globals = globals;

app.use(router);
app.component("Breadcrumb", Breadcrumb);
app.use(PrimeVue, {
  theme: {
    preset: Aura,
  },
  locale: {
    firstDayOfWeek: 0,
    dayNames: [
      "domingo",
      "segunda-feira",
      "terça-feira",
      "quarta-feira",
      "quinta-feira",
      "sexta-feira",
      "sábado",
    ],
    dayNamesShort: ["dom", "seg", "ter", "qua", "qui", "sex", "sáb"],
    dayNamesMin: ["D", "S", "T", "Q", "Q", "S", "S"],
    monthNames: [
      "janeiro",
      "fevereiro",
      "março",
      "abril",
      "maio",
      "junho",
      "julho",
      "agosto",
      "setembro",
      "outubro",
      "novembro",
      "dezembro",
    ],
    monthNamesShort: [
      "jan",
      "fev",
      "mar",
      "abr",
      "mai",
      "jun",
      "jul",
      "ago",
      "set",
      "out",
      "nov",
      "dez",
    ],
    today: "Hoje",
    clear: "Limpar",
    dateFormat: "dd/mm/yy",
    weekHeader: "Sem",
    firstDayOfWeek: 1,
    showMonthAfterYear: false,
    yearSuffix: "",
  },
});
app.mount("#app");
