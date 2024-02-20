<template>
  <v-container>
    <ListMenu :list="menuList" />
  </v-container>
</template>

<script>
import ListMenu from "../components/ListMenu";
import { getMenu } from "../services/menu.service";

export default {
  name: "OrderView",
  components: {
    ListMenu,
  },
  data() {
    getMenu().then((result) => {
      this.menuList = result;
    });
    return {
      menuList: [],
    };
  },
};
</script>
