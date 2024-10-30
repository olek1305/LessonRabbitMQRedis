import Wrapper from "../components/Wrapper";
import {useRouter} from "next/router";
import React, {useEffect, useState} from "react";
import axios from 'axios';
import {loadStripe} from "@stripe/stripe-js";

interface Product {
    id: number;
    title: string;
    description: string;
    price: string;
}

interface Quantity {
    product_id: number;
    quantity: number;
}

interface User {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
}

interface Product {
    id: number;
    title: string;
    description: string;
    price: string;
}

const stripePromise = loadStripe(process.env.NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY!);

const Home = () => {
    const router = useRouter();
    const { code } = router.query;
    const [user, setUser] = useState<User | null>(null);
    const [products, setProducts] = useState<Product[]>([]);
    const [quantities, setQuantities] = useState<Quantity[]>([]);
    const [firstName, setFirstName] = useState('');
    const [lastName, setLastName] = useState('');
    const [email, setEmail] = useState('');
    const [address, setAddress] = useState('');
    const [address2, setAddress2] = useState('');
    const [country, setCountry] = useState('');
    const [city, setCity] = useState('');
    const [zip, setZip] = useState('');

    useEffect(() => {
        if (code !== undefined) {
            (async () => {
                try {
                    const response = await axios.get(`${process.env.NEXT_PUBLIC_ENDPOINT}/links/${code}`);
                    const data = response.data.data;
                    setUser(data.user);
                    setProducts(data.products);
                    setQuantities(data.products.map((p: Product) => ({
                        product_id: p.id,
                        quantity: 0
                    })));
                } catch (error) {
                    console.error("Error fetching link data:", error);
                }
            })();
        }
    }, [code]);

    const quantity = (id: number) => {
        const q = quantities.find(q => q.product_id === id);
        return q ? q.quantity : 0;
    };

    const change = (id: number, quantity: number) => {
        setQuantities(prevQuantities => prevQuantities.map(q =>
            q.product_id === id ? { ...q, quantity } : q
        ));
    };

    const total = () => {
        return quantities.reduce((sum, q) => {
            const product = products.find(p => p.id === q.product_id);
            return product ? sum + q.quantity * parseFloat(product.price) : sum;
        }, 0);
    };

    const submit = async (e: React.FormEvent) => {
        e.preventDefault();

        try {
            const response = await axios.post(`${process.env.NEXT_PUBLIC_ENDPOINT}/orders`, {
                first_name: firstName,
                last_name: lastName,
                email,
                address,
                address2,
                country,
                city,
                zip,
                code,
                items: quantities
            });

            const stripe = await stripePromise;
            if (stripe) {
                const { error } = await stripe.redirectToCheckout({
                    sessionId: response.data.id
                });
                if (error) {
                    console.error("Stripe checkout error:", error.message);
                }
            }
        } catch (error) {
            console.error("Submit error:", error);
        }
    };

    return (
        <Wrapper>
            <div className="py-5 text-center">
                <h2>Welcome</h2>
                <p className="lead">{user?.first_name} {user?.last_name} has invited you to buy these items.</p>
            </div>
            <div className="row">
                <div className="col-md-4 order-md-2 mb-4">
                    <h4 className="d-flex justify-content-between align-items-center mb-3">
                        <span className="text-muted">Products</span>
                    </h4>
                    <ul className="list-group mb-3">
                        {products.map(p => (
                            <div key={p.id}>
                                <li className="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 className="my-0">{p.title}</h6>
                                        <small className="text-muted">{p.description}</small>
                                    </div>
                                    <span className="text-muted">${p.price}</span>
                                </li>
                                <li className="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 className="my-0">Quantity</h6>
                                    </div>
                                    <input
                                        type="number"
                                        min="0"
                                        className="text-muted form-control"
                                        style={{ width: '65px' }}
                                        defaultValue={quantity(p.id)}
                                        onChange={e => change(p.id, parseInt(e.target.value))}
                                    />
                                </li>
                            </div>
                        ))}
                        <li className="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong>${total()}</strong>
                        </li>
                    </ul>
                </div>
                <div className="col-md-8 order-md-1">
                    <h4 className="mb-3">Payment Info</h4>
                    <form className="needs-validation" onSubmit={submit}>
                        <div className="row">
                            <div className="col-md-6 mb-3">
                                <label htmlFor="firstName">First name</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="firstName"
                                    placeholder="First Name"
                                    onChange={e => setFirstName(e.target.value)}
                                    required
                                />
                            </div>
                            <div className="col-md-6 mb-3">
                                <label htmlFor="lastName">Last name</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="lastName"
                                    placeholder="Last Name"
                                    onChange={e => setLastName(e.target.value)}
                                    required
                                />
                            </div>
                            <div className="mb-3">
                                <label htmlFor="email">Email</label>
                                <input type="email" className="form-control" id="email" placeholder="you@example.com"
                                       onChange={e => setEmail(e.target.value)}
                                />
                            </div>

                            <div className="mb-3">
                                <label htmlFor="address">Address</label>
                                <input type="text" className="form-control" id="address" placeholder="1234 Main St"
                                       onChange={e => setAddress(e.target.value)}
                                       required/>
                            </div>

                            <div className="mb-3">
                                <label htmlFor="address2">Address 2 <span
                                    className="text-muted">(Optional)</span></label>
                                <input type="text" className="form-control" id="address2"
                                       onChange={e => setAddress2(e.target.value)}
                                       placeholder="Apartment or suite"/>
                            </div>

                            <div className="row">
                                <div className="col-md-5 mb-3">
                                    <label htmlFor="country">Country</label>
                                    <input type="text" className="form-control" id="country" placeholder="Country"
                                           onChange={e => setCountry(e.target.value)}
                                    />
                                </div>
                                <div className="col-md-4 mb-3">
                                    <label htmlFor="city">City</label>
                                    <input type="text" className="form-control" id="city" placeholder="City"
                                           onChange={e => setCity(e.target.value)}
                                    />
                                </div>
                                <div className="col-md-3 mb-3">
                                    <label htmlFor="zip">Zip</label>
                                    <input type="text" className="form-control" id="zip" placeholder="Zip" required
                                           onChange={e => setZip(e.target.value)}
                                    />
                                </div>
                            </div>
                        </div>
                        <button className="btn btn-primary btn-lg btn-block" type="submit">Checkout</button>
                    </form>
                </div>
            </div>
        </Wrapper>
    );
};

export default Home;