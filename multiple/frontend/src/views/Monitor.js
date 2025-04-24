// Import necessary libraries and components
import React, { useState, useEffect } from 'react';
import axiosClient from '../axios-client';
import '../index.css'

// Font Awesome icons
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faPlay, faPause, faStop, faSync } from '@fortawesome/free-solid-svg-icons';

const Monitor = () => {
  // State to store data from the /drop endpoint
  const [drops, setDrops] = useState([]);

  useEffect(() => {
    // Fetch data from the /drop endpoint
    fetchData();
  }, []);

  // Function to fetch data from the /drop endpoint
  const fetchData = () => {
    axiosClient.get('/drops')
      .then(response => {
        setDrops(response.data);
      })
      .catch(error => {
        console.error('Error fetching drops:', error);
      });
  };

  // Function to handle actions (resume, pause, stop)

  return (
    <div>
      <h1>Drop Monitor</h1>
      <button onClick={fetchData}>
        <FontAwesomeIcon icon={faSync} />
      </button>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Data</th>
            <th>Range Acc</th>
            <th>Range Email</th>
            <th>Subject</th>
            <th>From Name</th>
            <th>OnQUEUE</th>
          </tr>
        </thead>
        <tbody>
          {drops.map(drop => (
            <tr key={drop.id}>
                <td>{drop.id}</td>
              <td>{drop.status}</td>
              <td>{drop.data}</td>
              <td>{drop.range_acc}</td>
              <td>{drop.range_email}</td>
              <td>{drop.subject}</td>
              <td>{drop.from_name}</td>
              <td>{(drop.onQueue === 0) ? "Finished" : drop.onQueue}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Monitor;
