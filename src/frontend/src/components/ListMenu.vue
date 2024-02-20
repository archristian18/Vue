<template>
  <ErrorToast ref="errorToast" />
  <v-form @submit.prevent="handleOrder" ref="form">
    <v-row>
      <v-col class="container_order" cols="4">
        <v-text-field
          label="Customer Name"
          hide-details="auto"
          variant="solo"
          v-model="formData.name"
          :error="!!errors.name"
          :error-messages="errors.name"
          :rules="textOnly"
          name="customer"
        ></v-text-field>
      </v-col>
      <v-col class="container_order" cols="4">
        <v-select
          label="DineIn / TakeOut"
          v-model="formData.status"
          :items="options"
          hide-details="auto"
          variant="solo"
          :rules="optionsValid"
          name="option"
        ></v-select>
      </v-col>
      <v-col class="create_buttton" align-self="center" cols="4">
        <v-btn type="submit" class="create_order" name="create">
          Create Order
        </v-btn>
      </v-col>
    </v-row>
    <v-row justify="space-around">
      <v-col outlined cols="4" v-for="(menuList, index) in list" :key="index">
        <v-sheet
          :elevation="4"
          :height="350"
          :width="350"
          style="margin: 20px; border-radius: 15px"
          rounded
        >
          <img :src="menuList.image_path" class="img" />
          <div style="float: left; margin-top: 50px; margin-left: 25px">
            <h2>
              <v-icon icon="mdi-currency-php" color="#010384" size="20" />
              {{ menuList.price }}
            </h2>
            <v-divider
              :thickness="2"
              class="border-opacity-20 divider"
              color="rgb(1, 3, 132)"
            ></v-divider>
            <div style="text-align: center">
              <h4 style="padding: 5px">Quantity</h4>
              <v-icon
                icon="mdi-arrow-left-circle"
                class="icon"
                color="#010384"
                @click="decrement(index)"
              />
              <h3
                style="
                  float: left;
                  align-self: center;
                  margin-left: 10px;
                  margin-right: 10px;
                "
              >
                <input
                  type="text"
                  v-model="formData.quantity[index]"
                  min="0"
                  class="quantity"
                  variant="primary"
                  @input="updateQuantity(index)"
                  readonly
                  name="quantity"
                />
              </h3>
              <v-icon
                icon="mdi-arrow-right-circle"
                class="icon"
                color="#010384"
                @click="increment(index)"
              />
            </div>
          </div>
          <v-col cols="12" style="float: left">
            <v-col class="title">{{ menuList.name }} </v-col>
            <v-divider
              :thickness="2"
              class="border-opacity-20"
              color="rgb(1, 3, 132)"
            ></v-divider>
            <v-col>
              <p>{{ menuList.description }}</p>
            </v-col>
          </v-col>
        </v-sheet>
      </v-col>
    </v-row>
  </v-form>
</template>
<script>
import {
  createCustomer,
  createOrderList,
  createReceipt,
} from "../services/menu.service";
import ErrorToast from "./atoms/ErrorToast.vue";

export default {
  name: "ListMenu",
  components: {
    ErrorToast,
  },
  props: {
    list: Array,
  },
  data() {
    return {
      formData: {
        menu_id: [],
        quantity: [],
        total_price: [],
        name: "",
        status: "",
      },
      options: ["DineIn", "TakeOut"],
      customer_id: "",
      errors: {},
      disabled: false,
    };
  },
  watch: {
    list(newList) {
      if (Array.isArray(newList)) {
        const length = newList.length;
        this.formData.menu_id = Array(length).fill(0);
        this.formData.total_price = Array(length).fill(0);
        this.formData.quantity = Array(length).fill(0);
      }
    },
  },
  computed: {
    textOnly() {
      return [
        (value) => !!value || "Required",
        (value) =>
          /^[a-zA-Z]+$/.test(value) || "Only text characters are allowed",
      ];
    },
    optionsValid() {
      return [(value) => !!value || "Required"];
    },
    testValid() {
      return this.formData.quantity.some((item) => item !== 0) || "Required";
    },
  },
  methods: {
    increment(index) {
      this.formData.quantity[index]++;
      this.updateQuantity(index);
    },
    decrement(index) {
      if (this.formData.quantity[index] > 0) {
        this.formData.quantity[index]--;
        this.updateQuantity(index);
      }
    },
    async handleOrder() {
      try {
        const isValid = await this.$refs.form.validate();
        const isNonZeroItem = this.formData.quantity.some((item) => item !== 0);

        if (!isValid.valid) {
          throw new Error("Please input required fields");
        }
        if (!isNonZeroItem) {
          throw new Error("Please add the quantity.");
        }
        const { name, status, menu_id, quantity, total_price } = this.formData;
        const customer = {
          name,
          status,
        };

        await createCustomer(customer).then((new_customer_orders) => {
          this.customer_id = new_customer_orders.id;
        });

        this.$refs.errorToast.showToastSuccess("Successfully Created!");

        const customer_id = this.customer_id;
        const order = {
          menu_id,
          quantity,
          total_price,
          customer_id,
        };
        const receipt = {
          customer_id,
        };

        await createOrderList(order);
        await createReceipt(receipt);
        this.$router.push({
          path: "/receipt",
          query: {
            id: customer_id,
          },
        });
      } catch (error) {
        this.$refs.errorToast.showToastError(error.message);
      }
    },

    updateQuantity(index) {
      if (this.formData.quantity[index] === "") {
        this.formData.quantity[index] = 0;
      }
      this.formData.menu_id[index] = this.list[index].id;
      this.formData.total_price[index] =
        this.list[index].price * this.formData.quantity[index];
    },
  },
};
</script>
<style scoped>
.quantity {
  width: 20px;
  text-align: center;
}
.img {
  float: left;
  width: 55%;
  height: 50%;
  margin-top: 15px;
  margin-left: 15px;
  object-fit: cover;
  border-radius: 100%;
}
.title {
  font-weight: 800;
  font-size: 18px;
  color: #010384;
  text-transform: uppercase;
}
.divider {
  margin-top: 10px;
}
.icon {
  float: left;
  color: #010384;
  size: 25;
}
.create_order {
  float: right;
  background-color: #010384;
  align-self: center;
  text-transform: uppercase;
  width: 80%;
}
.container_order {
  margin-top: 30px;
}
.create_buttton {
  margin-top: 30px;
}
</style>
