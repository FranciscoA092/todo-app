import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:5174/api',
  headers: {
    Accept: 'application/json',
  },
})

export default api
