const dev = {
    BASE_URL: 'http://localhost:8000/api',
    CHECKOUT_URL: 'http://localhost:3002',
    USERS_URL: 'http://localhost:8084/api',
}

const prod = {
    BASE_URL: '',
    CHECKOUT_URL: '',
    USERS_URL: ''
}

const config = process.env.NODE_ENV === 'development' ? dev : prod;

export default config;