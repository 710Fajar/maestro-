class ProductService {
    constructor() {
        this.baseUrl = `${BASE_URL}/api/products.php`;
    }

    async getProducts() {
        store.setState({ isLoading: true });
        try {
            const response = await fetch(this.baseUrl);
            if (!response.ok) throw new Error('Failed to fetch products');
            
            const result = await response.json();
            if (result.status === 'success') {
                store.setState({ products: result.data, isLoading: false });
                return result.data;
            }
            throw new Error(result.message);
        } catch (error) {
            store.setState({ 
                error: 'Failed to load products', 
                isLoading: false 
            });
            throw error;
        }
    }
}

export const productService = new ProductService(); 