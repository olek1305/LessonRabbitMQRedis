import { Html, Head, Main, NextScript } from 'next/document';
import Script from "next/script";
import React from "react";

export default function Document() {
    return (
        <Html>
            <Head>
                {/* Bootstrap CSS */}
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
                      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
                      crossOrigin="anonymous"/>

                {/* Stripe.js */}
                <Script src="https://js.stripe.com/v3/"></Script>
            </Head>
            <body>
            <Main/>
            <NextScript/>
            </body>
        </Html>
    );
}
