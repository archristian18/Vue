import api from '../utils/api'

const login = async ({ ...props }) => {
    return await api
        .post('/oauth/token', {
            grant_type: 'password',
            client_id: process.env.REACT_APP_CLIENT_ID,
            client_secret: process.env.REACT_APP_CLIENT_SECRET,
            ...props,
        })
        .then(({ data }) => {
            const { access_token, refresh_token } = data
            localStorage.setItem('access_token', access_token)
            localStorage.setItem('refresh_token', refresh_token)
            return data
        })
}

export { login }
