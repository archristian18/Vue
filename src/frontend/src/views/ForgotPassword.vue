<template>
  <ErrorToast ref="errorToast" />
  <v-container class="grey lighten-5 container">
    <v-row>
      <v-col class="ma-1">
        <h2 class="header">{{ t("labels.forgot_password") }}</h2>
        {{ t("pages.forgot_password.sub_heading") }}
      </v-col>
    </v-row>
    <v-form @submit.prevent="handleForgot" ref="form">
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="formData.email"
            :error="!!errors.email"
            :rules="emailRules"
            :error-messages="errors.email"
            :label="t('labels.email_address')"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row no-gutters>
        <v-col>
          <v-btn type="submit" class="button v-btn__content" outlined>{{
            t("labels.submit")
          }}</v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-container>
</template>

<script>
import { useI18n } from "vue-i18n";
import { forgotPassword } from "../services/password.service";
import ErrorToast from "../components/atoms/ErrorToast.vue";

export default {
  name: "SignUp",
  components: {
    ErrorToast,
  },
  data() {
    return {
      formData: {
        email: "",
      },
      errors: {},
    };
  },
  computed: {
    emailRules() {
      return [
        (value) => !!value || "Required.",
        (value) =>
          /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value) ||
          "Invalid email format",
        (value) => (value && value.length >= 3) || "Min 3 characters",
      ];
    },
  },
  methods: {
    async handleForgot() {
      try {
        const isValid = await this.$refs.form.validate();

        if (!isValid.valid) {
          throw new Error("Please input required fields");
        }
        const { email } = this.formData;

        await forgotPassword(email)
          .then(() => {
            this.$refs.errorToast.showToastSuccess("Successfully Login !");
            setTimeout(() => {
              this.$router.push("/login");
            }, 3500);
          })
          .catch(() => {
            this.$refs.errorToast.showToastError("Incorrect Email");
          });
      } catch (error) {
        this.$refs.errorToast.showToastError(error.message);
      }
    },
  },
  setup() {
    const { t } = useI18n();
    return {
      t,
    };
  },
};
</script>
<style scoped>
@import "../theme/style.css";
</style>
