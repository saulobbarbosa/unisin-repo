import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";

import Style from "./alunoHome.module.css";
import Ajuste from "../../containerPadrao.module.css";

// Import Componentes
import Header from "../../layout/headers/HeaderAluno";

export default function TelaAlunoHome(){
    const navigate = useNavigate();

    const idUsuario = localStorage.getItem("idUsuario");
    const [modulos, setModulos] = useState([]);

    const cores = {
        "Matemática": "#1565C0",
        "Português": "#E53935",
        "Inglês": "#9575CD",
        "História": "#8D6E63",
        "Geografia": "#26A69A",
        "Química": "#43A047",
        "Física": "#366091",
        "Artes": "#FF7043",
        "Educação-Física": "#6C6C6C",
    };
    
    useEffect(() => {
        if (!idUsuario) return;

        axios.get(`http://localhost:8000/api/alunos/${idUsuario}/modulos`)
            .then(res => {
                const formatados = res.data.map(item => ({
                    text: item.nome_modulo,
                    id: item.id_modulo,
                    cor: cores[item.nome_modulo] || "#141531"
                }));
                setModulos(formatados);
            })
            .catch(error => console.error(error));
    }, [idUsuario]);

    return(
        <div className={Ajuste.wrapper}>
            <Header />
            <main className={Ajuste.container}>
                <h1 className={Style.tituloHome}>Área de estudo: escolha seu destino</h1>
                <div className={Style.divMenu}>
                    {modulos.map(({ text, cor, id }, index) => (
                        <div key={index} className={Style.divEscolha} style={{ color: cor }} 
                            onClick={()=>{navigate(`/aluno/${text}/${id}`)}}
                        >
                            <h2>{text}</h2>
                        </div>
                    ))}
                </div>
            </main>
        </div>
    )
}