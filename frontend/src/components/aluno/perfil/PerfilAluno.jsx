import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axios from "axios";

import Style from "./perfil.module.css";
import Ajuste from "../../containerPadrao.module.css";

// Import Componentes
import Header from "../../layout/headers/HeaderAluno";

export default function TelaAlunoPerfil() {
    // const navigate = useNavigate();
    const [usuario, setUsuario] = useState({});
    const { alunoId } = useParams();
    const [materias, setMaterias] = useState([]);

    const coresPorMateria = {
        "Matemática": "#1565C0",
        "Português": "#E53935",
        "Inglês": "#9575CD",
        "História": "#8D6E63",
        "Geografia": "#26A69A",
        "Química": "#43A047",
        "Física": "#366091",
        "Artes": "#FF7043",
        "Educação Física": "#6C6C6C",
    };

    useEffect(() => {
        if (!alunoId) return;

        carregarDados();
        carregarProgresso();
    }, [alunoId]);

    const carregarProgresso = () => {
        axios.get(`http://localhost:8000/api/alunos/${alunoId}/progresso`)
            .then(res => {
                const response = res.data.map(item => ({
                    text: item.materia,
                    progresso: item.realizadas,
                    total: item.total_p,
                    cor: coresPorMateria[item.materia] || "#141531"
                }));

                setMaterias(response);
            })
            .catch(error => console.error(error));
    }

    const carregarDados = () => {
        axios.get(`http://localhost:8000/api/alunos/${alunoId}/dados`)
            .then(res => {
                setUsuario(res.data);
            })
            .catch(error => console.error(error));
    }

    return (
        <div className={Ajuste.wrapper}>
            <Header />
            <main className={Ajuste.container}
                style={{
                    backgroundColor: usuario.fundo,
                }}
            >
                <div className={Style.container}>
                    <div className={Style.divGeral}>
                        <div className={Style.divFotoNome}>
                            <img src={usuario.avatar || "/imgs/perfil/boy_black.webp"}
                                className={Style.imgPerfil}
                                alt="Imagem de Perfil" draggable="false"
                                style={{
                                    border: `0.8rem solid ${usuario.borda}`,
                                    boxShadow: `0 0 10px ${usuario.borda}`,
                                }} />
                            <h1 className={Style.nomeAluno}>{usuario.nome}</h1>
                        </div>
                        <div className={Style.divNivelEditar}>
                            <h1 className={Style.divNivel}>
                                Nível
                                <span className={Style.nivel}>
                                    {usuario.nivel}
                                </span>
                            </h1>
                            <div className={Style.divInsigna}>
                                <div className={Style.insigna}>
                                    <img src={require('../../../imgs/insigna.png')} draggable="false"
                                        alt="é só um teste" />
                                    <p>Warlord</p>
                                </div>
                            </div>
                            <button className={Style.editar}
                                onClick={() => { alert("Calma que ainda não tem isso!!!") }}
                            >
                                Editar Perfil
                            </button>
                        </div>
                    </div>
                    <hr className={Style.divisao} />
                    {/* Segunda Parte do Perfil */}
                    <div className={Style.divDashboard}>
                        <div>
                            {materias.map((materia, index) => (
                                <div key={index}>
                                    <div className={Style.divMateria}>
                                        <div style={{ backgroundColor: "#fff", width: "15rem", height: "8rem" }}></div>
                                        <h1>{materia.text}</h1>
                                    </div>
                                    <div className={Style.divProgresso}>
                                        <p><b>Progresso na matéria:</b> {materia.progresso} de {materia.total}</p>
                                        <div className={Style.barraProgresso}>
                                            <div className={Style.barraCheia}
                                                style={{
                                                    width: `${(materia.progresso / materia.total) * 100}%`,
                                                    backgroundColor: materia.cor
                                                }}
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                        <div className={Style.divConquistasRecentes}>
                            <h1>Conquistas<br />Recentes</h1>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    )
}