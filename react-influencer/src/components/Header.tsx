import React, {useEffect, useState} from 'react';
import { Link } from "react-router-dom";
import {useSelector} from "react-redux";
import {RootState} from "../redux/configureStore";

const Header = () => {
    const user = useSelector((state: RootState) => state.user);
    const [title, setTitle] = useState('Welcome');
    const [description, setDescription] = useState('Share links and earn 10% of the product price!');

    useEffect(() => {
        if (user?.id) {
            setTitle('$' + user.revenue);
            setDescription('You have earned in total');
        }
    }, [user]);

    let buttons;

    if (user?.id) {
        buttons = (
            <p>
                <Link to={'/stats'} className="btn btn-primary my-2">Stats</Link>
            </p>
        )
    } else {
        buttons = (
            <p>
                <Link to={'/login'} className="btn btn-primary my-2">Login</Link>
                <Link to={'/register'} className="btn btn-secondary my-2">Register</Link>
            </p>
        );
    }

    return (
        <section className="jumbotron text-center">
            <div className="container">
                <h1>{title}</h1>
                <p className="lead text-muted">{description}</p>
                {buttons}
            </div>
        </section>
    );
}

export default Header;