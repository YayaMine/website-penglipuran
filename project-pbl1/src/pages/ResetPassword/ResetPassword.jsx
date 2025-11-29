import React, { useState } from "react";
import "./reset.css";

export default function ResetPassword() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");

  const handleSubmit = (e) => {
    e.preventDefault();
    if (password !== confirmPassword) {
      alert("Password dan konfirmasi password tidak sama!");
      return;
    }

    alert("Password berhasil direset!");
  };

  return (
    <div className="reset-container">
      <form className="reset-box" onSubmit={handleSubmit}>
        <h1 className="title">Reset Password</h1>

        <input
          type="email"
          placeholder="Email"
          className="input"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />

        <input
          type="password"
          placeholder="Password"
          className="input"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />

        <input
          type="password"
          placeholder="Konfirmasi Password"
          className="input"
          value={confirmPassword}
          onChange={(e) => setConfirmPassword(e.target.value)}
          required
        />

        <button type="submit" className="btn">
          Reset Password
        </button>
      </form>
    </div>
  );
}
