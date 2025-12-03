import React, { useState } from "react";
import EscolaStyle from "../login/login.module.css";

export default function LoginModal({ mostra, fecha }) {
    const [nome, setNome] = useState("");
    const [cep, setCep] = useState("");
    const [endereco, setEndereco] = useState("");
    const [numero, setNumero] = useState("");
    const [cidade, setCidade] = useState("");
    const [estado, setEstado] = useState("");
    const [email, setEmail] = useState("");
    const [senha, setSenha] = useState("");
    const [confirmarSenha, setConfirmarSenha] = useState("");
    const [telefone, setTelefone] = useState("");

    if (!mostra) return null;

    return (
        <div className={EscolaStyle.modalOverlay}>
            <div className={EscolaStyle.modalBoxEscola}>
                <button className={EscolaStyle.closeBtn} onClick={fecha}>
                    <i className="fa-solid fa-circle-xmark" style={{ fontSize: "1.5rem", color: "#000" }}></i>
                </button>
                {/* Primeira Parte */}
                <h2 className={EscolaStyle.modalTitleEscola}>Cadastro Escola</h2>

                {/* Formulario */}
                <form className={EscolaStyle.cadastroForm}>
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>Nome</label>
                    <input
                      type="text"
                      placeholder="Insira seu nome aqui"
                      value={nome}
                      onChange={(e) => setNome(e.target.value)}
                      required
                    />
                    </div>
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>CEP</label>
                    <input
                      type="text"
                      placeholder="Insira seu CEP aqui"
                      value={cep}
                      onChange={(e) => setCep(e.target.value)}
                      required
                    />
                    </div>
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>Endereço</label>
                    <input
                      type="text"
                      placeholder="Insira seu endereço aqui"
                      value={endereco}
                      onChange={(e) => setEndereco(e.target.value)}
                      required
                    />
                    </div>
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>Número</label>
                    <input
                      type="text"
                      placeholder="Insira o número aqui"
                      value={numero}
                      onChange={(e) => setNumero(e.target.value)}
                      required
                    />
                    </div>
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>Cidade</label>
                    <input
                      type="text"
                      placeholder="Insira sua cidade aqui"
                      value={cidade}
                      onChange={(e) => setCidade(e.target.value)}
                      required
                    />
                    </div>
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>Estado</label>
                    <input
                      type="text"
                      placeholder="Insira seu estado aqui"
                      value={estado}
                      onChange={(e) => setEstado(e.target.value)}
                      required
                    />
                    </div>
                    {/* Segunda Parte */}
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>E-mail</label>
                    <input
                      type="email"
                      placeholder="Insira seu e-mail aqui"
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                      required
                    />
                    </div>
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>Telefone</label>
                    <input
                      type="tel"
                      placeholder="Insira seu telefone aqui"
                      value={telefone}
                      onChange={(e) => setTelefone(e.target.value)}
                      required
                    />
                    </div>
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>Senha</label>
                    <input
                      type="password"
                      placeholder="Insira sua senha aqui"
                      value={senha}
                      onChange={(e) => setSenha(e.target.value)}
                      required
                    />
                    </div>
                    <div className={EscolaStyle.cadastroEscola}>
                    <label>Confirmar Senha</label>
                    <input
                      type="password"
                      placeholder="Confirme sua senha aqui"
                      value={confirmarSenha}
                      onChange={(e) => setConfirmarSenha(e.target.value)}
                      required
                    />
                    </div>
                    <p className={EscolaStyle.registerLink}>
                      Ja tem Conta? <a href="./Login.jsx">Faça Login Aqui!!!</a>
                    </p>
                    <button type="submit" className={EscolaStyle.loginBtn}>Cadastrar</button>
                </form>
            </div>
        </div>
    );
}