<template>
    <ErrorToast ref="errorToast" />
    <NavigationHeader />
    <NavigationFooter />
    <v-container class="grey lighten-5 container">
        <v-row>
            <v-col cols="4">
                <v-card-title class="menu">
                    <v-text-field
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        hide-details="auto"
                        variant="solo"
                        v-model="search"
                    ></v-text-field>
                </v-card-title>
            </v-col>
            <v-col cols="6"></v-col>
            <v-col cols="2" class="add" align-self="center">
                <h3>
                    Add Menu
                    <v-icon
                        icon="mdi-plus-box"
                        color="#010384"
                        size="40"
                        @click="redirectToAddMenu"
                    />
                </h3>
            </v-col>
        </v-row>
        <v-table height="300px">
            <thead>
                <tr>
                    <th class="text-left">Id</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Price</th>
                    <th class="text-left">Decription</th>
                    <th class="text-left">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list, index) in filtered" :key="index">
                    <td>{{ list.id }}</td>
                    <td>{{ list.name }}</td>
                    <td>{{ list.price }}</td>
                    <td class="truncate-cell">{{ list.description }}</td>
                    <td>
                        <v-icon
                            class="icon-button"
                            icon="mdi-pencil"
                            color="#010384"
                            size="25"
                            @click="redirectToEditMenu(list)"
                        />
                        <v-icon
                            class="icon-button"
                            icon="mdi-delete"
                            color="red"
                            size="25"
                            @click="redirectToDelete(list.id)"
                        />
                    </td>
                </tr>
            </tbody>
        </v-table>
    </v-container>
</template>

<script>
import NavigationHeader from '../components/NavigationHeader.vue'
import NavigationFooter from '../components/NavigationFooter.vue'
import { getMenu, deleteMenu } from '../services/menu.service'
import ErrorToast from '../components/atoms/ErrorToast.vue'

export default {
    name: 'OrderTable',
    components: {
        NavigationHeader,
        NavigationFooter,
        ErrorToast,
    },
    data() {
        getMenu().then((result) => {
            this.menuList = result
        })
        return {
            search: '',
            menuList: [],
            isEditing: false,
            menuData: null,
        }
    },
    computed: {
        filtered: function () {
            return this.menuList.filter((list) => {
                const search = this.search.toLowerCase()
                const nameMatch = list.name.toLowerCase().includes(search)
                const descriptionMatch = list.description
                    .toLowerCase()
                    .includes(search)
                const priceMatch = list.price.toString().includes(search)
                const idMatch = list.id.toString().includes(search)

                return nameMatch || descriptionMatch || priceMatch || idMatch
            })
        },
    },
    methods: {
        redirectToAddMenu() {
            this.$router.push({
                path: '/menu/add',
                query: { isEditing: false },
            })
        },
        redirectToEditMenu(list) {
            const id = list.id
            this.$router.push({
                path: '/menu/add',
                query: { isEditing: true, menuData: id },
            })
        },
        async redirectToDelete(id) {
            try {
                await deleteMenu(id)
                // Find the index of the menu in the menuList array
                const index = this.menuList.findIndex((menu) => menu.id === id)
                // Remove the menu from the array
                this.menuList.splice(index, 1)

                this.$refs.errorToast.showToastSuccess(
                    'The menu has been successfully deleted.',
                )

                // Optionally, you can redirect after a delay
                setTimeout(() => {
                    this.$router.push('/menu/table')
                }, 3500)
            } catch (error) {
                this.$refs.errorToast.showToastError(
                    'Sorry, we encountered an issue while trying to delete the content. Please try again later.',
                )
            }
        },
    },
}
</script>
<style scoped>
.container {
    width: 100%;
    text-align: left;
}

.menu {
    margin-bottom: 10px;
}
.add {
    margin-bottom: 25px;
    padding-left: 35px;
    position: center;
}
.truncate-cell {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 350px; /* Adjust this width as needed */
}
.icon-button {
    margin-left: 10px;
}
</style>
