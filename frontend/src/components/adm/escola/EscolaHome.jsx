import React, { useState } from "react";
import { Link } from "react-router-dom";
import Style from "./escolaHome.module.css";
import logo from "../../../imgs/logo.png"; 

import Header from "../../layout/headers/HeaderAdm";

import Ajuste from "../../containerPadrao.module.css";

export default function TelaEscolaHome() {
  // Estado local simulando os professores (depois pode vir da API)
  const [professores, setProfessores] = useState([
    { id: 1, nome: "Fuilherme Greitas" },
    { id: 2, nome: "Paulo Satista" },
  ]);

  // Função para adicionar um novo professor (exemplo simples)
  const adicionarProfessor = () => {
    const novo = { id: professores.length + 1, nome: "Novo Professor" };
    setProfessores([...professores, novo]);
  };

  return (
    <div className={Ajuste.wrapper}>
      <Header titulo={"Escola"} />

      <main className={Ajuste.container}>
        <h2 className={Style.nomeEscola}>Exemplo de Nome de Escola</h2>
    
        <div className={Style.listaContainer}>
          <div className={Style.tituloLista}>
            <h3>Lista de Professores(as)</h3>
            <i className="fas fa-user-plus"  onClick={adicionarProfessor}style={{ fontSize: '2rem', cursor: 'pointer', color: 'black' }}></i>
          </div>
    
          <ul className={Style.lista}>
            {professores.map((prof) => (
              <li key={prof.id} className={Style.item}>
                <span className={Style.id}>{prof.id}</span>
                <span className={Style.nome}>{prof.nome}</span>
                <span className={Style.acoes}>  <i className="fas fa-ellipsis-h"></i></span>
              </li>
            ))}
          </ul>
        </div>
      </main>
    </div>
  );
}
