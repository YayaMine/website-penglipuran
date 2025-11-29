import React from 'react';
import './Home.css';
import { Link } from 'react-router-dom';
import { FaPlay } from 'react-icons/fa'; 

function Home() {
  return (
    <div className="home-page">
      <nav className="navbar">
        <div className="navbar-logo">

          <img src="/logo1.jpg" class="logo" alt="Logo" /> 
        </div>
               
        <div className="navbar-links">
          <Link to="/About">About</Link>
          <Link to="/Contact">Contact</Link>
          <a href="#">My Booking</a> 
        </div>
        <div className="navbar-buttons">
          <Link to="/login" className="nav-btn btn-login">
            Login
          </Link>
          <Link to="/register" className="nav-btn btn-register">
            Registrasi
          </Link>
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