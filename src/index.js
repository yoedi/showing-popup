import React from "react";
import ReactDOM from "react-dom/client";
import Popup from "./Popup";
import "./styles.css";

const container = document.getElementById("popup-root");
const root = ReactDOM.createRoot(container);

root.render(<Popup />);
