// Users.js
import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../axios-client.js";
import { useStateContext } from "../context/ContextProvider.js";

export default function Users() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(false);
  const [enable, setEnable] = useState(false);
  const { setNotification } = useStateContext();

  useEffect(() => {
    getUsers();
  }, []);
  const togleChnge = async (e, user) => {
    const change = e.target.checked;
    try {
      // Update the local state first
      setEnable(true)
      setUsers((prevUsers) =>
        prevUsers.map((u) => (u.id === user.id ? { ...u, active: change } : u))
      );
  
      // Then send the request to update the backend
      const res = await axiosClient.put(`/account/enable/${user.id}`, {
        active: change,
      });
  
      // Handle success or error if needed
      
      setNotification('Account updated')
    } catch (error) {
      setNotification('Please try again !')
  
      // If the request fails, revert the local state change
      setUsers((prevUsers) =>
        prevUsers.map((u) => (u.id === user.id ? { ...u, active: !change } : u))
      );
    } finally{
      setEnable(false)
    }
  };
  const onDeleteClick = (user) => {
    if (!window.confirm("Are you sure you want to delete this user?")) {
      return;
    }
    axiosClient
      .delete(`/accounts/${user.id}`)
      .then(() => {
        setNotification("User was successfully deleted");
        getUsers();
      })
      .catch((error) => {
        console.error("Delete user error:", error);
      });
  };
const HandleAvailableAccount = () => {
  setLoading(true)
  axiosClient
      .get("/accounts/check_available")
      .then(({ data }) => {
        setNotification('Run the Bus To Complete the process')
      })
      .catch((error) => {
        setNotification(error.error);
      });
      setLoading(false)
}
  const getUsers = () => {
    setLoading(true);
    axiosClient
      .get("/accounts")
      .then(({ data }) => {
        setLoading(false);
        setUsers(data);
      })
      .catch((error) => {
        setLoading(false);
        console.error("Get users error:", error);
      });
  };

  return (
    <div>
       
      <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center" }}>
        <h1>Accounts</h1>
        <Link className="btn-add" to="/users/new">
          Add new
        </Link>
        
      </div>
      <button className="btn-add" onClick={HandleAvailableAccount}>
          Check Available Account
        </button>
      <div className="card animated fadeInDown">
        <table className="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Email</th>
              <th>Authorization</th>
              <th>Create Date</th>
              <th>Actions</th>
              <th>Enable/Disable</th>
            </tr>
          </thead>
          {!loading && (
            <tbody>
              {users.map((u) => (
                <tr key={u.id}>
                  <td>{u.id}</td>
                  <td>{u.email}</td>
                  <td>{u.password}</td>
                  <td>{u.created_at}</td>
                  <td>
                    <Link className="btn-edit" to={`/users/${u.id}`}>
                      Edit
                    </Link>
                    &nbsp;
                    <button className="btn-delete" onClick={(ev) => onDeleteClick(u)}>
                      Delete
                    </button>
                    
                  </td>
                  <td>
                    <div className="toggle-container">
                      <label className="switch">
                        <input type="checkbox" id="toggleSwitch" checked={u.active} onChange={(ev)=>togleChnge(ev,u)}/>
                        <span className="slider"></span>
                      </label>
                      
                    </div></td>
                </tr>
              ))}
            </tbody>
            
          )}
         
        </table>
      </div>
    </div>
  );
}
