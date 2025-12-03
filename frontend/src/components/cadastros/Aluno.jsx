import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import AlunoStyle from "../login/login.module.css";
import axios from 'axios'; // 1. Importe o axios

export default function CadastroAlunoModal({ mostra, fecha, abrirLogin }) {
    const navigate = useNavigate();
    const [nome, setNome] = useState("");
    const [datanascimento, setDataNascimento] = useState("");
    const [email, setEmail] = useState("");
    const [senha, setSenha] = useState("");
    const [confirmarSenha, setConfirmarSenha] = useState("");
    const [telefone, setTelefone] = useState("");
    const [error, setError] = useState(null);

    if (!mostra) return null;

    const handleCadastro = async (e) => {
        e.preventDefault();
        setError(null);

        if (senha !== confirmarSenha) {
            setError("As senhas não coincidem!");
            return;
        }

        const dadosCadastro = {
            nome: nome,
            dt_nasc: datanascimento,
            email: email,
            senha: senha,
            telefone: telefone,
        };

        try {
            // 2. A chamada da API agora usa axios.post
            // O axios envia o objeto 'dadosCadastro' como JSON automaticamente.
            const response = await axios.post('http://127.0.0.1:8000/api/register', dadosCadastro);
            
            // 3. Em caso de sucesso (status 2xx), o código continua aqui.
            // Os dados da resposta do Laravel já estão em `response.data`.
            fecha();
        } catch (err) {
            // 4. Axios joga um erro para respostas com status 4xx ou 5xx.
            // A resposta do servidor (incluindo os erros de validação) fica em `err.response.data`.
            if (err.response && err.response.data) {
                const errorData = err.response.data;
                if (errorData.messages) {
                    // Concatena todas as mensagens de erro de validação em uma única string.
                    const errorMessages = Object.values(errorData.messages).flat().join(' ');
                    setError(errorMessages);
                } else {
                    setError(errorData.error || 'Ocorreu um erro inesperado ao cadastrar.');
                }
            } else {
                // Caso seja um erro de rede ou o servidor não esteja respondendo.
                setError('Não foi possível conectar ao servidor. Tente novamente mais tarde.');
            }
        }
    };

    return (
        <div className={AlunoStyle.modalOverlay}>
            <div className={AlunoStyle.modalboxAluno}>
                <button className={AlunoStyle.closeBtn} onClick={fecha}>
                    <i className="fa-solid fa-circle-xmark" style={{ fontSize: "1.5rem", color: "#000" }}></i>
                </button>
                <h2 className={AlunoStyle.modalTitleEscola}>Cadastro Aluno</h2>

                <form className={AlunoStyle.cadastroFormAluno} onSubmit={handleCadastro}>
                    <div className={AlunoStyle.cadastroAluno}>
                        <label>Nome</label>
                        <input
                            type="text"
                            placeholder="Insira seu nome aqui"
                            value={nome}
                            onChange={(e) => setNome(e.target.value)}
                            required
                        />
                    </div>
                    <div className={AlunoStyle.cadastroAluno}>
                        <label>Data de Nascimento</label>
                        <input
                            type="date"
                            placeholder="Insira sua data de nascimento aqui"
                            value={datanascimento}
                            onChange={(e) => setDataNascimento(e.target.value)}
                            required
                        />
                    </div>
                    <div className={AlunoStyle.cadastroAluno}>
                        <label>E-mail</label>
                        <input
                            type="email"
                            placeholder="Insira seu e-mail aqui"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                        />
                    </div>
                    <div className={AlunoStyle.cadastroAluno}>
                        <label>Senha</label>
                        <input
                            type="password"
                            placeholder="Insira sua senha aqui"
                            value={senha}
                            onChange={(e) => setSenha(e.target.value)}
                            required
                        />
                    </div>
                    <div className={AlunoStyle.cadastroAluno}>
                        <label>Confirmar Senha</label>
                        <input
                            type="password"
                            placeholder="Confirme sua senha aqui"
                            value={confirmarSenha}
                            onChange={(e) => setConfirmarSenha(e.target.value)}
                            required
                        />
                    </div>
                    <div className={AlunoStyle.cadastroAluno}>
                        <label>Telefone</label>
                        <input
                            type="tel"
                            placeholder="Insira seu telefone aqui"
                            value={telefone}
                            onChange={(e) => setTelefone(e.target.value)}
                            required
                        />
                    </div>
                    
                    {error && <p style={{ color: 'red', textAlign: 'center', marginTop: '10px' }}>{error}</p>}

                    <p className={AlunoStyle.registerLink}>
                        Já tem conta?{" "}
                        <a href="#" onClick={(e) => {
                            e.preventDefault();
                            fecha();
                            abrirLogin();
                        }}>
                            Faça Login Aqui!!!
                        </a>
                    </p>
                    <button type="submit" className={AlunoStyle.loginBtn}>Cadastrar</button>
                </form>
            </div>
        </div>
    );
}