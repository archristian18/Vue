const { defineConfig } = require("@vue/cli-service");
const webpack = require("webpack");
module.exports = defineConfig({
  transpileDependencies: true,

  pluginOptions: {
    vuetify: {
      //
    },
  },

  devServer: {
    allowedHosts: "all",
    port: 3000,
    client: {
      webSocketTransport: "ws",
    },
    webSocketServer: "ws",
  },
  configureWebpack: {
    plugins: [
      // new Dotenv()
      new webpack.DefinePlugin({
        "process.env.REACT_APP_API_URL": JSON.stringify(
          process.env.REACT_APP_API_URL
        ),
        "process.env.REACT_BASE_URL": JSON.stringify(
          process.env.REACT_BASE_URL
        ),
        "process.env.REACT_APP_CLIENT_ID": JSON.stringify(
          process.env.REACT_APP_CLIENT_ID
        ),
        "process.env.REACT_APP_CLIENT_SECRET": JSON.stringify(
          process.env.REACT_APP_CLIENT_SECRET
        ),
      }),
      new webpack.DefinePlugin({
        __VUE_I18N_FULL_INSTALL__: true, // Replace with your actual flag value
        __VUE_I18N_LEGACY_API__: false, // Replace with your actual flag value
      }),
    ],
  },
});
