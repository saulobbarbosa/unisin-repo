import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import Swal from 'sweetalert2';

import HeaderStyle from "./header.module.css";

// Import Componentes

export default function CompHeaderAluno({ atualizar }) {
    const navigate = useNavigate();
    const idAluno = localStorage.getItem("idUsuario");
    const [mostrar, setMostrar] = useState(false);
    const [usuario, setUsuario] = useState({});

    const alertSair = () => {
        Swal.fire({
            title: "Quer Realmente Sair?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sim, Quero Sair!",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#295384"
        }).then((result) => {
            if (result.isConfirmed) {
                sair();
            }
        });
    }

    const sair = async () => {
        try {
            localStorage.removeItem("idUsuario");
            localStorage.removeItem("tipoUsuario");
            localStorage.removeItem("token");
            navigate('/');
        } catch (error) {
            console.log(`Erro: ${error}`);
        }
    };

    useEffect(() => {    
        if (!idAluno) return;
        carregarHeader();
    }, [atualizar]);

    const carregarHeader = () => {
        axios.get(`http://localhost:8000/api/alunos/${idAluno}/dados`)
            .then(res => {
                setUsuario(res.data);
            })
            .catch(error => console.error(error));
    }


    return (
        <div className={HeaderStyle.headerContainer} onMouseLeave={() => { setMostrar(false) }}>
            <img src={require('../../../imgs/logo.png')} alt="logo do unisin"
                className={HeaderStyle.logo} draggable="false" />
            {/* Parte das Info */}
            <div className={HeaderStyle.headerMenu} style={{ marginRight: "2rem" }}>
                <div className={HeaderStyle.divNMP} onClick={() => { navigate("/aluno/home") }}>
                    <p>Nível</p>
                    <p>{usuario.nivel}</p>
                </div>
                <div className={HeaderStyle.divNMP} onClick={() => { navigate("/aluno/loja") }}>
                    <img src={require('../../../imgs/moeda.png')} alt="icone de moeda"
                        className={HeaderStyle.imgMoeda} draggable="false" />
                    <p>{usuario.moedas}</p>
                </div>
                <div className={HeaderStyle.divPerfil + " " + HeaderStyle.divNMP}
                    onMouseEnter={() => { setMostrar(true) }}
                    onClick={() => { navigate(`/aluno/perfil/${localStorage.getItem("idUsuario")}`) }}
                >
                    <img src={usuario.avatar} className={HeaderStyle.imgPerfil}
                        alt="Imagem de Perfil" draggable="false"
                        style={{
                            border: `0.3rem solid ${usuario.borda}`
                        }} />
                </div>
            </div>
            {/* Parte do Modal */}
            <div className={`${HeaderStyle.divModalNavegacao} ${mostrar ? HeaderStyle.show : HeaderStyle.hide}`}
                onMouseLeave={() => { setMostrar(false) }}
            >
                <div className={HeaderStyle.divEscolhas} onClick={() => { navigate("/aluno/home") }}>
                    <i className="fa-solid fa-house" style={{
                        fontSize: "2.5rem", color: "#000",
                        marginLeft: "2rem"
                    }}></i>
                    <h1 className={HeaderStyle.textEscolhas}>Home</h1>
                </div>
                <hr className={HeaderStyle.linhaModal} />
                <div className={HeaderStyle.divEscolhas} onClick={() => { navigate(`/aluno/perfil/${localStorage.getItem("idUsuario")}`) }}>
                    <i className="fa-solid fa-user" style={{
                        fontSize: "2.5rem", color: "#000",
                        marginLeft: "2rem"
                    }}></i>
                    <h1 className={HeaderStyle.textEscolhas}>Perfil</h1>
                </div>
                <hr className={HeaderStyle.linhaModal} />
                <div className={HeaderStyle.divEscolhas} onClick={() => { navigate("/aluno/amigos") }}>
                    <i className="fa-solid fa-people-group" style={{
                        fontSize: "2.5rem", color: "#000",
                        marginLeft: "2rem"
                    }}></i>
                    <h1 className={HeaderStyle.textEscolhas}>Amigos</h1>
                </div>
                <hr className={HeaderStyle.linhaModal} />
                <div className={HeaderStyle.divEscolhas} onClick={() => { navigate("/aluno/loja") }}>
                    <i className="fa-solid fa-store" style={{
                        fontSize: "2.5rem", color: "#000",
                        marginLeft: "2rem"
                    }}></i>
                    <h1 className={HeaderStyle.textEscolhas}>Loja</h1>
                </div>
                <hr className={HeaderStyle.linhaModal} />
                <div className={HeaderStyle.divEscolhas} onClick={() => { navigate(`/aluno/inventario/${localStorage.getItem("idUsuario")}`) }}>
                    <i className="fa-solid fa-cubes" style={{
                        fontSize: "2.5rem", color: "#000",
                        marginLeft: "2rem"
                    }}></i>
                    <h1 className={HeaderStyle.textEscolhas}>Inventário</h1>
                </div>
                <hr className={HeaderStyle.linhaModal} />
                <div className={HeaderStyle.divEscolhas} onClick={() => { navigate("/aluno/conquistas") }}>
                    <i className="fa-solid fa-medal" style={{
                        fontSize: "2.5rem", color: "#000",
                        marginLeft: "2rem"
                    }}></i>
                    <h1 className={HeaderStyle.textEscolhas}>Conquistas</h1>
                </div>
                <hr className={HeaderStyle.linhaModal} />
                <div className={HeaderStyle.divEscolhas} onClick={() => { navigate("/aluno/ranking") }}>
                    <i className="fa-solid fa-ranking-star" style={{
                        fontSize: "2.5rem", color: "#000",
                        marginLeft: "2rem"
                    }}></i>
                    <h1 className={HeaderStyle.textEscolhas}>Ranking</h1>
                </div>
                <hr className={HeaderStyle.linhaModal} />
                <div className={HeaderStyle.divEscolhas} onClick={alertSair}>
                    <i className="fa-solid fa-right-from-bracket" style={{
                        fontSize: "2.5rem", color: "#000",
                        marginLeft: "2rem"
                    }}></i>
                    <h1 className={HeaderStyle.textEscolhas}>Sair</h1>
                </div>
            </div>
        </div>
    );
}