import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { FiArrowLeft } from "react-icons/fi";
import api from "../../service/api";
import "./Booking.css";

export default function Booking() {
  const navigate = useNavigate();
  const [paketData, setPaketData] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {

    const token = localStorage.getItem("token");
    if (!token) {
      navigate("/login");
      return;
    }

    window.scrollTo(0, 0);

    api.get("/packages")
      .then((res) => setPaketData(res.data))
      .catch(() => alert("Gagal mengambil data paket"))
      .finally(() => setLoading(false));
  }, [navigate]);

  const pilihPaket = (paket) => {
    navigate("/ticket", { state: paket });
  };

  return (
    <div className="booking-page">
      <div className="booking-container">

        <button className="btn-back" onClick={() => navigate("/")}>
          <FiArrowLeft />
        </button>

        <div className="booking-header">
          <h1>Pilihan Paket</h1>
        </div>

        <div className="paket-grid">
          {loading ? (
            <p>Memuat paket...</p>
          ) : paketData.length === 0 ? (
            <p>Paket belum tersedia</p>
          ) : (
            paketData.map((paket) => (
              <div className="paket-card" key={paket.id}>
                <h3 className="paket-title">{paket.name}</h3>

                <p className="paket-desc">
                  {paket.description ?? "Deskripsi paket belum tersedia"}
                </p>

             
                {paket.price && (
                  <p className="paket-price">
                    Rp {paket.price.toLocaleString()}
                  </p>
                )}

                <button onClick={() => pilihPaket(paket)}>
                  Pilih Paket
                </button>
              </div>

            ))
          )}
        </div>

        <div className="review-section">
          <h2>Reviews</h2>
          <div className="review-grid">
            <div className="review-card"><div className="avatar" /></div>
            <div className="review-card"><div className="avatar" /></div>
            <div className="review-card"><div className="avatar" /></div>
          </div>
          <div className="comment-area">
            <label>Tulis Komentar:</label>
            <div className="comment-box">
              <input placeholder="Bagikan pengalaman kamu..." />
              <button>Kirim Komentar</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  );
}
