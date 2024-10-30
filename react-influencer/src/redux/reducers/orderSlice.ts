import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { OrderItemState } from './orderItemSlice';

interface OrderState {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    total: number;
    order_items: OrderItemState[];
}

const initialState: OrderState = {
    id: 0,
    first_name: '',
    last_name: '',
    email: '',
    total: 0,
    order_items: [],
};

const orderSlice = createSlice({
    name: 'order',
    initialState,
    reducers: {
        setOrder: (state, action: PayloadAction<OrderState>) => {
            return { ...state, ...action.payload };
        },
        clearOrder: (state) => {
            return initialState;
        },
        addOrderItem: (state, action: PayloadAction<OrderItemState>) => {
            state.order_items.push(action.payload);
        },
        updateTotal: (state, action: PayloadAction<number>) => {
            state.total = action.payload;
        },
    },
});

export const { setOrder, clearOrder, addOrderItem, updateTotal } = orderSlice.actions;

export default orderSlice.reducer;
