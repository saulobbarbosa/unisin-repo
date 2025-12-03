import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import Swal from "sweetalert2";

import LoginStyle from "./login.module.css";
import CadastroAlunoModal from "../cadastros/Aluno";

// Import Componente

export default function LoginModal({ mostra, fecha }) {
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [senha, setSenha] = useState("");
  const [mostrarCadastro, setMostrarCadastro] = useState(false);

  if (!mostra) return null;

  const alertError = () => {
    Swal.fire({
      title: 'O usuário ou senha está Incorreto!',
      icon: 'error',
      confirmButtonText: 'OK',
      confirmButtonColor: '#295384'
    });
  }



  const logar = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.post("http://localhost:8000/api/login", {
        email: email,
        senha: senha
      });
      if (response.data.success){
        const usuario = response.data.usuario;
        if (usuario) {
          // Salva dados do usuário no localStorage
          localStorage.setItem("idUsuario", usuario.id_usuario);
          localStorage.setItem("tipoUsuario", usuario.tipo_usuario ?? "aluno");
          localStorage.setItem("token", response.data.token);

          let destino = "/aluno/home";

          if (usuario.tipo === "professor") {
            destino = "/professor/home";
          } else if (usuario.tipo === "escola") {
            destino = "/escola/home";
          }

          setTimeout(() => {
            navigate(destino);
          }, 2000);
        } else {
          alertError();
        }
      } else {
        alertError();
      }

    } catch (error) {
      console.error(error);
      Swal.fire({
        icon: "error",
        title: "Erro",
        text: "Não foi possível fazer login. Verifique as informações.",
      });
    }
  };

  return (
    <div className={LoginStyle.modalOverlay}>
      <div className={LoginStyle.modalBox}>
        <button className={LoginStyle.closeBtn} onClick={fecha}>
          <i className="fa-solid fa-circle-xmark" style={{ fontSize: "1.5rem", color: "#000" }}></i>
        </button>
        {/* Primeira Parte */}
        <h2 className={LoginStyle.modalTitle}>Login</h2>
        <img src={require('../../imgs/logo.jpg')} className={LoginStyle.loginLogo} />
        {/* Formulario */}
        <form onSubmit={logar}>
          <label>E-mail</label>
          <input
            type="email"
            placeholder="Insira seu e-mail aqui"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />
          <label>Senha</label>
          <input
            type="password"
            placeholder="Insira sua senha aqui"
            value={senha}
            onChange={(e) => setSenha(e.target.value)}
            required
          />
          <p className={LoginStyle.registerLink}>
            Não tem conta?{" "}
            <a href="#" onClick={(e) => {
              e.preventDefault();
              setMostrarCadastro(true); // abre cadastro
            }} > Cadastre-se Agora!!!
            </a>
          </p>
          <button type="submit" className={LoginStyle.loginBtn}>
            Entrar
          </button>
        </form>
      </div>
      <CadastroAlunoModal // O componente ta que nem no header home
        mostra={mostrarCadastro}
        fecha={() => setMostrarCadastro(false)}
        abrirLogin={() => setMostrarCadastro(false)} // quando clicar "Já tem conta"
      />
    </div>
  );
}
