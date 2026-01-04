import "./Akomodasi.css";
import { Link } from "react-router-dom";

export default function Akomodasi() {
  return (
    <div className="akomodasi-container">
      
      
      <div className="nav-back">
        <Link to="/about">
          <img 
            src="/icons/back.svg" 
            alt="back" 
            className="back-icon"
          />
        </Link>
      </div>

      
      <div className="hero-akomodasi">
        <img src="/desa1.jpg" alt="Penglipuran"
          className="akomodasi-hero-img"
        />
        <div className="hero-text">
          <h1>
            NIKMATI KEINDAHAN <br />
            DESA PENGLIPURAN <br />
            AKOMODASI
          </h1>
        </div>
      </div>

      <div className="akomodasi-content">

        <section className="akomodasi-section">
          <h2>Homestay & Guest House Desa Penglipuran</h2>
          <p>
            Terdapat juga hotel, villa atau guest house yang lebih besar dan modern 
            di sekitar area Penglipuran.
            <a href="https://tiket.com" target="_blank" rel="noreferrer">
              tiket.com
            </a>
          </p>
          <p>
            Cocok jika kamu mencari kenyamanan lebih atau fasilitas yang agak “hotel”, 
            bukan homestay sederhana.
          </p>
        </section>

        <section className="akomodasi-section">
          <h2>Akomodasi di luar atau dekat desa</h2>
          <p>
            Terdapat juga hotel, villa atau guest house yang lebih besar dan modern 
            di sekitar area Penglipuran.
            <a href="https://tiket.com" target="_blank" rel="noreferrer">
              tiket.com
            </a>
          </p>
          <p>
            Cocok jika kamu mencari kenyamanan lebih atau fasilitas yang agak “hotel”, 
            bukan homestay sederhana.
          </p>
        </section>

      </div>
    </div>
  );
}
