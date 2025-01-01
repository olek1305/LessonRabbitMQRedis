import React, {Component, SyntheticEvent} from 'react';
import './Public.css';
import axios from 'axios';
import {Redirect} from 'react-router-dom';
import constants from "../constans"

class Login extends Component {
    email = '';
    password = '';
    state = {
        redirect: false,
        error: ''
    }

    submit = async (e: SyntheticEvent) => {
        e.preventDefault();

        try {
            const response = await axios.post(`${constants.USERS_URL}/login`, {
                email: this.email,
                password: this.password,
                scope: 'admin'
            });

            console.log('Odpowiedź z API:', response.data);

            this.setState({
                redirect: true,
                error: ''
            })
        } catch (e) {
            console.log(e);

            this.setState({
                error: 'Incorrect email or password. Please try again.'
            });
        }
    }

    render() {
        if (this.state.redirect) {
            return <Redirect to={'/'}/>;
        }

        return (
            <div className="container-fluid">
                <div className="row">
                    <form className="form-signin w-25 mx-auto" onSubmit={this.submit}>
                        <h1 className="h3 mb-3 font-weight-normal">Please sign in</h1>
                        <label htmlFor="inputEmail" className="visually-hidden">Email address</label>
                        <input type="email" id="inputEmail" className="form-control" placeholder="Email address"
                               required
                               onChange={e => this.email = e.target.value}
                        />
                        <label htmlFor="inputPassword" className="visually-hidden">Password</label>
                        <input type="password" id="inputPassword" className="form-control" placeholder="Password"
                               onChange={e => this.password = e.target.value}
                               required/>
                        {this.state.error && (
                            <div className="alert alert-danger" role="alert" style={{ color: 'red' }}>
                                {this.state.error}
                            </div>
                        )}
                        <button className="btn btn-lg btn-primary w-100" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        )
    }
}

export default Login;