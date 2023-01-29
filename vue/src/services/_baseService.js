import axios from "axios";
import store from "../store";

const service = axios.create({
    baseURL: import.meta.env.VITE_API_URL ?? "http://",
    headers: {
        "Content-Type": "application/json",
    },
});

service.interceptors.request.use((config) => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`;
    return config;
});

service.interceptors.response.use(
    function (response) {
        return response.data;
    },
    function (error) {
        console.error(error);
    }
);

export default service;
