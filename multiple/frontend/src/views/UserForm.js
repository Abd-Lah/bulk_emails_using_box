import {useNavigate, useParams} from "react-router-dom";
import {useEffect, useState} from "react";
import axiosClient from "../axios-client.js";
import {useStateContext} from "../context/ContextProvider.js";

export default function UserForm() {
  const navigate = useNavigate();
  let {id} = useParams();
  const [user, setUser] = useState({
    id: null,
    email: '',
    password: '',
    password_confirmation: ''
  })
  const [errors, setErrors] = useState(null)
  const [loading, setLoading] = useState(false)
  const {setNotification} = useStateContext()

  
    useEffect(() => {
        if(id){
            setLoading(true)
            axiosClient.get(`/accounts/${id}`)
              .then(({data}) => {
                setLoading(false)
                setUser(data)
              })
              .catch(() => {
                setLoading(false)
            })
        }
       
      }, [])
    
    
  

  const onSubmit = ev => {
    ev.preventDefault()
    if (user.id) {
      axiosClient.put(`/accounts/${user.id}`, user)
        .then(() => {
          setNotification('User was successfully updated')
          navigate('/users')
        })
        .catch(err => {
          const response = err.response;
          if (response && response.status === 422) {
            setErrors(response.data.errors)
          }
        })
    } else {
      axiosClient.post('/accounts/', user)
        .then(() => {
          setNotification('User was successfully created')
          navigate('/users')
        })
        .catch(err => {
          const response = err.response;
          if (response && response.status === 422) {
            setErrors(response.data.errors)
          }
        })
    }
  }

  return (
    <>
      {user.id && <h1>Update User: {user.email}</h1>}
      {!user.id && <h1>New User</h1>}
      <div className="card animated fadeInDown">
        {loading && (
          <div className="text-center">
            Loading...
          </div>
        )}
        {errors &&
          <div className="alert">
            {Object.keys(errors).map(key => (
              <p key={key}>{errors[key][0]}</p>
            ))}
          </div>
        }
        {!loading && (
          <form onSubmit={onSubmit}>
            <input type="text" onChange={ev => setUser({...user, host: ev.target.value})} placeholder="Host"/>
            <input type="number" onChange={ev => setUser({...user, port: ev.target.value})} placeholder="Port"/>
            <input type="text" onChange={ev => setUser({...user, encryption: ev.target.value})} placeholder="Encryption"/>
            <input value={user.email} onChange={ev => setUser({...user, email: ev.target.value})} placeholder="Email"/>
            <input type="password" onChange={ev => setUser({...user, password: ev.target.value})} placeholder="Password"/>
            <button className="btn">Save</button>
          </form>
        )}
      </div>
    </>
  )
}
