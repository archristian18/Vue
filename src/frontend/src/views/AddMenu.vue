<template>
    <ErrorToast ref="errorToast" />
    <NavigationHeader />
    <NavigationFooter />
    <v-container class="modal">
        <v-card>
            <v-card-title class="title">{{ formTitle }}</v-card-title>
            <v-form @submit.prevent="handleSubmit" class="form" ref="form">
                <v-row>
                    <v-col class="container_order" cols="6">
                        <v-text-field
                            label="Name"
                            hide-details="auto"
                            variant="solo"
                            placeholder="Enter menu name"
                            v-model="formData.menuName"
                            :rules="textOnly"
                            name="menu-name"
                        ></v-text-field>
                    </v-col>
                    <v-col class="container_order" cols="6">
                        <v-text-field
                            label="Price"
                            hide-details="auto"
                            variant="solo"
                            v-model="formData.menuPrice"
                            placeholder="Enter only number"
                            @input="validateAndSetPrice"
                            :rules="numberOnly"
                            name="price"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col class="container_order" cols="12">
                        <v-text-field
                            label="Description"
                            hide-details="auto"
                            variant="solo"
                            v-model="formData.menuDescription"
                            placeholder="Enter description"
                            class="custom-text-field"
                            :rules="descriptionRule"
                            name="description"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-file-input
                            variant="filled"
                            placeholder="Pick an avatar"
                            accept="image/png, image/jpeg, image/bmp"
                            prepend-icon="mdi-camera"
                            label="Image File"
                            v-model="formData.menuImage"
                            :rules="imageRule"
                            @change="handleFileChange"
                            name="image"
                        ></v-file-input>
                    </v-col>
                    <v-col cols="12" class="imgPreview">
                        <v-img
                            :width="250"
                            :height="150"
                            aspect-ratio="20/9"
                            cover
                            :src="formData.imageUrl"
                        ></v-img>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col align-self="center" cols="12">
                        <v-btn type="submit" class="button" name="submit">{{
                            buttonText
                        }}</v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </v-card>
    </v-container>
</template>

<script>
import NavigationHeader from '../components/NavigationHeader.vue'
import NavigationFooter from '../components/NavigationFooter.vue'
import { createMenu, getMenuById, updateMenu } from '../services/menu.service'
import ErrorToast from '../components/atoms/ErrorToast.vue'

export default {
    name: 'MenuForm',
    components: {
        ErrorToast,
        NavigationHeader,
        NavigationFooter,
    },
    props: {
        isEditing: Boolean,
        menuData: String,
    },
    data() {
        return {
            formData: {
                menuName: '',
                menuPrice: '',
                menuDescription: '',
                menuImage: [],
                imageUrl: '/imgpreview.png',
            },
        }
    },
    mounted() {
        if (this.isEditing) {
            this.loadMenuData()
        }
    },
    computed: {
        textOnly() {
            return [
                (value) => !!value || 'Required',
                (value) =>
                    /^[a-zA-Z\s]+$/.test(value) ||
                    'Only text characters and spaces are allowed',
            ]
        },
        numberOnly() {
            return [
                (value) =>
                    (!!value || 'Required') &&
                    (/^[0-9]+(\.[0-9]+)?$/.test(value) ||
                        'Only numbers or float numbers are allowed'),
            ]
        },
        descriptionRule() {
            return [(value) => !!value || 'Required']
        },
        imageRule() {
            return [(value) => !!value || 'Required']
        },
        formTitle() {
            return this.isEditing ? 'EDIT MENU' : 'ADD MENU'
        },
        buttonText() {
            return this.isEditing ? 'Save Changes' : 'Create Menu'
        },
    },
    methods: {
        async loadMenuData() {
            try {
                const result = await getMenuById(this.menuData)
                this.menuList = result
                this.populateFormData(result)
            } catch (error) {
                this.handleLoadError(error)
            }
        },

        populateFormData(menuData) {
            this.formData.id = this.menuData
            this.formData.menuName = menuData.name
            this.formData.menuPrice = menuData.price
            this.formData.menuDescription = menuData.description
            this.formData.menuImage = menuData.menuImage
            this.formData.imageUrl = `http://vue.local/api/${menuData.image_path}`
        },

        handleLoadError(error) {
            throw new Error(error.message)
        },

        handleFileChange() {
            if (this.formData.menuImage.length > 0) {
                const selectedFile = this.formData.menuImage[0]
                const reader = new FileReader()

                reader.onload = () => {
                    this.formData.imageUrl = reader.result
                }

                reader.readAsDataURL(selectedFile)
            } else {
                this.formData.imageUrl = '/imgpreview.png'
            }
        },
        validateAndSetPrice() {
            this.formData.menuPrice = this.formData.menuPrice.replace(
                /[^0-9.]/g,
                '',
            )
        },
        async handleSubmit() {
            // try {
            const isValid = await this.$refs.form.validate()

            if (!isValid.valid) {
                throw new Error('Please input required fields')
            }
            const formData = {
                id: this.menuData,
                name: this.formData.menuName,
                price: this.formData.menuPrice,
                description: this.formData.menuDescription,
                image_path:
                    this.formData.menuImage === undefined ||
                    this.formData.menuImage === null
                        ? null
                        : this.formData.menuImage[0],
            }

            if (this.isEditing) {
                await updateMenu(formData)
                    .then(() => {
                        this.$refs.errorToast.showToastSuccess(
                            'Successfully Created !',
                        )
                        setTimeout(() => {
                            this.$router.push('/menu/table')
                        }, 3500)
                    })
                    .catch(() => {
                        this.$refs.errorToast.showToastError(
                            'There are errors in your submission. Please correct them and try again.',
                        )
                    })
            } else {
                await createMenu(formData)
                    .then(() => {
                        this.$refs.errorToast.showToastSuccess(
                            'Successfully Created !',
                        )
                        setTimeout(() => {
                            this.$router.push('/menu/table')
                        }, 3500)
                    })
                    .catch(() => {
                        this.$refs.errorToast.showToastError(
                            'There are errors in your submission. Please correct them and try again.',
                        )
                    })
            }
        },
    },
}
</script>

<style scoped>
.modal {
    margin-top: 20px;
    text-align: center;
    width: 50%;
}
.title {
    background-color: #010384;
    color: white;
}
.form {
    margin: 50px;
}
.button {
    background-color: #010384;
    align-self: center;
    text-transform: uppercase;
    width: 100%;
}
.imgPreview {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
}
</style>
