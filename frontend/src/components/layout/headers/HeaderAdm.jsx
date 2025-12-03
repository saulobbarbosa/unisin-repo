import React from "react";
import HeaderStyle from "./header.module.css";

export default function CompHeaderHome({ titulo }){
    return(
        <div className={HeaderStyle.headerContainer}>
            <img src={require('../../../imgs/logo.png')} alt="logo do unisin"
            className={HeaderStyle.logo} draggable="false" />
            <h1 style={{ textAlign:"center", width:"80vw" }}>{titulo}</h1>
        </div>
    );
}