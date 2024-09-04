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
            files: [
                '**/__tests__/*.{j,t}s?(x)',
                '**/tests/unit/**/*.spec.{j,t}s?(x)',
            ],
            env: {
                jest: true,
            },
        },
    ],
}
