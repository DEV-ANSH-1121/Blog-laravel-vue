import Swal from 'sweetalert2';
import router from '@/router';
import { useAuthStore } from '@/stores/useAuthStore.js';


const store = useAuthStore();

export const login = async () => {
    store.clearErrors(creds);
    try {
        await axios.get("http://localhost:8000/sanctum/csrf-cookie");
        const response = await axios.post('/api/login', creds);
        if (response.data.success) {
            store.storeUser(response.data.user);
            router.push('/');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: response.data.message,
            });
        }
    } catch (error) {
        store.setErrors(error.response.data.errors);
    }
}

export const register = async () => {
    store.clearErrors(userData);
    try {
        await axios.get("http://localhost:8000/sanctum/csrf-cookie");
        const response = await axios.post('/api/register', userData);
        if (response.data.success) {
            let creds = {
                email: userData.email,
                password: userData.password
            }
            login(creds)
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: response.data.message,
            });
        }
    } catch (error) {
        store.setErrors(error.response.data.errors);
    }
}
