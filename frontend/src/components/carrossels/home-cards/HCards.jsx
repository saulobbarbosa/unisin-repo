import React from "react";

import CardsStyle from "./card.module.css";

import LogoLoop from "../../react-bits/logo-loop/LogoLoop";

// Lista com os nomes das matérias
const array = [
    {text: "Matemática", icon: "fa-solid fa-calculator"},
    {text: "Português", icon: "fa-solid fa-book"},
    {text: "Inglês", icon: "fa-solid fa-comment"},
    {text: "História", icon: "fa-solid fa-landmark"},
    {text: "Geografia", icon: "fa-solid fa-map"},
    {text: "Química", icon: "fa-solid fa-flask"},
    {text: "Física", icon: "fa-solid fa-atom"},
    {text: "Artes", icon: "fa-solid fa-palette"},
    {text: "Ed. Física", icon: "fa-solid fa-volleyball"},
];

// Montando o array para o LogoLoop
const techLogos = array.map(({ text, icon }) => ({
    node: (
        <div className={CardsStyle.logoItem}>
            <i className={icon} style={{ fontSize: "8rem", color: "#fff" }}></i>
            <span>{text}</span>
        </div>
    )
}));

export default function Home_Card(){
    return(
        <div className={CardsStyle.divCards} id="materias">
            <div className={CardsStyle.divTitulo}>
                <span>Matérias Disponíveis</span>
            </div>
            
            <LogoLoop
                logos={techLogos}
                speed={120}
                direction="left"
                logoHeight={0}
                gap={100}
                pauseOnHover
                scaleOnHover
                ariaLabel="Partner logos"
            />
        </div>
    )
}