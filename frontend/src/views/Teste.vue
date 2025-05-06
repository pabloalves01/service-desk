<template>
  <div class="bg-blue-500">ESTOU LOGADO
    <Button label="Submit" />
    <Slider v-model="value" class="w-56" />

  </div>
</template>

<script>
import Button from "primevue/button"
import Slider from 'primevue/slider';

export default {
  data() {
    return {
      value: 0,
    };
  },
  components: {
    Button,
    Slider
  },
};
</script>