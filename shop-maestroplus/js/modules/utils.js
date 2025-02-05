export const utils = {
    formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    },

    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    },

    validateInput(input, rules = {}) {
        const errors = [];
        
        if (rules.required && !input.trim()) {
            errors.push('Field ini wajib diisi');
        }
        
        if (rules.email && !input.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/)) {
            errors.push('Email tidak valid');
        }
        
        if (rules.minLength && input.length < rules.minLength) {
            errors.push(`Minimal ${rules.minLength} karakter`);
        }
        
        return errors;
    }
}; 