import React, { useState } from "react";
import Style from "./atividade.module.css";
import logo from "../../../../imgs/logo.png";

export default function TelaProfCadAtividade() {
  const [mostrarFormulario, setMostrarFormulario] = useState(false);

  // Lista de atividades simulada
  const [atividades, setAtividades] = useState([
    { id: 1, titulo: "Matemática", progresso: 60, imagem: "../../imgs/logo.jpg" },
    { id: 2, titulo: "Português", progresso: 70, imagem: "../../imgs/logo.png" },
  ]);

  // Função para adicionar nova atividade (exemplo simples)
  const adicionarAtividade = () => {
    const nova = { id: atividades.length + 1, titulo: "Nova Atividade", progresso: 0 };
    setAtividades([...atividades, nova]);
  };

  return (
    <div className={Style.container}>
      {/* Cabeçalho fixo */}
      <header className={Style.header}>
        <img src={logo} className={Style.logo} alt="Logo" />
        <h1 className={Style.Professor}>Professor(a)</h1>
      </header>


      <div className={Style.listaContainer}>
        {!mostrarFormulario ? (
          <>
            {/* Título da lista e botão de adicionar */}
            <div className={Style.tituloLista}>
              <h3>Atividades Criadas</h3>
              <button className={Style.addButton} onClick={() => {setMostrarFormulario(true); adicionarAtividade();}}>

              <i className="fas fa-book"></i>
              <i className="fas fa-plus" style={{position:"absolute",border:"0.1rem solid #366091",fontSize: "0.4em", padding: "2px",marginTop: "2rem",marginLeft:"1.5rem", color:"#366091", backgroundColor: "black", borderRadius: "50%"}}></i>
      
              </button>
            </div>

           {/* Lista de atividades */}
            <ul className={Style.lista}>
              {atividades.map((atividade) => (
                <li key={atividade.id} className={Style.item}>
                  {/* Retângulo da imagem */}
                  <div className={Style.imagemMateria}>
                    <img src={atividade.imagem} alt="" />
                  </div>

                  {/* Título da atividade */}
                  <span className={Style.nome}>{atividade.titulo}</span>

                  {/* Barra de progresso */}
                  <progress
                    value={atividade.progresso}
                    max="100"
                    className={Style.progresso}
                  ></progress>
                </li>
              ))}
            </ul>
          </>
        ) : (
          <>
            {/* Cabeçalho do formulário fora do form */}
            <div className={Style.cabecalhoFormulario}>
              <button className={Style.voltar}>
                <i
                  className="fas fa-arrow-left"
                  onClick={() => setMostrarFormulario(false)}
                ></i>
              </button>
              <h3 className={Style.cadastro}>Cadastro de Atividade</h3>
            </div>

            {/* Formulário */}
            <form className={Style.form}>
              <input type="text" placeholder="Título da atividade" required />
              <input type="text" placeholder="Descrição" required />
              <input type="date" required />
              <button type="submit" className={Style.botaoCadastrar}>
                Cadastrar
              </button>
            </form>
          </>
        )}
      </div>
    </div>
  );
}
