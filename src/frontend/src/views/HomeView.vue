<template>
    <OrderView />
    <NavigationHeader />
    <NavigationFooter />
</template>

<script>
import OrderView from '../components/OrderView.vue'
import NavigationHeader from '../components/NavigationHeader.vue'
import NavigationFooter from '../components/NavigationFooter.vue'

export default {
    name: 'HomeView',
    components: {
        OrderView,
        NavigationHeader,
        NavigationFooter,
    },
}
</script>
