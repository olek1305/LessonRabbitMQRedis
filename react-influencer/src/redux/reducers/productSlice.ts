import { createSlice, createAsyncThunk, PayloadAction } from '@reduxjs/toolkit';
import axios from 'axios';

interface Product {
    id: number;
    title: string;
    description: string;
    image: string;
    price: number;
}

interface ProductState {
    products: Product[];
    loading: boolean;
    error: string | null;
}

const initialState: ProductState = {
    products: [],
    loading: false,
    error: null,
};

export const fetchProducts = createAsyncThunk<Product[], string>(
    'products/fetchProducts',
    async (searchText: string) => {
        const response = await axios.get(`products?s=${searchText}`);
        return response.data.data; // Return the products from the response
    }
);

const productSlice = createSlice({
    name: 'product',
    initialState,
    reducers: {
        setProduct: (state, action: PayloadAction<ProductState>) => {
            return { ...state, ...action.payload };
        },
    },
    extraReducers: (builder) => {
        builder
            .addCase(fetchProducts.pending, (state) => {
                state.loading = true;
                state.error = null;
            })
            .addCase(fetchProducts.fulfilled, (state, action: PayloadAction<Product[]>) => {
                state.loading = false;
                state.products = action.payload; // Store fetched products
            })
            .addCase(fetchProducts.rejected, (state, action) => {
                state.loading = false;
                state.error = action.error.message || 'Failed to fetch products';
            });
    },
});

export const { setProduct } = productSlice.actions;
export default productSlice.reducer;
