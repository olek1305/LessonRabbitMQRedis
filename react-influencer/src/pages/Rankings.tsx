import React, {useEffect, useState} from 'react';
import Wrapper from "./Wrapper";
import axios from 'axios';

interface RankingResponse {
    [name: string]: number;
}

const Rankings = () => {
    const [rankings, setRankings] = useState<{ name: string, revenue: number }[]>([]); // Rankings array

    useEffect(() => {
        (
            async () => {
                try {
                    const response = await axios.get<RankingResponse>('rankings');

                    const formattedRankings = Object.entries(response.data).map(([name, revenue]) => ({
                        name,
                        revenue: revenue
                    }));

                    setRankings(formattedRankings);
                } catch (error) {
                    console.error('Error fetching rankings:', error);
                    setRankings([]);
                }
            }
        )();
    }, []);

    return (
        <Wrapper>
            <div className="album py-5 bg-light">
                <div className="container">
                    <div className="table-responsive">
                        <table className="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Revenue</th>
                            </tr>
                            </thead>
                            <tbody>
                            {rankings.map((r, index) => (
                                <tr key={index}>
                                    <td>{index + 1}</td>
                                    <td>{r.name}</td>
                                    <td>{r.revenue}</td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </Wrapper>
    );
};

export default Rankings;