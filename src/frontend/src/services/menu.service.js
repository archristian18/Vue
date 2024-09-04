import api from '../utils/api'

const getMenu = async () => {
    const req = api.get('order/menu/').then(({ data }) => data.data)
    return await req
}

const createCustomer = async (customer_orders) => {
    const req = api
        .post('customer/order/', customer_orders)
        .then(({ data }) => data.data)
    return await req
}

const createOrderList = async (data) => {
    const req = api.post('order/list', data).then(({ data }) => data)
    return await req
}

const getCustomer = async (data) => {
    const req = api.get('customer/list', data).then(({ data }) => data.data)
    return await req
}

const getOrder = async (data) => {
    const req = api.get('order/receipt/' + data).then(({ data }) => data.data)
    return await req
}

const createReceipt = async (data) => {
    const req = api.post('receipt/', data).then(({ data }) => data.data)
    return await req
}

const getReceipt = async (data) => {
    const req = api.get('receipt/' + data).then(({ data }) => data.data)
    return await req
}

const createMenu = async (data) => {
    const req = api.post('order/menu/add', data, {
        headers: {
            'Content-Type': 'multipart/form-data', // Set the content type to multipart/form-data for file uploads
        },
    })
    return await req
}

const getMenuById = async (data) => {
    const req = api.get('order/menu' + data).then(({ data }) => data.data)
    return await req
}

const deleteMenu = async (data) => {
    const req = api.delete('order/menu/' + data).then(({ data }) => data)
    return await req
}

const getAllOrder = async () => {
    const req = api.get('receipt/').then(({ data }) => data.data)
    return await req
}

const deleteOrder = async (data) => {
    const req = api.delete('customer/' + data).then(({ data }) => data)
    return await req
}

const updateMenu = async (data) => {
    const req = api.post('order/menu', data, {
        headers: {
            'Content-Type': 'multipart/form-data', // Set the content type to multipart/form-data for file uploads
        },
    })
    return await req
}

export {
    updateMenu,
    deleteOrder,
    getAllOrder,
    deleteMenu,
    getMenuById,
    getMenu,
    createMenu,
    createCustomer,
    createOrderList,
    getCustomer,
    getOrder,
    createReceipt,
    getReceipt,
}
