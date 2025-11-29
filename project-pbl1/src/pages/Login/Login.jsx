import React from 'react';
import './Login.css'; 

function Login() {
  return (
   
    <div className="login-container">
      
      <div className="login-card">
        
        <h1 className="login-title">LOGIN</h1>
        <div className="underline"></div>

        <form className="login-form">
          <input type="email" placeholder="E-mail" className="login-input" />
          <input type="password" placeholder="Password" className="login-input" />
          <button type="submit" className="login-button">LOGIN</button>
          <p></p>
        </form>
        <a href="ResetPassword">Reset Password</a>
        <p>
          Belum Punya Akun? <a href="Register">Masuk Disini</a>
        </p>

      </div> 
    </div> 
  );
}

export default Login;