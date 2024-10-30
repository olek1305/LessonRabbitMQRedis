import React, {Component, SyntheticEvent} from 'react';
import './Public.css'
import axios from 'axios';
import {Redirect} from 'react-router-dom';
import Wrapper from "../secure/Wrapper";

class Register extends Component {
    first_name = '';
    last_name = '';
    email = '';
    password = '';
    password_confirm = '';
    state = {
        redirect: false
    }

    submit = async (e: SyntheticEvent) => {
        e.preventDefault();

        await axios.post('register', {
            first_name: this.first_name,
            last_name: this.last_name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirm,
        });

        this.setState({
            redirect: true
        })
    }

    render() {
        if (this.state.redirect) {
            return <Redirect to="/login" />;
        }

        return (
            <Wrapper>
                <form className="form-sign-in" onSubmit={this.submit}>
                    <h1 className="h3 mb-3 font-weight-normal">Please sign in</h1>

                    <label htmlFor="inputFirstName" className="visually-hidden">First Name</label>
                    <input type="text" id="inputFirstName" className="form-control" placeholder="First Name" required
                           onChange={e => this.first_name = e.target.value}
                    />

                    <label htmlFor="inputLastName" className="visually-hidden">Last Name</label>
                    <input type="text" id="inputLastName" className="form-control" placeholder="Last Name" required
                           onChange={e => this.last_name = e.target.value}
                    />

                    <label htmlFor="inputEmail" className="visually-hidden">Email address</label>
                    <input type="email" id="inputEmail" className="form-control" placeholder="Email address" required
                           onChange={e => this.email = e.target.value}
                    />

                    <label htmlFor="inputPassword" className="visually-hidden">Password</label>
                    <input type="password" id="inputPassword" className="form-control" placeholder="Password" required
                           onChange={e => this.password = e.target.value}
                    />

                    <label htmlFor="passwordConfirm" className="visually-hidden">Password Confirmation</label>
                    <input type="password" id="passwordConfirm" className="form-control" placeholder="Password Confirmation" required
                           onChange={e => this.password_confirm = e.target.value}
                    />

                    <button className="btn btn-lg btn-primary w-100" type="submit">Sign in</button>
                </form>
            </Wrapper>
        )
    }
}

export default Register;