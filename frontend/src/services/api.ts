import axios, { AxiosResponse, AxiosInstance, InternalAxiosRequestConfig } from 'axios';

interface ApiErrorResponse {
    message: string;
    errors?: { [key: string]: string[] | string };
}

const Api: AxiosInstance = axios.create({
    baseURL: process.env.VUE_APP_API_URL,
    timeout: 10000,
    withCredentials: true,
    headers: {
        Accept: 'application/json',
    },
});

export type ApiPromise<T> = Promise<AxiosResponse<T>>;

export class ApiError extends Error {
    errors;

    constructor(error: ApiErrorResponse) {
        super(error.message);

        this.errors = error.errors;
    }
}

Api.interceptors.request.use(
    (config: InternalAxiosRequestConfig) => {
        return config;
    },
    (error) => {
        console.log(error);
        return Promise.reject(error);
    }
);

Api.interceptors.response.use(
    (response: AxiosResponse) => response,
    (error) => {
        if (axios.isAxiosError(error) && error.response) {
            if (error.status === 401) {
                //todo: logout user
            }

            if (error.response.data) {
                return Promise.reject(new ApiError(error.response.data));
            }
        }

        return Promise.reject(error);
    }
);

export default Api;
