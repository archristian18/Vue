<template>
  <v-bottom-navigation :value="value" color="green" grow height="40">
    <div class="footer-content">
      <h3 style="color: #00025f">Arc Burgers © 2023</h3>
    </div>
  </v-bottom-navigation>
</template>

<style>
.footer-content {
  position: absolute;
  left: 0;
  right: 0;
  text-align: center;
  top: 50%;
  transform: translateY(-50%);
}
</style>

<script>
export default {
  name: "NavigationFooter",

  data: () => ({ value: 1 }),
};
</script>
