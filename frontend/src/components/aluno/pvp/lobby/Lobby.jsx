import React, { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axios from "axios";

import Style from "./lobby.module.css";
import Ajuste from "../../../containerPadrao.module.css";

// Import Componentes
import Header from "../../../layout/headers/HeaderAluno";
import CardReady from "./card-ready/CardReady";

export default function TelaPvpLobby(){
    const navigate = useNavigate();
    const [aluno, setAluno] = useState(null);
    const { adversarioId } = useParams();
    const [adversario, setAdversario] = useState(null);

    useEffect(() => {
        const usuarioId = localStorage.getItem("usuarioId");

        if(usuarioId){
            axios.get("/usuarios.json")
            .then(res => {
                const usuarios = res.data;
                setAluno(usuarios.find(u => u.id === parseInt(usuarioId)));
                setAdversario(usuarios.find(u => u.id === parseInt(adversarioId)));
            })
            .catch(err => console.error(err));
        }
    }, []);

    if (!aluno || !adversario) return <p>Carregando...</p>;

    return(
        <div className={Ajuste.wrapper}>
            <Header />
            <main className={Ajuste.container}>
                <div className={Style.divTopTitulo}>
                    <h1>Perguntas PvP</h1>
                    <div className={Style.btnSair} onClick={()=>{navigate(-1)}}>
                        <p>Sair</p>
                    </div>
                </div>
                <div className={Style.divPrincipal}>
                    <div className={Style.divCardsVS}>
                        <CardReady nome={aluno.nome} avatar={aluno.avatar} borda={aluno.borda} />
                        <h1 className={Style.versus}>VS</h1>
                        <CardReady nome={adversario.nome} avatar={adversario.avatar} borda={adversario.borda} />
                    </div>
                    <div className={Style.btnComeçar}>
                        <p>Começar Duelo</p>
                    </div>
                </div>
            </main>
        </div>
    )
}