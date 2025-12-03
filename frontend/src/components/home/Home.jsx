import React, { useState } from "react";
import HomeStyle from "./home.module.css";

// Import Componentes
import Header from "../layout/headers/HeaderHome";
import Carrossel from "../carrossels/home-carrossel/HCarrossel";
import Cards from "../carrossels/home-cards/HCards";
import ScrollFloat from "../react-bits/scroll-float/ScrollFloat";
import ScrollReveal from "../react-bits/scroll-reveal/ScrollReveal";
import CadastroEscola from "../cadastros/Escola";
import Footer from "../layout/footers/FooterHome";

export default function TelaHome(){
    const [mostrar, setMostrar] = useState(false);
    
    return(
        <div className={HomeStyle.container} id="home">
            <Header />
            <Carrossel />
            <Cards />
            {/* Codigo da parte do Sobre Nós */}
            <div className={HomeStyle.divPadrao + " " + HomeStyle.corClara} id="sobre">
                <h1 className={HomeStyle.tituloPadrao}>
                    <ScrollFloat
                        animationDuration={1}
                        ease='back.inOut(2)'
                        scrollStart='center bottom+=50%'
                        scrollEnd='bottom bottom-=40%'
                        stagger={0.1}
                    >
                        Sobre Nós
                    </ScrollFloat>
                </h1>
                <p className={HomeStyle.paragrafoPadrao}>
                    <ScrollReveal
                        enableBlur={true}
                        blurStrength={15}
                        baseOpacity={1}
                        baseRotation={10}
                    >
                        O Unisin é um projeto desenvolvido para facilitar o aprendizado de forma acessível, simples e envolvente. 
                        Nosso objetivo é apoiar estudantes que encontram dificuldades em acompanhar o ensino tradicional, oferecendo uma forma de reforço leve, 
                        clara e motivadora.
                    </ScrollReveal>
                    <ScrollReveal
                        enableBlur={true}
                        blurStrength={15}
                        baseOpacity={1}
                        baseRotation={10}
                    >
                        Este projeto faz parte do Projeto Integrador do curso de Análise e Desenvolvimento de Sistemas - AMS da FATEC Lins, 
                        unindo criatividade, tecnologia e inovação para transformar a experiência de estudo em algo mais prazeroso e eficiente.
                    </ScrollReveal>
                </p>
            </div>
            {/* Codigo da parte dos Beneficios */}
            <div className={HomeStyle.divPadrao + " " + HomeStyle.corEscura} id="beneficios">
                <h1 className={HomeStyle.tituloPadrao} style={{ marginTop: '5rem'}}>
                    <ScrollFloat
                        animationDuration={1}
                        ease='back.inOut(2)'
                        scrollStart='center bottom+=50%'
                        scrollEnd='bottom bottom-=40%'
                        stagger={0.1}
                    >
                        Benefícios
                    </ScrollFloat>
                </h1>
                <div className={HomeStyle.separacaoBeneficio}>
                    <img src={require('../../imgs/logo.png')} alt="logo"
                    className={HomeStyle.imgsBeneficios} draggable="false" />
                    <p className={HomeStyle.paragrafoPadrao}>
                        <ScrollReveal
                            enableBlur={true}
                            blurStrength={15}
                            baseOpacity={1}
                            baseRotation={10}
                        >
                            📘 Aprendizado Simplificado - Explicações claras e objetivas para facilitar o entendimento.
                        </ScrollReveal>   
                        <ScrollReveal
                            enableBlur={true}
                            blurStrength={15}
                            baseOpacity={1}
                            baseRotation={10}
                        >
                            🎮 Mais Motivação - O estudo se torna mais envolvente e menos cansativo.
                        </ScrollReveal>
                        <ScrollReveal
                            enableBlur={true}
                            blurStrength={15}
                            baseOpacity={1}
                            baseRotation={10}
                        >
                            ⏳ Autonomia - Cada aluno aprende no seu tempo, sem pressão.
                        </ScrollReveal>
                    </p>
                </div>
                <div className={HomeStyle.separacaoBeneficio}>
                    <p className={HomeStyle.paragrafoPadrao}>
                        <ScrollReveal
                            enableBlur={true}
                            blurStrength={15}
                            baseOpacity={1}
                            baseRotation={10}
                        >
                            💡 Confiança nos Estudos - Superando dificuldades com apoio constante.
                        </ScrollReveal>
                        <ScrollReveal
                            enableBlur={true}
                            blurStrength={15}
                            baseOpacity={1}
                            baseRotation={10}
                        >
                            🌍 Acesso Fácil - Disponível para qualquer estudante que precise de reforço.
                        </ScrollReveal>   
                    </p>
                    <img src={require('../../imgs/moeda.png')} alt="moeda"
                    className={HomeStyle.imgsBeneficios} draggable="false" />
                </div>
            </div>
            {/* Codigo da parte das Escolas */}
            <div className={HomeStyle.divPadrao + " " + HomeStyle.corClara} id="escola">
                <h1 className={HomeStyle.tituloPadrao}>
                    <ScrollFloat
                        animationDuration={1}
                        ease='back.inOut(2)'
                        scrollStart='center bottom+=50%'
                        scrollEnd='bottom bottom-=40%'
                        stagger={0.1}
                    >
                        Escolas podem Participar?
                    </ScrollFloat>
                </h1>
                <div className={HomeStyle.separacaoBeneficio}>
                    <img src={require('../../imgs/check-verde.jpg')} alt="logo"
                    className={HomeStyle.imgsEscola} draggable="false" />
                    <p className={HomeStyle.paragrafoPadrao}>
                        <ScrollReveal
                            enableBlur={true}
                            blurStrength={15}
                            baseOpacity={1}
                            baseRotation={10}
                        >
                            As escolas podem se cadastrar na plataforma e, após aprovação, terão acesso a um 
                            ambiente exclusivo para cadastrar professores. Esses professores poderão incluir 
                            conteúdos, atividades e materiais que ficarão disponíveis diretamente para os 
                            alunos da instituição.
                        </ScrollReveal> 
                        <ScrollReveal
                            enableBlur={true}
                            blurStrength={15}
                            baseOpacity={1}
                            baseRotation={10}
                        >
                            Para garantir a segurança e credibilidade do sistema, todo cadastro de escola 
                            passa por uma verificação administrativa, confirmando que realmente se trata 
                            de uma instituição de ensino antes da liberação do acesso.
                        </ScrollReveal>
                    </p>
                </div>
                <div className={HomeStyle.divBtnCadastro}>
                    <button className={HomeStyle.btnCadastro} onClick={() => setMostrar(true)}>
                        Cadastre sua Escola
                    </button>
                </div>
            </div>
            <CadastroEscola mostra={mostrar} fecha={()=>{setMostrar(false)}} />
                <Footer />
        </div>
    )
}