class Auth {
    constructor() {
        this.baseUrl = '/api/auth';
        this.tokenKey = 'auth_token';
    }

    async login(email, password) {
        try {
            const response = await fetch(`${this.baseUrl}/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            if (!response.ok) {
                throw new Error('Login gagal');
            }

            const data = await response.json();
            this.setToken(data.token);
            return data.user;
        } catch (error) {
            console.error('Error login:', error);
            throw new Error('Gagal masuk. Silakan coba lagi.');
        }
    }

    logout() {
        localStorage.removeItem(this.tokenKey);
        window.location.href = '/login';
    }

    isAuthenticated() {
        return !!this.getToken();
    }

    getToken() {
        return localStorage.getItem(this.tokenKey);
    }

    setToken(token) {
        localStorage.setItem(this.tokenKey, token);
    }
}

export const auth = new Auth(); 