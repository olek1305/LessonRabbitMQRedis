import React, { ReactNode, useEffect } from 'react';
import Nav from "../components/Nav";
import axios from 'axios';
import { useDispatch } from "react-redux";
import { setUser } from "../redux/reducers/userSlice";

interface WrapperProps {
    children: ReactNode;
}

const Wrapper = ({ children }: WrapperProps) => {
    const dispatch = useDispatch();

    useEffect(() => {
        const storedToken = localStorage.getItem('token');
        const storedUser = JSON.parse(localStorage.getItem('user') || '{}');

        if (storedToken && storedUser) {
            dispatch(setUser({ ...storedUser, token: storedToken }));
            axios.defaults.headers.Authorization = `Bearer ${storedToken}`;
        }

        const fetchUser = async () => {
            if (!storedToken) {
                console.warn("User is not logged in");
                return;
            }

            try {
                const response = await axios.get('user', {
                    headers: {
                        Authorization: `Bearer ${storedToken}`
                    }
                });
                const userData = response.data.data;
                dispatch(setUser(userData));
                localStorage.setItem('user', JSON.stringify(userData));
            } catch (e) {
                console.error("Error fetching user:", e);
            }
        };

        fetchUser();
    }, [dispatch]);

    return (
        <>
            <Nav />
            <main role="main">
                {children}
            </main>
        </>
    );
}

export default Wrapper;
