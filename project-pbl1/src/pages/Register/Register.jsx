import React, { useState } from "react";
import "./Register.css";

function Register() {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    confirmPassword: "",
  });

  
  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    if (formData.password !== formData.confirmPassword) {
      alert("Kata sandi tidak cocok!");
      return;
    }

    alert("Pendaftaran berhasil!");
    console.log("Data user:", formData);
  };

  return (
    <div className="register-container">
      <div className="register-card">
        
        <h1>Daftar Akun Baru</h1>

        <form onSubmit={handleSubmit}>
          <input
            type="text"
            name="name"
            placeholder="Nama"
            value={formData.name}
            onChange={handleChange} 
            required
          />
          <input
            type="email"
            name="email"
            placeholder="Email"
            value={formData.email}
            onChange={handleChange} 
            required
          />
          <input
            type="password"
            name="password"
            placeholder="Kata Sandi"
            value={formData.password}
            onChange={handleChange} 
            required
          />
          <input
            type="password"
            name="confirmPassword"
            placeholder="Konfirmasi Kata Sandi"
            value={formData.confirmPassword}
            onChange={handleChange} 
            required
          />
          <button type="submit">Daftar Sekarang</button>
        </form>

        <p>
          Sudah Punya Akun? <a href="login">Masuk Disini</a>
        </p>
      </div>
    </div>
  );
}

export default Register;