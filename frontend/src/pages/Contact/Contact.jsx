import React from "react";
import "./Contact.css"; 

export default function Contact() {
  return (
    <div className="contact-container">
      <div className="contact-top">
        <div className="contact-info">
          <h1>Hubungi Kami</h1>
          <p>
            Jika Anda memiliki pertanyaan, membutuhkan informasi lebih lanjut, 
            atau ingin melakukan pemesanan paket wisata, silakan hubungi kami 
            melalui kontak di bawah ini. Tim kami siap membantu Anda dengan 
            senang hati.
          </p>
        </div>

        <div className="contact-image-box">
          <img 
            src="/mnt/data/Screenshot 2025-11-24 061524.png"
            alt="Contact" 
            className="contact-image"
          />
        </div>
      </div>

      <div className="contact-cards">
        <div className="card">
          <div className="icon-circle">
            <span className="icon">📞</span>
          </div>
          <h3>Talk to Sales</h3>
          <p>
            Kami siap membantu Anda mendapatkan pengalaman terbaik selama berwisata di Desa Panglipuran.
          </p>
          <p className="contact-detail">+62 21 3950 4705</p>
        </div>

        <div className="card">
          <div className="icon-circle">
            <span className="icon">✉️</span>
          </div>
          <h3>E-mail</h3>
          <p>
            Silakan hubungi kami untuk informasi tiket, paket wisata, atau pertanyaan lainnya.
          </p>
          <p className="contact-detail">info@panglipuran.id</p>
        </div>
      </div>

      <div className="contact-footer">
        <div>
          <p className="footer-phone">+62 21 3950 4705</p>
          <p className="footer-email">Email: info@panglipuran.id</p>
        </div>

        <button className="btn-contact">Contact</button>
      </div>
    </div>
  );
}
