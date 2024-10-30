import React, {Component} from 'react';
import {Redirect, Link} from 'react-router-dom';
import {User} from "../../classes/user";
import { connect } from 'react-redux';
import axios from 'axios';

class Nav extends Component<{user: User}> {
    state = {
        redirect: false
    }

    handleClick = async () => {
        await axios.post('logout', {});

        this.setState({
            redirect: true
        })
    }

    render() {
        if (this.state.redirect) {
            return <Redirect to={'/login'}/>
        }

        return (
            <nav className="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
                <button className="navbar-brand col-md-3 col-lg-2 mr-0 px-3">Company name</button>

                <ul className="my-2 my-md-0 mr-md-3">
                    <Link to={'/profile'}
                          className="p-2 text-white">{this.props.user.name}</Link>
                    <button className="p-2 text-white" onClick={this.handleClick}>Sign out</button>
                </ul>
            </nav>
        )
    }
}

// @ts-ignore
export default connect(state => ({user: state.user}))(Nav);