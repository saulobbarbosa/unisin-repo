import React, { useEffect, useState, useRef } from "react";
import axios from "axios";
import Swal from 'sweetalert2';

import Style from "./loja.module.css";
import Ajuste from "../../containerPadrao.module.css";

// Import Componentes
import Header from "../../layout/headers/HeaderAluno";

export default function TelaAlunoLoja() {
    const idAluno = localStorage.getItem("idUsuario");
    const carrosselBorda = useRef(null);
    const carrosselFundo = useRef(null);
    const carrosselAvatar = useRef(null);
    const [itens, setItens] = useState(null);

    const [atualizarHeader, setAtualizarHeader] = useState(false);

    const alertCompra = (idItem) => {
        Swal.fire({
            title: "Deseja Comprar esse Item?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sim, Quero!",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#295384"
        }).then((result) => {
            if (result.isConfirmed) {
                comprarItem(idItem);
                carregarLoja();
                setAtualizarHeader(prev => !prev); 
            }
        });
    }

    useEffect(() => {
        carregarLoja();
    }, []);

    const carregarLoja = () => {
        axios
            .get(`http://localhost:8000/api/itens-loja/aluno/${idAluno}`)
            .then((response) => {
                const dados = response.data;

                const bordas = dados
                    .filter(item => item.tipo === "borda")
                    .map(item => ({
                        id: item.id_item_loja,
                        nome: item.nome,
                        preco: item.preco,
                        color: item.conteudo,
                        status: item.status
                    }));

                const fundos = dados
                    .filter(item => item.tipo === "fundo")
                    .map(item => ({
                        id: item.id_item_loja,
                        nome: item.nome,
                        preco: item.preco,
                        color: item.conteudo,
                        status: item.status
                    }));

                const avatares = dados
                    .filter(item => item.tipo === "avatar")
                    .map(item => ({
                        id: item.id_item_loja,
                        nome: item.nome,
                        preco: item.preco,
                        img: item.conteudo,
                        status: item.status
                    }));

                setItens({
                    bordas,
                    fundos,
                    avatares
                });
            })
            .catch((error) => console.error("Erro ao carregar API de loja:", error));
    }

    const comprarItem = async (idItem) => {
        try {
            const response = await axios.post(
                `http://localhost:8000/api/loja/comprar/${idAluno}/${idItem}`
            );

            Swal.fire({
                title: "Sucesso!",
                text: response.data.message,
                icon: "success",
                confirmButtonColor: "#295384"
            });
        } catch (error) {
            Swal.fire({
                title: "Erro!",
                text: error.response.data.message,
                icon: "error",
                confirmButtonColor: "#295384"
            });
        }
    }

    if (!itens) return <p>Carregando...</p>;

    const scroll = (ref, direction) => {
        const { current } = ref;
        if (!current) return;
        const scrollAmount = 300;
        current.scrollBy({
            left: direction === "left" ? -scrollAmount : scrollAmount,
            behavior: "smooth",
        });
    };

    return (
        <div className={Ajuste.wrapper}>
            <Header atualizar={atualizarHeader} />
            <main className={Ajuste.container}>
                <div className={Style.divTituloTop}>
                    <h1>Faça Atividades, ganhe pontos</h1>
                    <h2>Personalize seu perfil no Unisin</h2>
                </div>

                {/* Bloco de Bordas */}
                <div className={Style.divContainerBloco}>
                    <div className={Style.navbarTop}>
                        <h1>Bordas</h1>
                        <hr className={Style.linhaNav} />
                        <i className="fa-solid fa-chevron-left" style={{ fontSize: '2rem', color: '#fff' }}
                            onClick={() => scroll(carrosselBorda, "left")}></i>
                        <i className="fa-solid fa-chevron-right" style={{ fontSize: '2rem', color: '#fff' }}
                            onClick={() => scroll(carrosselBorda, "right")}></i>
                    </div>
                    <div className={Style.carrosselItens} ref={carrosselBorda}>
                        {itens.bordas.map((borda) => (
                            <div key={borda.id}
                                className={`${Style.cardItem} ${borda.status === "comprado" ? Style.itemApagado : ""}`}
                                onClick={() => { alertCompra(borda.id) }}
                            >
                                <div className={Style.preview}
                                    style={{
                                        border: `0.8rem solid ${borda.color}`,
                                        boxShadow: `0 0 10px ${borda.color}`,
                                    }}
                                >
                                </div>
                                <p style={{ marginTop: "1rem" }}>{borda.nome}</p>
                                <div className={Style.divPreco}>
                                    <img src={require("../../../imgs/moeda.png")} className={Style.imgMoeda}
                                        alt="moeda" draggable="false" />
                                    <p style={{ fontSize: "1.5rem" }}>
                                        <b>{borda.status === "disponivel" ? borda.preco : "Comprado"}</b>
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
                {/* Bloco de Fundos */}
                <div className={Style.divContainerBloco}>
                    <div className={Style.navbarTop}>
                        <h1>Fundos</h1>
                        <hr className={Style.linhaNav} />
                        <i className="fa-solid fa-chevron-left" style={{ fontSize: '2rem', color: '#fff' }}
                            onClick={() => scroll(carrosselFundo, "left")}></i>
                        <i className="fa-solid fa-chevron-right" style={{ fontSize: '2rem', color: '#fff' }}
                            onClick={() => scroll(carrosselFundo, "right")}></i>
                    </div>
                    <div className={Style.carrosselItens} ref={carrosselFundo}>
                        {itens.fundos.map((fundo) => (
                            <div key={fundo.id}
                                className={`${Style.cardItem} ${fundo.status === "comprado" ? Style.itemApagado : ""}`}
                                onClick={() => { alertCompra(fundo.id) }}
                            >
                                <div className={Style.preview}
                                    style={{
                                        backgroundColor: fundo.color,
                                        boxShadow: `0 0 10px ${fundo.color}`,
                                    }}
                                >
                                </div>
                                <p style={{ marginTop: "1rem" }}>{fundo.nome}</p>
                                <div className={Style.divPreco}>
                                    <img src={require("../../../imgs/moeda.png")} className={Style.imgMoeda}
                                        alt="moeda" draggable="false" />
                                    <p style={{ fontSize: "1.5rem" }}>
                                        <b>{fundo.status === "disponivel" ? fundo.preco : "Comprado"}</b>
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
                {/* Bloco de Avatares */}
                <div className={Style.divContainerBloco}>
                    <div className={Style.navbarTop}>
                        <h1>Avatares</h1>
                        <hr className={Style.linhaNav} />
                        <i className="fa-solid fa-chevron-left" style={{ fontSize: '2rem', color: '#fff' }}
                            onClick={() => scroll(carrosselAvatar, "left")}></i>
                        <i className="fa-solid fa-chevron-right" style={{ fontSize: '2rem', color: '#fff' }}
                            onClick={() => scroll(carrosselAvatar, "right")}></i>
                    </div>
                    <div className={Style.carrosselItens} ref={carrosselAvatar}>
                        {itens.avatares.map((avatar) => (
                            <div key={avatar.id}
                                className={`${Style.cardItem} ${avatar.status === "comprado" ? Style.itemApagado : ""}`}
                                onClick={() => { alertCompra(avatar.id) }}
                            >
                                <img
                                    src={avatar.img}
                                    alt="Avatar Loja"
                                    className={Style.preview}
                                    draggable="false"
                                />
                                <p style={{ marginTop: "1rem" }}>{avatar.nome}</p>
                                <div className={Style.divPreco}>
                                    <img src={require("../../../imgs/moeda.png")} className={Style.imgMoeda}
                                        alt="moeda" draggable="false" />
                                    <p style={{ fontSize: "1.5rem" }}>
                                        <b>{avatar.status === "disponivel" ? avatar.preco : "Comprado"}</b>
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </main>
        </div>
    );
}
