<template>
  <div style="text-align: center">
    <h4 style="padding: 5px">Quantity</h4>
    <v-icon
      icon="mdi-arrow-left-circle"
      class="icon"
      color="#010384"
      @click="decrement()"
    />
    <h3
      style="
        float: left;
        align-self: center;
        margin-left: 10px;
        margin-right: 10px;
      "
    >
      {{ quantity }}
    </h3>
    <v-icon
      icon="mdi-arrow-right-circle"
      class="icon"
      color="#010384"
      @click="increment()"
    />
  </div>
</template>
<script>
export default {
  name: "InputNumber",
  data() {
    return {
      quantity: 0,
    };
  },
  methods: {
    increment() {
      this.quantity++;
      this.$emit("update:quantity", this.quantity);
    },
    decrement() {
      if (this.quantity > 0) {
        this.quantity--;
        this.$emit("update:quantity", this.quantity);
      }
    },
  },
};
</script>
<style>
.icon {
  float: left;
  color: #010384;
  size: 25;
}
</style>
