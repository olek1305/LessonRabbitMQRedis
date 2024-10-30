import { createSlice, PayloadAction } from '@reduxjs/toolkit';

export interface OrderItemState {
    id: number;
    product_title: string;
    price: number;
    quantity: number;
}

const initialState: OrderItemState = {
    id: 0,
    product_title: '',
    price: 0,
    quantity: 0,
};

const orderItemSlice = createSlice({
    name: 'orderItem',
    initialState,
    reducers: {
        setOrderItem: (state, action: PayloadAction<OrderItemState>) => {
            return { ...state, ...action.payload };
        },
        clearOrderItem: (state) => {
            return initialState;
        },
        updateQuantity: (state, action: PayloadAction<number>) => {
            state.quantity = action.payload;
        },
    },
});

export const { setOrderItem, clearOrderItem, updateQuantity } = orderItemSlice.actions;

export default orderItemSlice.reducer;
