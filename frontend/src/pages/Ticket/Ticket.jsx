import { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import { HiArrowLeft, HiX } from "react-icons/hi";
import api, { createOrder } from "../../service/api";
import "./Ticket.css";

export default function Ticket() {
  const navigate = useNavigate();
  const { state } = useLocation();

  const [loading, setLoading] = useState(true);
  const [paket, setPaket] = useState(null);
  const [ticketVersions, setTicketVersions] = useState([]);
  const [showOrder, setShowOrder] = useState(false);

  const [form, setForm] = useState({
    name: "",
    email: "",
    phone: "",
    visit_date: "",
  });

  const [tickets, setTickets] = useState({
    dewasa: { inter: 0, lokal: 0 },
    anak: { inter: 0, lokal: 0 },
  });


  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      navigate("/login");
    }
  }, [navigate]);

  if (!state?.id) {
    navigate("/booking");
    return null;
  }

  const packageId = state.id;


  useEffect(() => {
    const script = document.createElement("script");
    script.src = "https://app.sandbox.midtrans.com/snap/snap.js";
    script.setAttribute(
      "data-client-key",
      "ISI_DENGAN_CLIENT_KEY_SANDBOX_KAMU"
    );
    script.async = true;
    document.body.appendChild(script);

    return () => {
      document.body.removeChild(script);
    };
  }, []);


  useEffect(() => {
    api
      .get(`/packages/${packageId}`)
      .then((res) => {
        setPaket(res.data);
        setTicketVersions(res.data.ticket_versions || []);
      })
      .catch(() => alert("Gagal mengambil data tiket"))
      .finally(() => setLoading(false));
  }, [packageId]);


  const updateQty = (kategori, tipe, value) => {
    setTickets((prev) => ({
      ...prev,
      [kategori]: {
        ...prev[kategori],
        [tipe]: Math.max(0, prev[kategori][tipe] + value),
      },
    }));
  };


  const totalTiket =
    tickets.dewasa.inter +
    tickets.dewasa.lokal +
    tickets.anak.inter +
    tickets.anak.lokal;

  const totalHarga = ticketVersions.reduce((sum, tv) => {
    const isDewasa = tv.name === "Dewasa";
    const isInter = tv.category.name === "Mancanegara";

    const qty = isDewasa
      ? tickets.dewasa[isInter ? "inter" : "lokal"]
      : tickets.anak[isInter ? "inter" : "lokal"];

    return sum + tv.price * qty;
  }, 0);


  const submitOrder = async (e) => {
    e.preventDefault();

    if (totalTiket === 0) {
      alert("Pilih minimal 1 tiket");
      return;
    }

    const items = ticketVersions
      .map((tv) => {
        const isDewasa = tv.name === "Dewasa";
        const isInter = tv.category.name === "Mancanegara";

        const quantity = isDewasa
          ? tickets.dewasa[isInter ? "inter" : "lokal"]
          : tickets.anak[isInter ? "inter" : "lokal"];

        return {
          ticket_version_id: tv.id,
          quantity,
        };
      })
      .filter((i) => i.quantity > 0);

    try {
      const res = await createOrder({
        package_id: paket.id,
        name: form.name,
        email: form.email,
        phone: form.phone,
        visit_date: form.visit_date,
        items,
      });

      if (!window.snap) {
        alert("Midtrans belum siap");
        return;
      }

      window.snap.pay(res.snap_token, {
        onSuccess: () => {
          alert("Pembayaran berhasil ✅");
          navigate("/booking");
        },
        onPending: () => {
          alert("Menunggu pembayaran ⏳");
        },
        onError: () => {
          alert("Pembayaran gagal ❌");
        },
        onClose: () => {
          alert("Popup ditutup");
        },
      });
    } catch (err) {
      console.error(err.response?.data);
      alert("Gagal membuat pesanan");
    }
  };

  if (loading) return <p style={{ padding: 20 }}>Memuat tiket...</p>;


  return (
    <div className="ticket-page">
      <button className="btn-back" onClick={() => navigate(-1)}>
        <HiArrowLeft />
      </button>

      <h1>
        Pilih Tiket
        <br />
        Kunjungan Anda
      </h1>

      <TicketGroup
        title="Dewasa"
        versions={ticketVersions.filter((tv) => tv.name === "Dewasa")}
        tickets={tickets.dewasa}
        updateQty={(tipe, v) => updateQty("dewasa", tipe, v)}
      />

      <TicketGroup
        title="Anak-Anak"
        versions={ticketVersions.filter((tv) => tv.name === "Anak")}
        tickets={tickets.anak}
        updateQty={(tipe, v) => updateQty("anak", tipe, v)}
      />

      <div className="ticket-summary">
        <p>
          Total Tiket: <strong>{totalTiket}</strong>
        </p>
        <p>
          Total Harga: <strong>Rp {totalHarga.toLocaleString()}</strong>
        </p>
      </div>

      <button className="btn-order" onClick={() => setShowOrder(true)}>
        Pesan Tiket
      </button>

      {showOrder && (
        <div className="order-overlay">
          <div className="order-modal">
            <button className="btn-close" onClick={() => setShowOrder(false)}>
              <HiX />
            </button>

            <h2>Data Pemesan</h2>

            <form onSubmit={submitOrder} className="order-form">
              <input
                required
                placeholder="Nama Lengkap"
                onChange={(e) =>
                  setForm({ ...form, name: e.target.value })
                }
              />
              <input
                type="email"
                required
                placeholder="Email"
                onChange={(e) =>
                  setForm({ ...form, email: e.target.value })
                }
              />
              <input
                required
                placeholder="No. Telepon"
                onChange={(e) =>
                  setForm({ ...form, phone: e.target.value })
                }
              />
              <input
                type="date"
                required
                onChange={(e) =>
                  setForm({ ...form, visit_date: e.target.value })
                }
              />
              <button type="submit">Bayar Sekarang</button>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}



function TicketGroup({ title, versions, tickets, updateQty }) {
  return (
    <div className="ticket-group">
      <h3>{title}</h3>
      <div className="ticket-cards">
        {versions.map((tv) => {
          const isInter = tv.category.name === "Mancanegara";
          const key = isInter ? "inter" : "lokal";
          return (
            <TicketCard
              key={tv.id}
              label={isInter ? "Internasional" : "Indonesia"}
              flag={isInter ? "🌍" : "🇮🇩"}
              harga={tv.price}
              qty={tickets[key]}
              onMinus={() => updateQty(key, -1)}
              onPlus={() => updateQty(key, 1)}
            />
          );
        })}
      </div>
    </div>
  );
}

function TicketCard({ label, flag, harga, qty, onMinus, onPlus }) {
  return (
    <div className={`ticket-card ${qty > 0 ? "active" : ""}`}>
      <span>
        {flag} {label}
      </span>
      <strong>Rp {harga.toLocaleString()}</strong>
      <div className="qty-control">
        <button type="button" onClick={onMinus}>
          −
        </button>
        <span>{qty}</span>
        <button type="button" onClick={onPlus}>
          +
        </button>
      </div>
    </div>
  );
}
