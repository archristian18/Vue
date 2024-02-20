<template>
  <ErrorToast ref="errorToast" />
  <NavigationHeader />
  <NavigationFooter />
  <v-container class="modal">
    <v-card>
      <v-card>
        <v-card-title class="customer">
          Customer:
          {{ order_receipt && order_receipt[0] && order_receipt[0].name }}
        </v-card-title>
        <v-table height="200px" class="table">
          <thead>
            <tr class="table">
              <th class="text-left">Menu Name</th>
              <th class="text-left">Price</th>
              <th class="text-left">Quantity</th>
              <th class="text-left">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(order, index) in customer_order" :key="index">
              <td>{{ order.menu_name }}</td>
              <td>{{ order.price }}</td>
              <td>{{ order.quantity }}</td>
              <td>{{ order.total_price }}</td>
            </tr>
          </tbody>
        </v-table>
        <v-card-title class="customer">
          TOTAL RECEIPT =
          {{
            order_receipt && order_receipt[0] && order_receipt[0].total_payment
          }}
        </v-card-title>
      </v-card>
    </v-card>
  </v-container>
</template>

<script>
import NavigationHeader from "../components/NavigationHeader.vue";
import NavigationFooter from "../components/NavigationFooter.vue";
import { getOrder, getReceipt } from "../services/menu.service";
import ErrorToast from "../components/atoms/ErrorToast.vue";

export default {
  name: "ReceiptView",
  components: {
    NavigationHeader,
    NavigationFooter,
    ErrorToast,
  },
  data() {
    return {
      id: null,
      dialog: true,
      customer_order: [],
      order_receipt: [],
    };
  },
  async created() {
    this.id = this.$route.query.id;
    try {
      const [receipt, orders] = await Promise.all([
        getReceipt(this.id),
        getOrder(this.id),
      ])
        .then(([receipt, orders]) => {
          return [receipt, orders];
        })
        .catch(() => {
          this.$refs.errorToast.showToastError(
            "Content creation failed. Please retry your request."
          );
        });

      this.order_receipt = receipt;
      this.customer_order = orders;
    } catch (error) {
      this.$refs.errorToast.showToastError(error.message);
    }
  },
};
</script>

<style scoped>
.modal {
  margin-top: 20px;
  text-align: center;
  width: 50%;
}
.table {
  padding: 50px;
  text-align: left;
}
.customer {
  background-color: #010384;
  color: white;
}
</style>
