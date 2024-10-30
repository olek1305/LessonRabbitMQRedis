import React, {Component} from 'react';
import Wrapper from "../Wrapper";
import {Link} from "react-router-dom";
import axios from "axios";
import {Role} from "../../classes/role";

class Roles extends Component {
    state = {
        roles: []
    }
    componentDidMount = async () => {
        const response = await axios.get('roles');

        this.setState({
            roles: response.data.data
        });
    }

    delete = async (id: number) => {
        if (window.confirm("Are you sure you want to delete this record?")) {
            try {
                await axios.delete(`roles/${id}`);

                this.setState({
                    roles: this.state.roles.filter((r: Role) => r.id !== id)
                });
            } catch (error) {
                console.error("Error deleting user:", error);
                alert("Error deleting user. Please check your permissions or try again.");
            }
        }
    }
    render() {
        return (
            <Wrapper>
                <div
                    className="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div className="btn-toolbar mb-2 mb-md-0">
                        <Link to={'/roles/create'} className="btn btn-sm btn-outline-secondary">Add</Link>
                    </div>
                </div>
                <div className="table-responsive">
                    <table className="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {this.state.roles.map((role: Role) => {
                            return (
                                <tr key={role.id}>
                                    <td>{role.id}</td>
                                    <td>{role.name}</td>
                                    <td>
                                        <div className="btn-group mr-2">
                                            <Link to={`/roles/${role.id}/edit`}
                                                  className="btn btn-sm btn-outline-secondary">Edit</Link>
                                            <button className="btn btn-sm btn-outline-secondary"
                                               onClick={() => this.delete(role.id)}>Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            )
                        })}
                        </tbody>
                    </table>
                </div>
            </Wrapper>
        );
    }
}

export default Roles;