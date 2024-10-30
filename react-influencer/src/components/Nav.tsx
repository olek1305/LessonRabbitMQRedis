import React from 'react';
import { Link } from "react-router-dom";
import { useSelector } from 'react-redux';
import { RootState } from '../redux/configureStore';

const Nav = () => {
    const user = useSelector((state: RootState) => state.user);
    let menu;

    if (user) {
        menu = (
            <>
                <nav className="my-2 my-md-0 mr-md-3">
                    <Link to={'/stats'} className="p-2 text-dark">Stats</Link>
                    <Link to={'/rankings'} className="p-2 text-dark">Rankings</Link>
                    <Link to={'/login'} onClick={() => localStorage.clear()} className="p-2 text-dark">Logout</Link>
                </nav>
                {/* Displaying user's last name */}
                <Link to={'/profile'} className="btn btn-outline-primary">{user.last_name}</Link>
            </>
        );
    } else {
        menu = (
            <Link to={'/login'} className="btn btn-outline-primary">Login</Link>
        );
    }

    return (
        <div className="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 border-bottom shadow-sm">
            <Link to={'/'} className="navbar-brand my-0 me-md-auto font-weight-normal">Influencer</Link>
            {menu}
        </div>
    );
};

export default Nav;