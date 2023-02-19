import api from '@/services/api';

interface AuthenticationRequest {
    email: string;
    password: string;
    remember?: boolean;
}

export const authenticate = (data: AuthenticationRequest): void => {
    api.get('/sanctum/csrf-cookie', {
        baseURL: process.env.VUE_APP_API_ENDPOINT,
    }).then((response) => {
        console.log('sanctum response ', response);
        api.post('/auth/login', data);
    });
};
