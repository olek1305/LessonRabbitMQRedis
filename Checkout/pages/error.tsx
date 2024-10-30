import React from 'react';
import Wrapper from "../components/Wrapper";

const Error = () => {
    return (
        <Wrapper>
            <div className="py-5 text-center">
                <h3>Error</h3>
                <p className="lead">Couldn&#39;t process payment!</p>
            </div>
        </Wrapper>
    );
};

export default Error;