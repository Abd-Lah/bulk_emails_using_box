// EmailForm.js
import React, { useState, useEffect } from "react";
import "./assets/email.css"; // Import the corresponding CSS file
import axiosClient from "../axios-client";
import { useStateContext } from "../context/ContextProvider.js";
import Pusher from 'pusher-js';

const EmailForm = () => {
  const [loading, setLoading] = useState(false);
  const [title, setTitle] = useState('Test Form');
  const [dataList, setDataList] = useState([]);
  const [selectedISP, setSelectedISP] = useState(null);
  const [uniqueISPs, setUniqueISPs] = useState([]); 
  const [dataCount, setdataCount] = useState(0);
  const [SmtpCount, setSmtpCount] = useState(0);// Added state for unique ISPs
  const [emails, setEmails] = useState([]);
  const [availableISPs, setAvailableISPs] = useState([]);
  const [availableData, setAvailableData] = useState([]);
  const [selectedData, setSelectedData] = useState('');
  const { setNotification } = useStateContext();
  const [formData, setFormData] = useState({
    rcpt: "",
    fromName: "",
    subject: "",
    start: 0,
    end: 0,
    accountIdStart: 0,
    accountIdEnd: 0,
    htmlContent: "",
  });

  const togleChnge = (e) => {
    setTitle((prevTitle) => (prevTitle === 'Test Form' ? 'Send Form' : 'Test Form'));
  };



  useEffect(() => {
    // Fetch available ISPs and set the default selected ISP
    axiosClient
    .get('/get_data')
    .then((response) => {
      setDataList(response.data);
      // Extract unique ISPs from the data
      const isps = [...new Set(response.data.map((data) => data.isp))];
      setUniqueISPs(isps);
    })
    .catch((error) => console.error('Error fetching data:', error));
  }, [selectedISP]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]:
        name === "start" || name === "end" || name === "accountIdStart" || name === "accountIdEnd"
          ? parseInt(value, 10)
          : value,
    }));
  };

  const handleISPSelect = async (isp) => {
    // Set selectedISP state
    setSelectedISP(isp);

    // Filter available data based on the selected ISP
    const filteredData = dataList.filter((data) => data.isp === isp);
    setAvailableData(filteredData);
  };
  const handleDataSelect = async (dataId) => {
    // Set selectedData state
    setLoading(true);
    setSelectedData(dataId);

    // Fetch data from localhost:8000/get_data_emails based on the selected dataId using axiosClient
    try {
      const response = await axiosClient.post('/data/get_data_count', {
        id: dataId,
      });
      setdataCount(response.data.countData);
      setSmtpCount(response.data.countSMTP);
    } catch (error) {
      console.error('Error fetching emails:', error);
    }
    setLoading(false);
  };


  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      // Send the POST request
      const ispData = dataList.find(item => item.id == selectedData && item.isp == selectedISP);
      var response = await axiosClient.post("email/send", {
        rcpt: formData.rcpt,
        id: selectedData ?? 0,  // Use 0 if selectedData is undefined or null
        data: `${ispData?.isp ?? ''} +" - "+${ispData?.name ?? ''}`,
        accountIdStart: formData.accountIdStart,
        accountIdEnd: formData.accountIdEnd,
        start: formData.start,
        end: formData.end,
        htmlContent: formData.htmlContent,
        fromName: formData.fromName,
        subject: formData.subject
      });
      if (title === 'Send Form') {
        setNotification('Send Completed');
      } else {
        setNotification('Test Completed');
      }

    } catch (error) {
      console.error("Error sending the request:", error);
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      {loading && (
        <div className="loader">
        </div>
      )}
      <div className="email-form-section">
        {title == 'Send Form' && (
        <div className="header">
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
          {selectedData &&
          <div className="select-section">
            <p>NBR Email :  <b>({dataCount})</b> | NBR SMTP : <b>({SmtpCount})</b></p> 
          </div>}
        </div>
          )}
      

        <h2>{title}</h2>
        <div className="toggle-container">
          <label className="switch">
            <input type="checkbox" id="toggleSwitch" onChange={togleChnge} />
            <span className="slider"></span>
          </label>
        </div>

        <form onSubmit={handleSubmit}>
          <div className="form-row">
            <div className="form-group">
              <label htmlFor="fromName">From Name</label>
              <input
                type="text"
                id="fromName"
                name="fromName"
                onChange={handleChange}
                required
              />
            </div>
            <div className="form-group">
              <label htmlFor="subject">Subject</label>
              <input
                type="text"
                id="subject"
                name="subject"
                onChange={handleChange}
                required
              />
            </div>
          </div>
          {(title === "Send Form") && <div className="form-row">
            <div className="form-group">
              <label htmlFor="start">Data Start</label>
              <input
                type="number"
                id="start"
                name="start"
                onChange={handleChange}
                required
              />
            </div>
            <div className="form-group">
              <label htmlFor="end">Data End</label>
              <input
                type="number"
                id="end"
                name="end"
                onChange={handleChange}
                required
              />
            </div>
          </div>}
          <div className="form-row">
            <div className="form-group">
              <label htmlFor="smtpAccountStart">SMTP Start</label>
              <input
                type="number"
                id="accountIdStart"
                name="accountIdStart"
                onChange={handleChange}
                required
              />
            </div>
            <div className="form-group">
              <label htmlFor="smtpAccountEnd">SMTP End</label>
              <input
                type="number"
                id="accountIdEnd"
                name="accountIdEnd"
                onChange={handleChange}
                required
              />
            </div>
          </div>
          <div className="form-row">
            {(title === 'Test Form') && <div className="form-group">
              <label htmlFor="rcpt">RCPT</label>
              <input
                type="email"
                id="rcpt"
                name="rcpt"
                onChange={handleChange}
                required
              />
            </div>}
            <div className="form-group">
              <textarea
                placeholder="put your HTML code here"
                id="htmlContent"
                name="htmlContent"
                onChange={handleChange}
                required
              />
            </div>
          </div>

          <div className="form-group submit-button-container">
            <button type="submit" className="btn-add btn1" onClick={handleSubmit}>
              Send
            </button>
          </div>
        </form>
      </div>
    </>
  );
};

export default EmailForm;
