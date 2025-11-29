import React from "react";
import "./About.css";
import { Link } from "react-router-dom";

export default function About() {
  return (
    <div className="dest-container">

      
      <div className="dest-hero">
        <img 
          src="/desa1.jpg" alt="Background"
          className="dest-bg"
        />

        
        <div className="dest-text">
          <h1 className="dest-title">EXPLORE</h1>
          <h1 className="dest-title">DREAM</h1>
          <h1 className="dest-outline">DESTINATION</h1>

          <p className="dest-desc">
            Desa Penglipuran adalah salah satu desa terbersih di dunia yang 
            memadukan keindahan alam dengan budaya Bali yang kental. Setiap 
            rumah di sini dibangun dengan arsitektur tradisional dan nilai 
            kesopanan serta gotong royong masih dijunjung tinggi oleh warganya.
          </p>

          <button className="btn-home">
            <Link to="/Home" className="btn-home">HOME ◄◄◄</Link>
          </button>
        </div>

        <div className="dest-cards">
          <div className="card">
            <img src="/desa1.jpg" alt="" className="card-img" />   
            <Link to="/Akomodasi" className="card-btn">AKOMODASI</Link>
          </div>

          <div className="card">
            <img src="/desa2.jpg" alt="" className="card-img" />
            <button className="card-btn">GALLERY</button>
          </div>

          <div className="card">
            <img src="/desa1.jpg" alt="" className="card-img" />
            <button className="card-btn">CULTURE</button>
          </div>
        </div>
      </div>
    </div>
  );
}
