<template>
  <ErrorToast ref="errorToast" />
  <v-container class="grey lighten-5 container">
    <v-row>
      <v-col class="ma-2">
        <h2 class="header">{{ t("pages.activate.heading") }}</h2>
        {{ t("pages.activate.subtitle") }}
      </v-col>
    </v-row>
    <v-form @submit.prevent="handleActivate" ref="form">
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="formData.password"
            :label="t('labels.new_password')"
            :rules="passwordRules"
            hide-details="auto"
            name="password"
            type="password"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-text-field
            v-model="formData.password_confirmation"
            :label="t('labels.confirm_new_password')"
            :rules="passwordRules"
            hide-details="auto"
            name="password_confirmation"
            type="password"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col col="12">
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
import { createPassword } from "../services/password.service";
import ErrorToast from "../components/atoms/ErrorToast.vue";

export default {
  name: "UserActivation",
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
    // Validation rules for the username field
    passwordRules() {
      return [
        (value) => !!value || "Required.",
        (value) => (value && value.length >= 8) || "Min 8 characters",
        (value) =>
          /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]+$/.test(
            value
          ) || "Must contain 1 uppercase letter and 1 special character",
      ];
    },
  },
  methods: {
    async handleActivate() {
      try {
        const queryParams = new URLSearchParams(window.location.search);
        const token = queryParams.get("token");
        const { password, password_confirmation } = this.formData;

        const isValid = await this.$refs.form.validate();

        if (!isValid.valid) {
          throw new Error("Please input required fields");
        }

        await createPassword(token, password, password_confirmation)
          .then(() => {
            this.$refs.errorToast.showToastSuccess("Successfully Created !");
            setTimeout(() => {
              this.$router.push("/login");
            }, 3500);
          })
          .catch(() => {
            this.$refs.errorToast.showToastError(
              "The passwords you entered do not match. Please make sure they are the same."
            );
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
