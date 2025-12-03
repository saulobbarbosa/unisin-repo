import React, { useState, useEffect } from "react";
import axios from "axios";
import Swal from 'sweetalert2';

import Style from "./conquistas.module.css";
import Ajuste from "../../containerPadrao.module.css";

// Import Componentes
import Header from "../../layout/headers/HeaderAluno";

export default function TelaConquistas(){
    const [conquistas, setConquistas] = useState([]);
    
    useEffect(() => {
        axios.get("/conquistas.json")
        .then(res => setConquistas(res.data))
        .catch(err => console.error(err));
    }, []);

    return(
        <div className={Ajuste.wrapper}>
            <Header />
            <main className={Ajuste.container}>
                <div className={Style.divTitulo}>
                    <h1 className={Style.tituloTop}>Conquistas</h1>
                </div>
                <div className={Style.gridConquista}>
                    {/* Topo da Tabela */}
                    <div style={{ color: "#295384", fontWeight: "bold" }}>
                        Objetivo
                    </div>
                    <div className={Style.textoTopoTabela}>
                        Status
                    </div>
                    <div className={Style.textoTopoTabela}>
                        Recompensa
                    </div>
                    {/* Dados */}
                    {conquistas.map(conquista => (
                        <React.Fragment key={conquista.id}>
                            <div>
                                {conquista.descricao}
                            </div>
                            <div style={{ textAlign: "center" }}>
                                <p>{conquista.qtdAtual}/{conquista.qtdCompleta}</p>
                            </div>
                            <div className={Style.ajusteRecompensa}>
                                {conquista.recompensa.tipo === "moedas" ? (
                                    <div className={Style.destaqueRecMoeda}>
                                        <img src={require('../../../imgs/moeda.png')} alt="icone de moeda" 
                                        className={Style.img} draggable="false" />
                                        {conquista.recompensa.valor}
                                    </div>
                                ) : conquista.recompensa.categoria === "bordas" ? (
                                    <div className={Style.previewBorda}
                                    style={{ border: `0.4rem solid ${conquista.recompensa.color}` }}
                                    title={conquista.recompensa.nome}
                                    ></div>
                                ) : conquista.recompensa.categoria === "fundos" ? (
                                    <div className={Style.previewFundo}
                                    style={{ backgroundColor: conquista.recompensa.color }}
                                    title={conquista.recompensa.nome}
                                    ></div>
                                ) : conquista.recompensa.categoria === "avatares" ? (
                                    <img src={conquista.recompensa.img}
                                        alt={conquista.recompensa.nome}
                                        className={Style.previewAvatar}
                                        draggable="false"
                                        title={conquista.recompensa.nome}
                                    />   
                                ) : (
                                    <h1>Não Encontrado!!!</h1>
                                )}
                            </div>
                        </React.Fragment>
                    ))}
                </div>
            </main>
        </div>
    )
}