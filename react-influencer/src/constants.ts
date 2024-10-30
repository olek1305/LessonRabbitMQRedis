const dev = {
    BASE_URL: 'http://127.0.0.1:8003/api/influencer',
    CHECKOUT_URL: 'http://localhost:3001',
}

const prod = {
    BASE_URL: '',
    CHECKOUT_URL: '',
}

const config = process.env.NODE_ENV === 'development' ? dev : prod;

export default config;