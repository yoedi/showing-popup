import React, { useEffect, useState } from "react";

const Popup = () => {
  const [popups, setPopups] = useState([]);

  useEffect(() => {
    const pageId = window.wp_data && window.wp_data.page_id ? window.wp_data.page_id : null;
    const isLoggedIn = window.wp_data && window.wp_data.isLoggedIn ? window.wp_data.isLoggedIn : false;

    if (pageId == null || isLoggedIn == false) {
      return;
    }

    fetch(`/wp-json/artistudio/v1/popup?page_id=${pageId}`, {
      method: "GET",
      headers: {
        "X-WP-Nonce": window.wp_data.nonce,
      },
      credentials: "include",
    })
      .then((res) => res.json())
      .then((data) => setPopups(data));
  }, []);

  return (
    <>
      {popups.map((popup, index) => (
        <div key={index} className="popup-overlay">
          <div className="popup-content">
            <button className="popup-close" onClick={() => document.querySelector(".popup-overlay").remove()}>x</button>
            <h2>{popup.title}</h2>
            <div dangerouslySetInnerHTML={{ __html: popup.content }} />
          </div>
        </div>
      ))}
    </>
  );
};

export default Popup;