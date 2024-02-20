<template>
  <v-app-bar class="nav-wrapper">
    <v-toolbar-title>
      <img class="logo" :src="images" />
      <div class="logo-design">Burgers</div>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn
      text
      :style="isHome() && { backgroundColor: '#2b00b5' }"
      @click="redirecToHome"
    >
      Customer Order
    </v-btn>
    <v-btn
      text
      :style="isMenu() && { backgroundColor: '#2b00b5' }"
      @click="redirectToMenuList"
    >
      Menu List
    </v-btn>
    <v-btn
      text
      :style="isOrder() && { backgroundColor: '#2b00b5' }"
      @click="redirectToOrderList"
    >
      Order List
    </v-btn>
    <v-btn text @click="redirectToLogout"> LOGOUT </v-btn>
  </v-app-bar>
</template>

<script>
import logo from "../assets/burgerLogo.png";

export default {
  name: "NavigationHeader",
  data() {
    return {
      drawer: false,
      images: logo,
    };
  },
  methods: {
    redirecToHome() {
      this.$router.push("/home");
    },
    redirectToMenuList() {
      this.$router.push("/menu/table");
    },
    redirectToOrderList() {
      this.$router.push("/order/table");
    },
    redirectToLogout() {
      this.$router.push("/login");
    },
    isHome() {
      return this.$route.path === "/home";
    },
    isMenu() {
      return this.$route.path === "/menu/table";
    },
    isOrder() {
      return this.$route.path === "/order/table";
    },
  },
};
</script>

<style scoped>
.nav-wrapper {
  background-color: #010384;
  color: white;
}
.logo {
  padding-right: 10px;
  float: left;
  width: 55px;
  height: 50px;
}
.logo-design {
  padding-top: 12px;
  font-size: 30px;
  /* padding: 15px; */
  font-family: "Rockwell";
  vertical-align: text-bottom;
}
</style>
