;
import { defineStore } from 'pinia';


export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: '',
        isLoggedIn: false,
        errors: ''
    }),
    getters: {
        getUser: (state) => state.user,
        getisLoggedIn: (state) => state.isLoggedIn,
        getErrors: (state) => state.errors,
        getHeaderConfig(state) {
            const config = {
                headers: {
                    "Authorization": `Bearer ${state.user.access_token}`,
                    "Accept": "application/json",
                }
            }
            return config;
        }
    },
    actions: {
        setUser() {
            if (localStorage.getItem('user')) {
                this.user = JSON.parse(localStorage.getItem('user'));
                this.isLoggedIn = true;
            }
        },
        storeUser(user) {
            localStorage.setItem('user', JSON.stringify(user));
            this.user = user;
            this.isLoggedIn = true;
        },
        clearStoredData() {
            localStorage.removeItem('user');
            this.user = '';
            this.isLoggedIn = false;
        },
        setErrors(errors) {
            this.errors = errors;
        },
        clearErrors() {
            this.errors = '';
        }
    },
});

