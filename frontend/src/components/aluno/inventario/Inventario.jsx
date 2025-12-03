import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "axios";
import Swal from 'sweetalert2';

import Style from "./inventario.module.css";
import Ajuste from "../../containerPadrao.module.css";

// Import Componentes
import Header from "../../layout/headers/HeaderAluno";

export default function TelaAlunoHome() {
    const [usuario, setUsuario] = useState({});
    const { alunoId } = useParams();
    const [itens, setItens] = useState([]);
    const [equipado, setEquipado] = useState([]);

    const [atualizarHeader, setAtualizarHeader] = useState(false);

    useEffect(() => {
        if (!alunoId) return;

        carregarUsuario();
        carregarItemEquipado();
        carregarItens();
    }, []);

    const carregarUsuario = () => {
        axios.get(`http://localhost:8000/api/alunos/${alunoId}/dados`)
            .then(res => {
                setUsuario(res.data);
            })
            .catch(error => console.error(error));
    }

    const carregarItemEquipado = () => {
        axios.get(`http://localhost:8000/api/alunos/${alunoId}/equipados`)
            .then(res => {
                setEquipado(res.data);
            })
            .catch(error => console.error(error));
    }

    const carregarItens = () => {
        axios.get(`http://localhost:8000/api/alunos/${alunoId}/itens`)
            .then(res => {
                setItens(res.data);
            })
            .catch(error => console.error(error));
    }

    const equipar = async (idItem) => {
        try {
            const response = await axios.post(
                `http://localhost:8000/api/loja/equipar/${alunoId}/${idItem}`
            );

            Swal.fire({
                title: "Sucesso!",
                text: response.data.message,
                icon: "success",
                confirmButtonColor: "#295384"
            });
            carregarUsuario();
            carregarItemEquipado();
            carregarItens();
            setAtualizarHeader(prev => !prev); 
        } catch (error) {
            Swal.fire({
                title: "Erro!",
                text: error.response.data.message,
                icon: "error",
                confirmButtonColor: "#295384"
            });
        }
    }

    return (
        <div className={Ajuste.wrapper}>
            <Header atualizar={atualizarHeader} />
            <main className={Ajuste.container}>
                <h1 className={Style.titulo}>Inventário de Cosméticos</h1>
                <div className={Style.layoutPrincipal}>
                    {/* Primeiro Bloco do Inventario */}
                    <div className={Style.divPreviewEstilo}>
                        <div className={Style.divPreview}
                            style={{
                                backgroundColor: usuario.fundo,
                            }}
                        >
                            <img src={usuario.avatar || "/imgs/perfil/boy_black.webp"} alt="avatar"
                                className={Style.imgAvatar}
                                draggable="false"
                                style={{
                                    border: `0.5rem solid ${usuario.borda}`
                                }}
                            />
                        </div>
                        <h1>{usuario.nome}</h1>
                        <div className={Style.divEspecificacao}>
                            <div className={Style.cardEspecificacao}>
                                <h1>Avatar</h1>
                                <h2>{equipado.avatar}</h2>
                            </div>
                            <div className={Style.cardEspecificacao}>
                                <h1>Borda</h1>
                                <h2>{equipado.borda}</h2>
                            </div>
                            <div className={Style.cardEspecificacao}>
                                <h1>Fundo</h1>
                                <h2>{equipado.fundo}</h2>
                            </div>
                        </div>
                    </div>
                    {/* Segundo Bloco do Inventario */}
                    <div className={Style.divTodosItens}>
                        {itens.map(item => (
                            <div key={item.id_item_loja}
                                className={Style.divPreviewMini}
                            >
                                {item.tipo === "avatar" && (
                                    <img
                                        src={item.conteudo}
                                        alt={item.nome}
                                        className={Style.imgAvatarMini}
                                    />
                                )}

                                {item.tipo === "borda" && (
                                    <div
                                        className={Style.fundoBordaAvatar}
                                        style={{ border: `0.5rem solid ${item.conteudo}` }}
                                    ></div>
                                )}

                                {item.tipo === "fundo" && (
                                    <div
                                        className={Style.fundoBordaAvatar}
                                        style={{ backgroundColor: item.conteudo }}
                                    ></div>
                                )}

                                <h1>{item.nome}</h1>

                                <div
                                    className={Style.btnEquipar}
                                    onClick={() => equipar(item.id_item_loja)}
                                >
                                    <h1>Equipar</h1>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </main>
        </div>
    );
}