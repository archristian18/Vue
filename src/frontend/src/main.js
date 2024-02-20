import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import vuetify from "./plugins/vuetify";
import { createI18n } from "vue-i18n";
import { loadFonts } from "./plugins/webfontloader";
import en from "@/localization/en";
import ja from "@/localization/ja";

const i18n = createI18n({
  legacy: false,
  locale: "en",
  fallbackLocale: "en",
  messages: {
    en: en,
    ja: ja,
  },
});

const app = createApp(App);
app.use(router);
app.use(vuetify);
app.use(i18n);
app.mount("#app");

loadFonts();
