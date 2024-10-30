import { createSlice, PayloadAction } from '@reduxjs/toolkit';

interface UserState {
    id: number | null;
    first_name: string | null;
    last_name: string | null;
    email: string | null;
    revenue: number | null;
    token: string | null;
}

const initialState: UserState = {
    id: null,
    first_name: null,
    last_name: null,
    email: null,
    revenue: null,
    token: null,
};

const userSlice = createSlice({
    name: 'user',
    initialState,
    reducers: {
        setUser: (state, action: PayloadAction<UserState>) => {
            return { ...state, ...action.payload };
        },
        clearUser: (state) => {
            return initialState;
        },
    },
});

export const selectFullName = (state: UserState) => {
    return state.first_name && state.last_name ? `${state.first_name} ${state.last_name}` : '';
};

export const { setUser, clearUser } = userSlice.actions;

export default userSlice.reducer;