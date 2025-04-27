import {createBrowserRouter, Navigate} from "react-router-dom";
import DefaultLayout from "./components/DefaultLayout";
import NotFound from "./views/NotFound";
import Users from "./views/Users";
import UserForm from "./views/UserForm";
import EmailForm from "./views/EmailForm.js";
import Data from "./views/Data.js";
import Monitor from "./views/Monitor.js";

const router = createBrowserRouter([
  {
    path: '/',
    element: <DefaultLayout/>,
    children: [
      {
        path: '/',
        element: <Navigate to="/users"/>
      },
      {
        path: '/users',
        element: <Users/>
      },
      {
        path: '/users/new',
        element: <UserForm key="userCreate" />
      },
      {
        path: '/users/:id',
        element: <UserForm key="userUpdate" />
      },
      {
        path: '/camp',
        element: <EmailForm  />
      },
      {
        path: '/data',
        element: <Data  />
      },
      {
        path: '/monitor',
        element: <Monitor  />
      }
    ]
  },
  {
    path: "*",
    element: <NotFound/>
  }
])

export default router;
