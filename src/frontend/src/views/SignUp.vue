<template>
    <ErrorToast ref="errorToast" />
    <v-container class="grey lighten-5 container">
        <v-row>
            <v-col>
                <h2 class="header">
                    {{ t('pages.signup.create_free_account') }}
                </h2>
            </v-col>
        </v-row>
        <v-form @submit.prevent="handleSignUp" ref="form">
            <v-row>
                <v-col cols="12" sm="6">
                    <v-text-field
                        v-model="formData.first_name"
                        :error="!!errors.first_name"
                        :error-messages="errors.first_name"
                        :rules="textOnly"
                        :label="t('labels.first_name')"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-text-field
                        v-model="formData.last_name"
                        :error="!!errors.last_name"
                        :error-messages="errors.last_name"
                        :rules="textOnly"
                        :label="t('labels.last_name')"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="12">
                    <v-text-field
                        v-model="formData.email"
                        :error="!!errors.email"
                        :rules="emailRules"
                        :error-messages="errors.email"
                        :label="t('labels.email_address')"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-checkbox
                        v-model="formData.accept_terms"
                        :rules="acceptTerms"
                        :error="!!errors.accept_terms"
                        :label="`${t('pages.signup.agree_to_terms')} ${t(
                            'pages.signup.terms_conditions',
                        )}`"
                        style="font-size: 15px"
                    ></v-checkbox>
                </v-col>
            </v-row>
            <v-row>
                <v-col col="12">
                    <v-btn
                        type="submit"
                        class="button v-btn__content"
                        :disabled="disabled"
                        :color="disabled ? 'grey' : '#010384'"
                        >{{ t('labels.signup') }}</v-btn
                    >
                </v-col>
            </v-row>
        </v-form>
    </v-container>
</template>

<script>
import { useI18n } from 'vue-i18n'
import { createRegister } from '../services/register.service'
import ErrorToast from '../components/atoms/ErrorToast.vue'
import 'vue3-toastify/dist/index.css'

export default {
    name: 'SignUp',
    components: {
        ErrorToast,
    },
    data() {
        return {
            formData: {
                first_name: '',
                last_name: '',
                email: '',
                accept_terms: false,
            },
            errors: {},
            disabled: false,
        }
    },
    computed: {
        textOnly() {
            return [
                (value) => !!value || 'Required',
                (value) =>
                    /^[a-zA-Z]+$/.test(value) ||
                    'Only text characters are allowed',
            ]
        },
        emailRules() {
            return [
                (value) => !!value || 'Required.',
                (value) =>
                    /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(
                        value,
                    ) || 'Invalid email format',
                (value) => (value && value.length >= 3) || 'Min 3 characters',
            ]
        },
        acceptTerms() {
            return [(value) => !!value || 'Required.']
        },
    },
    methods: {
        async handleSignUp() {
            try {
                const isValid = await this.$refs.form.validate()

                if (!isValid.valid) {
                    throw new Error('Please input required fields')
                }

                const { first_name, last_name, email, accept_terms } =
                    this.formData
                const formData = {
                    first_name,
                    last_name,
                    email,
                    accept_terms,
                }
                await createRegister(formData)
                    .then(() => {
                        this.disabled = true
                        setTimeout(() => {
                            this.$router.push('/login')
                        })
                    })
                    .catch(() => {
                        this.$refs.errorToast.showToastError(
                            'Please already exist',
                        )
                    })
            } catch (error) {
                this.$refs.errorToast.showToastError(error.message)
            }
        },
    },
    setup() {
        const { t } = useI18n()
        return {
            t,
        }
    },
}
</script>
<style scoped>
@import '../theme/style.css';
</style>
