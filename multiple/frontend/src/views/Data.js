import React, { useState, useEffect } from 'react';
import { FaSearch } from 'react-icons/fa';
import { AiOutlineDelete } from 'react-icons/ai';
import axiosClient from '../axios-client';
import { useStateContext } from '../context/ContextProvider.js';
import './assets/data.css'; // Ensure the correct path to your CSS file

const Data = () => {
  const { setNotification } = useStateContext();
  const [Loading,setLoading] = useState(false);
  const [email, setEmail] = useState('');
  const [dataList, setDataList] = useState([]);
  const [selectedISP, setSelectedISP] = useState(null);
  const [availableData, setAvailableData] = useState([]);
  const [selectedData, setSelectedData] = useState('');
  const [emails, setEmails] = useState([]);
  const [addExistingData, setAddExistingData] = useState(false);
  const [newDataName, setNewDataName] = useState('');
  const [ispName, setIspName] = useState('');
  const [fileInput, setFileInput] = useState(null);
  const [uniqueISPs, setUniqueISPs] = useState([]); // Added state for unique ISPs
  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(1);


  const getData = () => {
    axiosClient
    .get('/get_data')
    .then((response) => {
      setDataList(response.data);
      // Extract unique ISPs from the data
      const isps = [...new Set(response.data.map((data) => data.isp))];
      setUniqueISPs(isps);
    })
    .catch((error) => console.error('Error fetching data:', error));
  }
  const getEmails = () => {
    if (selectedData) {
      axiosClient
        .post('/get_data_emails', {
          id: selectedData,
          page: currentPage, // Include the current page in the request
        })
        .then((response) => {
          setEmails(response.data.data);
          setTotalPages(response.data.last_page);
        })
        .catch((error) => console.error('Error fetching emails:', error));
    }
  }
  useEffect(() => {
    getData();
  }, []);

  useEffect(() => {
    // Fetch data from localhost:8000/get_data_emails based on the selected dataId using axiosClient
    getEmails();
   
  }, [selectedData, currentPage]);

  const handleISPSelect = async (isp) => {
    // Set selectedISP state
    setSelectedISP(isp);

    // Filter available data based on the selected ISP
    const filteredData = dataList.filter((data) => data.isp === isp);
    setAvailableData(filteredData);

    // Reset selected data when ISP changes
    setSelectedData(null);
    setCurrentPage(1); // Reset current page when selecting a new ISP
  };

  const handleDataSelect = async (dataId) => {
    // Set selectedData state
    setLoading(true);
    setSelectedData(dataId);
    setCurrentPage(1); // Reset current page when selecting a new data

    // Fetch data from localhost:8000/get_data_emails based on the selected dataId using axiosClient
    try {
      const response = await axiosClient.post('/get_data_emails', {
        id: dataId,
        page: currentPage,
      });
      setEmails(response.data.data);
      setTotalPages(response.data.last_page);
    } catch (error) {
      console.error('Error fetching emails:', error);
    }
    setLoading(false);
  };

  const handleAddExistingDataChange = () => {
    setAddExistingData(!addExistingData);
    // Reset the selected data when switching between adding new/existing data
    setSelectedData(null);
    setCurrentPage(1); // Reset current page when switching between adding new/existing data
  };

  const handleAddData = async () => {
    try {
      if (addExistingData && selectedData) {
        // Add logic for adding to existing data
        const formData = new FormData();
        formData.append('id', selectedData); // Pass the selected data id
        formData.append('file', getFile());

        const response = await axiosClient.post('/data/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        setNotification(response.data.message);
      } else if (!addExistingData && newDataName && ispName) {
        // Add logic for adding new data
        const formData = new FormData();
        formData.append('ispName', ispName);
        formData.append('name', newDataName); // Pass the new data name
        formData.append('file', getFile());

        const response = await axiosClient.post('/data/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        setNotification(response.data.message);
      } else {
        console.log('Please fill in the required fields.');
      }
    } catch (error) {
      console.error('Error adding data:', error);
    }
    getData();
  };

  const getFile = () => {
    return fileInput?.files[0] || null;
  };

  const handleFirstPage = () => {
    setCurrentPage(1);
  };

  const handlePrevPage = () => {
    if (currentPage > 1) {
      setCurrentPage(currentPage - 1);
    }
  };

  const handleNextPage = () => {
    if (currentPage < totalPages) {
      setCurrentPage(currentPage + 1);
    }
  };

  const handleLastPage = () => {
    setCurrentPage(totalPages);
  };

  const getUser = async () => {
    if (!email.includes('@')) return;
    setLoading(true);
    try {
      const response = await axiosClient.get('/data/get_email', {
        params: {
          email: email,
        },
      });
      setEmails(response.data);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
    setLoading(false);
  };

  const onDeleteClick = async (email) => {
    if (!window.confirm('Are you sure you want to delete this user?')) {
      return;
    }

    try {
      await axiosClient.delete('/data/delete_email',{
        params: {
          id: email.id,
        },
      });
      setNotification('User was successfully deleted');
      getEmails();
    } catch (error) {
      console.error('Delete user error:', error);
    }
  };

  return (
    <div className="data-component">
      {/* Top Section */}
      <div className="top-section">
        {/* Filter Data and Table Section */}
        <div className="filter-section card">
          <div className="select-section">
            <select onChange={(e) => handleISPSelect(e.target.value)}>
              <option value="">Select ISP</option>
              {uniqueISPs.map((isp) => (
                <option key={isp} value={isp}>
                  {isp}
                </option>
              ))}
            </select>
            <select onChange={(e) => handleDataSelect(e.target.value)}>
              <option value="">Select Data</option>
              {availableData.map((data) => (
                <option key={data.id} value={data.id}>
                  {data.name}
                </option>
              ))}
            </select>
          </div>

          {/* Table */}
          <table className="emails-table">
            <thead>
              <tr>
                <th>Email</th>
                <th>Active</th>
                <th>Creation date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style={{ textAlign: 'left' }} colSpan={3}>
                  <input
                    placeholder="Search by email ..."
                    onChange={(e) => setEmail(e.target.value)}
                  />
                </td>
                <td>
                  <button onClick={getUser}>
                    <FaSearch className="search-icon" />
                  </button>
                </td>
              </tr>
              {emails.map((email) => (
                <tr key={email.id}>
                  <td>{email.email}</td>
                  <td>{email.active === 0 ? 'No' : 'Yes'}</td>
                  <td>{email.created_at}</td>
                  <td>
                    <button
                      className="btn-delete"
                      onClick={(ev) => {
                        onDeleteClick(email);
                      }}
                    >
                      <AiOutlineDelete size={24} color="red" />
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
          {Loading && (
              <div className="loader">
              </div>
            )}
          {/* Pagination */}
          <div className="pagination">
            <button onClick={handleFirstPage}>&lt;&lt;</button>
            <button onClick={handlePrevPage}>&lt;</button>
            <span>{currentPage}</span>
            <button onClick={handleNextPage}>&gt;</button>
            <button onClick={handleLastPage}>&gt;&gt;</button>
          </div>
        </div>

        {/* Upload Card Section */}
        <div className="upload-section card">
          {/* Checkbox and Label Wrapper */}
          <h4>Add in existing data?</h4>
          <input
            type="checkbox"
            checked={addExistingData}
            onChange={handleAddExistingDataChange}
          />
          <br />
          {/* Other Inputs based on the checkbox */}
          <input type="file" onChange={(e) => setFileInput(e.target)} />
          {addExistingData ? (
            <select
              onChange={(e) => setSelectedData(e.target.value)}
              value={selectedData}
            >
              <option value="">Select Data</option>
              {dataList
                .filter((data) => data.isp === selectedISP) // Filter data based on selected ISP
                .map((data) => (
                  <option key={data.id} value={data.id}>
                    {data.name}
                  </option>
                ))}
            </select>
          ) : (
            <>
              <input
                type="text"
                placeholder="Enter data name"
                value={newDataName}
                onChange={(e) => setNewDataName(e.target.value)}
              />
              <input
                type="text"
                placeholder="Enter isp name"
                value={ispName}
                onChange={(e) => setIspName(e.target.value)}
              />
            </>
          )}

          <button className="btn-add" onClick={handleAddData}>
            Add data
          </button>
        </div>
      </div>
    </div>
  );
};

export default Data;
