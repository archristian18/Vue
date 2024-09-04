# imageapp

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Run your unit tests
```
npm run test:unit
```

### Run your end-to-end tests
```
npm run test:e2e
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).


### SETUP
vue create foodapp
vue add vuetify (Vuetify 3 - Vue CLI (preview))

### PACKAGES
npm install

npm i vue-axios

npm install vuetify

npm install vue-i18n

npm install --save vue3-toastify

npm install dotenv-webpack --save-dev

npm install webpack --save-dev

npm i bootstrap


### ERROR PRETTIER

1. npm uninstall prettier eslint-plugin-prettier
2. npm install prettier@^3.0.0 eslint-plugin-prettier@^5.0.0 --save-dev
3. npm list prettier
4. npm list eslint-plugin-prettier
5. Create eslint (.eslintrc.js)
6. npm run lint -- --fix
7. npm list prettier
8. npm list eslint-plugin-prettier
# Create eslint (.eslintrc.js)
// .eslintrc.js
module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    'plugin:vue/vue3-essential',
    'eslint:recommended',
    'plugin:prettier/recommended', // Ensures eslint-plugin-prettier and eslint-config-prettier are used
  ],
  parserOptions: {
    parser: '@babel/eslint-parser',
  },
  rules: {
    'prettier/prettier': [
      'error',
      {
        singleQuote: true,
        semi: false,
      },
    ],
  },
  overrides: [
    {
      files: ['**/__tests__/*.{j,t}s?(x)', '**/tests/unit/**/*.spec.{j,t}s?(x)'],
      env: {
        jest: true,
      },
    },
  ],
}

# 
npm update
