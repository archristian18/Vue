// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import { fa } from 'vuetify/iconsets/fa'
import { mdi } from 'vuetify/iconsets/mdi'
// Vuetify

export default createVuetify({
    defaultSet: 'fa',
    sets: {
        fa,
        mdi,
    },
})
