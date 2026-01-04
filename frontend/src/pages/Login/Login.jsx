import React, { useState } from "react";
import "./Login.css";
import api from "../../service/api"; 

function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    try {
      const response = await api.post("/login", {
        email: email,
        password: password,
      });

      // simpan token
      localStorage.setItem("token", response.data.token);

      alert("Login berhasil ✅");

      // redirect setelah login
      window.location.href = "/";

    } catch (error) {
      console.error(error.response?.data);
      alert(
        error.response?.data?.message ||
        "Email atau password salah"
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="login-container">
      <div className="login-card">
        <h1 className="login-title">LOGIN</h1>
        <div className="underline"></div>

        {/* DESAIN TIDAK DIUBAH */}
        <form className="login-form" onSubmit={handleSubmit}>
          <input
            type="email"
            placeholder="E-mail"
            className="login-input"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />

          <input
            type="password"
            placeholder="Password"
            className="login-input"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />

          <button
            type="submit"
            className="login-button"
            disabled={loading}
          >
            {loading ? "Memproses..." : "LOGIN"}
          </button>
        </form>

        <a href="/reset-password">Reset Password</a>

        <p>
          Belum Punya Akun? <a href="/register">Daftar Disini</a>
        </p>
      </div>
    </div>
  );
}

export default Login;
