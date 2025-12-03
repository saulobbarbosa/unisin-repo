import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import Swal from 'sweetalert2';

import Style from "./ranking.module.css";
import Ajuste from "../../containerPadrao.module.css";

// Import Componentes
import Header from "../../layout/headers/HeaderAluno";

export default function TelaAlunoRanking(){
    const navigate = useNavigate();
    const [trocar, setTrocar] = useState(false);
    const [ranking, setRanking] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get("/ranking.json")
        .then(res => {
            setRanking(res.data)
            setLoading(false)
        })
        .catch(err => {
            console.error(err)
            Swal.fire({
                icon: "error",
                title: "Erro ao carregar o ranking",
                text: "Tente novamente mais tarde.",
            })
        });
    }, []);

    if (loading) return <p style={{ color: "#fff" }}>Carregando...</p>;
    if (!ranking) return null;

    const listaAtual = trocar ? ranking.exatas : ranking.humanas;

    return(
        <div className={Ajuste.wrapper}>
            <Header />
            <main className={Ajuste.container}>
                <h1 className={Style.tituloTop}>Ranking Semanal</h1>
                {/* Botão de troca */}
                <div className={trocar === false ? Style.divMudaRank1 : Style.divMudaRank2}>
                    <i className={`fa-solid fa-chevron-${trocar ? "left" : "right"}`}
                      style={{ fontSize: "4rem", color: "#fff", cursor: "pointer" }}
                      onClick={() => setTrocar(!trocar)}
                    ></i>
                </div>
                <h2 className={Style.tituloArea}>
                    {trocar ? "Exatas" : "Humanas"}
                </h2>
                {/* Lista de jogadores */}
                {listaAtual.map((aluno, index) => (
                    <div key={aluno.id} className={Style.lista}>
                        <p>{index + 1}</p>
                        <p>{aluno.nome}</p>
                        <div className={Style.destaqueMoedas}>
                            <img src={require("../../../imgs/moeda.png")} alt="icone de moeda"
                            className={Style.img} draggable="false" />
                            {aluno.moedas}
                        </div>
                    </div>
                ))}
            </main>
        </div>
    )
}