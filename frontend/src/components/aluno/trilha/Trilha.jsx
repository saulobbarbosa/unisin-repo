import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axios from "axios";

import Style from "./trilha.module.css";
import Ajuste from "../../containerPadrao.module.css";

// Import Componentes
import Header from "../../layout/headers/HeaderAluno";
import Barra from "../barra-top/BarraTop";

const classes = [
    "primeiro", "segundo", "terceiro",
    "quarto", "quinto", "sexto",
]

export default function TelaAlunoTrilha() {
    const navigate = useNavigate();
    const { materia, idMateria } = useParams();
    const [atividades, setAtividades] = useState([]);
    const [level, setLevel] = useState(1);
    const idUsuario = localStorage.getItem("idUsuario");

    useEffect(() => {
        async function carregarQuiz() {
            try {
                const response = await axios.get(
                    `http://localhost:8000/api/quiz/${idMateria}/${level}/${idUsuario}`
                );

                setAtividades(response.data);
            } catch (err) {
                console.error("Erro ao carregar perguntas:", err);
            }
        }

        carregarQuiz();
    }, [materia, idMateria, idUsuario]);

    return (
        <div className={Ajuste.wrapper}>
            <Header />
            <main className={Ajuste.container}>
                <Barra level={level} />
                <div className={Style.divConquista}>
                    <h2 className={Style.tituloConquista}>Conquistas</h2>
                </div>
                <div className={Style.trilha}>
                    {atividades.map((atv, index) => {
                        const classeExtra = classes[index % classes.length];
                        const deslocamento = Math.sin(index * 0.7) * 6; // amplitude horizontal
                        const classeStatus =
                            atv.status === "correto"
                                ? Style.correto
                                : atv.status === "errado"
                                ? Style.errado
                                : Style.pendente;
                        return (
                            <div
                                key={atv.id}
                                className={`${Style.etapa} ${Style[classeExtra]} ${classeStatus}`}
                                style={{ marginLeft: `${deslocamento}rem`, marginTop: "1rem" }}
                                onClick={() => {
                                    if(atv.status != "correto"){
                                        navigate(`/aluno/${materia}/${idMateria}/atividade/${atv.id}`)
                                    }
                                }}
                            >
                                {index + 1} 
                            </div>
                        );
                    })}
                </div>
            </main>
        </div>
    )
}