import { NavLink, Outlet } from "react-router-dom";
import {useStateContext} from "../context/ContextProvider";
import '../App.css';
import axiosClient from "../axios-client.js";
import {useEffect} from "react";

export default function DefaultLayout() {
  const {notification} = useStateContext();


  return (
    <div id="defaultLayout">
     <aside>
      <NavLink to="/dashboard" className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'}>Dashboard</NavLink>
      <NavLink to="/users" className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'}>SMTP Accounts</NavLink>
      <NavLink to="/camp" className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'}>Campaign</NavLink>
      <NavLink to="/data" className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'}>Data</NavLink>
      <NavLink to="/monitor" className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'}>Monitor</NavLink>
    </aside>

      <div className="content">
        <header>
          <div>
            Header
          </div>

          <div>
            Abdellah &nbsp; &nbsp;
            <a className="btn-logout" href="#">Logout</a>
          </div>
        </header>
        <main>
          <Outlet/>
        </main>
        {notification &&
          <div className="notification">
            {notification}
          </div>
        }
      </div>
    </div>
  )
}
