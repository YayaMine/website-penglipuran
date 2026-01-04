import React, { useEffect, useState } from "react";
import "./Home.css";
import { Link, useNavigate } from "react-router-dom";
import { FaPlay } from "react-icons/fa";

function Home() {
  const navigate = useNavigate();
  const [isLogin, setIsLogin] = useState(false);

  useEffect(() => {
    const token = localStorage.getItem("token");
    setIsLogin(!!token);
  }, []);

  const handleLogout = () => {
    if (window.confirm("Yakin ingin logout?")) {
      localStorage.removeItem("token");
      localStorage.removeItem("user"); 
      setIsLogin(false);
      navigate("/login");
    }
  };

  return (
    <div className="home-page">
      <nav className="navbar">
        <div className="navbar-logo">
      
          <img src="/logo1.jpg" className="logo" alt="Logo" />
        </div>

        <div className="navbar-links">
          <Link to="/about">About</Link>
          <Link to="/contact">Contact</Link>
          <Link to="/booking">Booking</Link>
        </div>

        <div className="navbar-buttons">
          {!isLogin ? (
            <>
              <Link to="/login" className="nav-btn btn-login">
                Login
              </Link>
              <Link to="/register" className="nav-btn btn-register">
                Registrasi
              </Link>
            </>
          ) : (
            <button
              onClick={handleLogout}
              className="nav-btn btn-login"
            >
              Logout
            </button>
          )}
        </div>
      </nav>

      <main className="hero-container">
        <div className="hero-content">
          <h1>Your Whole Vacation Starts Here</h1>
          <div className="hero-buttons">
            <button className="btn-view-more">
              View More <span>&rarr;</span>
            </button>
            <button className="btn-play">
              <FaPlay />
            </button>
          </div>
        </div>
      </main>
    </div>
  );
}

export default Home;
