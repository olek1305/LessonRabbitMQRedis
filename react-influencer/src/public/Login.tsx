import React, { useState } from 'react';
import './Public.css';
import axios from 'axios';
import { Navigate } from "react-router-dom";
import { useDispatch } from 'react-redux';
import { setUser } from '../redux/reducers/userSlice';

const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [redirect, setRedirect] = useState(false);
    const dispatch = useDispatch();

    const submit = async (e: React.FormEvent) => {
        e.preventDefault();

        try {
            const response = await axios.post('login', {
                email,
                password,
                scope: 'influencer'
            });

            const { token, user } = response.data;

            localStorage.setItem('token', token);
            axios.defaults.headers.Authorization = `Bearer ${token}`;

             dispatch(setUser({
                id: user.id,
                first_name: user.first_name,
                last_name: user.last_name,
                email: user.email,
                revenue: user.revenue,
                token
            }));

            setRedirect(true);
        } catch (error) {
            console.error("Error during login:", error);
        }
    };

    if (redirect) {
        return <Navigate to="/" />;
    }

    return (
        <form className="form-signin" onSubmit={submit}>
            <h1 className="h3 mb-3 font-weight-normal">Please sign in</h1>

            <div className="row mb-3">
                <label htmlFor="inputEmail" className="visually-hidden">Email address</label>
                <input
                    type="email"
                    id="inputEmail"
                    className="form-control"
                    placeholder="Email address"
                    required
                    onChange={e => setEmail(e.target.value)}
                />
            </div>

            <div className="row mb-3">
                <label htmlFor="inputPassword" className="visually-hidden">Password</label>
                <input
                    type="password"
                    id="inputPassword"
                    className="form-control"
                    placeholder="Password"
                    required
                    onChange={e => setPassword(e.target.value)}
                />
                <button className="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </div>
        </form>
    );
};

export default Login;
