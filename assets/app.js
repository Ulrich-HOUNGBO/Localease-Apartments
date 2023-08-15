import './styles/app.scss';
import React from 'react'
import ReactDOM from 'react-dom/client'
import Navbar from "./components/Navbar";
import Home from "./pages/Home";
import DashBoard from "./pages/DashBoard";
import {HashRouter, Route, Routes} from "react-router-dom";

const App = () =>  {
    return (
        <HashRouter>
            <Navbar />
            <Routes>
                <Route path="/dashboard" element={<DashBoard />} />
                <Route path="/" element={<Home />} />
            </Routes>
        </HashRouter>
    )
}


const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
    <React.StrictMode>
            <App />
    </React.StrictMode>
)
