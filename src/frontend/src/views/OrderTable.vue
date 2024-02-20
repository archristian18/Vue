<template>
  <ErrorToast ref="errorToast" />
  <NavigationHeader />
  <NavigationFooter />
  <v-container class="grey lighten-5 container">
    <v-row>
      <v-col cols="12">
        <v-card-title class="menu">
          <v-text-field
            label="Search"
            append-inner-icon="mdi-magnify"
            hide-details="auto"
            variant="solo"
            v-model="search"
          ></v-text-field>
        </v-card-title>
      </v-col>
    </v-row>
    <v-table height="300px">
      <thead>
        <tr>
          <th class="text-left">Id</th>
          <th class="text-left">Customer Name</th>
          <th class="text-left">Total Price</th>
          <th class="text-left">Status</th>
          <th class="text-left">Option</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(list, index) in filtered" :key="index">
          <td>{{ list.id }}</td>
          <td>{{ list.name }}</td>
          <td>{{ list.total_payment }}</td>
          <td>{{ list.status }}</td>
          <td>
            <v-icon
              class="icon-button"
              icon="mdi-delete"
              color="red"
              size="25"
              @click="redirectToDelete(list.id)"
            />
          </td>
        </tr>
      </tbody>
    </v-table>
  </v-container>
</template>

<script>
import NavigationHeader from "../components/NavigationHeader.vue";
import NavigationFooter from "../components/NavigationFooter.vue";
import { getAllOrder, deleteOrder } from "../services/menu.service";
import ErrorToast from "../components/atoms/ErrorToast.vue";

export default {
  name: "OrderTable",
  components: {
    NavigationHeader,
    NavigationFooter,
    ErrorToast,
  },
  data() {
    getAllOrder().then((result) => {
      this.orderList = result;
    });
    return {
      search: "",
      orderList: [],
    };
  },
  computed: {
    filtered: function () {
      return this.orderList.filter((list) => {
        const search = this.search.toLowerCase();
        const nameMatch = list.name.toLowerCase().includes(search);
        const statusMatch = list.status.toLowerCase().includes(search);
        const total_paymentMatch = list.total_payment
          .toString()
          .toLowerCase()
          .includes(search);
        const idMatch = list.id.toString().includes(search);
        return nameMatch || statusMatch || total_paymentMatch || idMatch;
      });
    },
  },
  methods: {
    async redirectToDelete(id) {
      try {
        await deleteOrder(id);
        // Find the index of the order in the orderList array
        const index = this.orderList.findIndex((order) => order.id === id);
        // Remove the order from the array
        this.orderList.splice(index, 1);

        this.$refs.errorToast.showToastSuccess(
          "The customer order has been successfully deleted."
        );

        // Optionally, you can redirect after a delay
        setTimeout(() => {
          this.$router.push("/order/table");
        }, 3500);
      } catch (error) {
        this.$refs.errorToast.showToastError(
          "There are errors in your submission. Please correct them and try again."
        );
      }
    },
  },
};
</script>
<style scoped>
.container {
  width: 100%;
  text-align: left;
}
.menu {
  margin-bottom: 25px;
}
.icon-button {
  margin-left: 10px;
}
</style>
