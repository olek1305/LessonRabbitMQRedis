import React, { ReactNode } from 'react';

type WrapperProps = {
    children: ReactNode;
};

const Wrapper = ({ children }: WrapperProps) => {
    return (
        <div>
            <div className="container">
                {children}
            </div>
        </div>
    );
};

export default Wrapper;
