import React, {useEffect, useState} from 'react';
import Wrapper from "./Wrapper";
import Header from "../components/Header";
import axios from "axios";
import {useDispatch, useSelector} from "react-redux";
import { RootState } from '../redux/configureStore';
import {fetchProducts} from "../redux/reducers/productSlice";


const Main = () => {
    const dispatch = useDispatch();

    const products = useSelector((state: RootState) => state.product.products);
    const [searchText, setSearchText] = useState('');
    const [selected, setSelected] = useState<number[]>([]);
    const [notify, setNotify] = useState({
        show: false,
        error: false,
        message: ''
    });

    // Fetch products based on searchText
    useEffect(() => {
        dispatch(fetchProducts(searchText));
    }, [searchText, dispatch]);

    const isSelected = (id: number) => selected.includes(id);

    const select = (id: number) => {
        if (isSelected(id)) {
            setSelected(selected.filter(s => s !== id));
        } else {
            setSelected([...selected, id]);
        }
    };

    const generate = async () => {
        try {
            const response = await axios.post('links', {
                products: selected
            });

            setNotify({
                show: true,
                error: false,
                message: `Link generated: ${process.env.CHECKOUT_URL}/${response.data.data.code}`
            });
        } catch (e) {
            setNotify({
                show: true,
                error: true,
                message: 'You should be logged in to generate a link!'
            });
        } finally {
            setTimeout(() => {
                setNotify({
                    show: false,
                    error: false,
                    message: ''
                });
            }, 10000);
        }
    };

    let button, info;

    if (selected.length > 0) {
        button = (
            <div className="input-group-append">
                <button className="btn btn-info" onClick={generate}>Generate Link</button>
            </div>
        );
    }

    if (notify.show) {
        info = (
            <div className="col-md-12 mb-4">
                <div className={notify.error ? "alert alert-danger" : "alert alert-info"} role="alert">
                    {notify.message}
                </div>
            </div>
        );
    }

    return (
        <Wrapper>
            <Header/>

            <div className="album py-5 bg-light">
                <div className="container">
                    <div className="row">
                        {info}

                        <div className="col-md-12 mb-4 input-group">
                            <input type="text" className="form-control" placeholder="Search"
                                   onKeyUp={e => setSearchText((e.target as HTMLInputElement).value)}
                            />
                            {button}
                        </div>

                        {products.map((product: any) => (
                            <div className="col-md-4" key={product.id}>
                                <div
                                    className={isSelected(product.id) ? "card mb-4 shadow-sm selected border-green border-4 bg-yellow" : "card mb-4 shadow-sm"}
                                    onClick={() => select(product.id)}
                                >
                                    <img src={product.image} height="200" alt={product.title} />
                                    <div className="card-body">
                                        <p className="card-text">{product.title}</p>
                                        <div className="d-flex justify-content-between align-items-center">
                                            <small className="text-muted">${product.price}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </Wrapper>
    );
}

export default Main;