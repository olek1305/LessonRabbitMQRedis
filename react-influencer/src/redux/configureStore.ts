import { configureStore } from '@reduxjs/toolkit';
import userReducer from "./reducers/userSlice";
import productReducer from "./reducers/productSlice";
import orderReducer from "./reducers/orderSlice";
import orderItemReducer from "./reducers/orderItemSlice";


export const store = configureStore({
    reducer: {
        user: userReducer,
        product: productReducer,
        order: orderReducer,
        orderItem: orderItemReducer
    },
})

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>
// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch