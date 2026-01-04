import React from 'react';
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

//  Impor Halaman-halaman 
import Register from "./pages/Register/Register";
import Login from "./pages/Login/Login";
import Home from "./pages/Home/Home"; 
import ResetPassword from "./pages/ResetPassword/ResetPassword";
import Contact from "./pages/Contact/Contact";
import About from "./pages/About/About";
import Akomodasi from "./pages/Akomod/Akomodasi";
import Booking from "./pages/Booking/Booking";
import Ticket from "./pages/Ticket/Ticket";
// import Order from "./pages/Order/Order";

function App() {
  return (
    <Router>
      <Routes>
        //biar path/    
         <Route path="/" element={<Home />} />
         //biar path/
        <Route path="/register" element={<Register />} />
        <Route path="/login" element={<Login />} />
        <Route path="/resetpassword" element={<ResetPassword />} />
        <Route path="/home" element={<Home />} />
        
        <Route path="/contact" element={<Contact />} />
        <Route path="/about" element={<About />} />
        <Route path="/akomodasi" element={<Akomodasi />} />
        <Route path="/booking" element={<Booking />} />
        <Route path="/ticket" element={<Ticket />} />
        {/* <Route path="/order" element={<Order />} /> */}
      </Routes>
    </Router>
  );
}

export default App;