import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axios from "axios";
import Swal from 'sweetalert2';

import Style from "./atividade.module.css";
import Ajuste from "../../containerPadrao.module.css";

// Import Componentes
import Header from "../../layout/headers/HeaderAluno";
import Barra from "../barra-top/BarraTop";

export default function TelaAtividade() {
    const navigate = useNavigate();
    const { materia, idMateria, idAtividade } = useParams();
    const [atividade, setAtividade] = useState(null);
    const [level, setLevel] = useState(1);
    const [respostaSelecionada, setRespostaSelecionada] = useState(null);
    const idUsuario = localStorage.getItem("idUsuario");

    useEffect(() => {
        async function carregarQuiz() {
            try {
                const response = await axios.get(
                    `http://localhost:8000/api/perguntas/${idAtividade}/jogar`
                );

                setAtividade(response.data);
            } catch (err) {
                console.error("Erro ao carregar perguntas:", err);
            }
        }

        carregarQuiz();
    }, [materia, idMateria, idUsuario]);

    const registrarStatus = async (status) => {
        try {
            await axios.post("http://localhost:8000/api/alunos-perguntas", {
                aluno_id_usuario: idUsuario,
                pergunta_id: idAtividade,
                status: status
            });
        } catch (err) {
            console.error("Erro ao registrar status:", err);
        }
    };

    const acerto = () => {
        Swal.fire({
            title: "Você Acertou!!!",
            icon: "success",
            confirmButtonText: "Ok",
            confirmButtonColor: "#295384"
        }).then(() => {
            navigate(-1);
        });
    }
    const errou = () => {
        Swal.fire({
            title: "Você Errou :(",
            icon: "error",
            confirmButtonText: "Ok",
            confirmButtonColor: "#295384"
        }).then(() => {
            navigate(-1);
        });
    }

    const handleRespostaClick = async (resp) => {
        if (respostaSelecionada) return;
        setRespostaSelecionada(resp);

        if (resp === atividade.correta) {
            await registrarStatus("correto");
            acerto();
        } else {
            await registrarStatus("errado");
            errou();
        }
    }

    if (!atividade) return <p>Carregando...</p>;

    return (
        <div className={Ajuste.wrapper}>
            <Header />
            <main className={Ajuste.container}>
                <Barra level={level} />
                <div className={Style.divAtividade}>
                    <div className={Style.divPergunta + " " + Style.generalizacao}>
                        <h2>{atividade.pergunta}</h2>
                    </div>
                    <div className={Style.ajusteDivResposta}>
                        {atividade.respostas.map((resp, index) => (
                            <div className={Style.divResposta + " " + Style.generalizacao} key={index}
                                onClick={() => handleRespostaClick(resp)}
                            >
                                <p>{resp}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </main>
        </div>
    )
}