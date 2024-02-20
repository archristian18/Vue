<template>
  <ErrorToast ref="errorToast" />
  <v-container class="grey lighten-5 container">
    <v-row>
      <v-col>
        <h2 class="header">{{ t("menu.login") }}</h2>
      </v-col>
    </v-row>
    <v-form @submit.prevent="handleLogin" ref="form">
      <v-row>
        <v-col no-gutters>
          <v-text-field
            v-model="formData.username"
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
          <v-text-field
            v-model="formData.password"
            :error="!!errors.password"
            :rules="passwordRules"
            :error-messages="errors.password"
            :label="t('labels.password')"
            hide-details="auto"
            name="password"
            type="password"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-btn type="submit" class="button" outlined @click="handleLogin">{{
            t("labels.login")
          }}</v-btn>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-btn @click="signUpToRoute" class="button" outlined color="blue">{{
            t("labels.signup")
          }}</v-btn>
        </v-col>
      </v-row>
    </v-form>
    <v-row no-gutters>
      <v-col>
        <a href="#" class="create" @click="passwordToRoute">Forget Password?</a>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { useI18n } from "vue-i18n";
import { login } from "../hook/useAuth";
import ErrorToast from "../components/atoms/ErrorToast.vue";

export default {
  name: "LoginView",
  components: {
    ErrorToast,
  },
  data() {
    return {
      formData: {
        email: "",
        password: "",
      },
      errors: {},
      data: true,
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

    passwordRules() {
      return [
        (value) => !!value || "Required.",
        (value) => (value && value.length >= 8) || "Min 8 characters",
      ];
    },
  },
  methods: {
    async handleLogin() {
      try {
        const isValid = await this.$refs.form.validate();

        if (!isValid.valid) {
          throw new Error("Please input required fields");
        }

        const { username, password } = this.formData;
        await login({ username, password })
          .then(() => {
            this.data = true;
            setTimeout(() => {
              this.$router.push("/home");
            }, 1000);
          })
          .catch(() => {
            this.$refs.errorToast.showToastError(
              "Incorrect Username or Password"
            );
          });
      } catch (error) {
        this.$refs.errorToast.showToastError(error.message);
      }
      // this.data &&
      //   this.$refs.errorToast.showToastSuccess("Successfully Login !");
    },
    signUpToRoute() {
      this.$router.push("/signup");
    },
    passwordToRoute() {
      this.$router.push("/forgot-password");
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
.create {
  color: skyblue;
  font-size: 10px;
}
</style>
