import React, {useEffect} from 'react';
import Wrapper from "../components/Wrapper";
import {useRouter} from "next/router";
import axios from 'axios';

const Success = () => {
    const router = useRouter();
    const {source} = router.query;

    useEffect(() => {
        if (source !== undefined) {
            (
                async () => {
                    await axios.post(`${process.env.NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY}/orders/confirm`, {
                        source: source
                    });
                }
            )();
        }
    }, [source]);

    return (
        <Wrapper>
            <div className="py-5 text-center">
                <h2>Success</h2>
                <p className="lead">Your purchase has been completed!</p>
            </div>
        </Wrapper>
    );
};

export default Success;