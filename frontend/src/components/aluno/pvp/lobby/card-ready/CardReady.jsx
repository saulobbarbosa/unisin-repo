import React, { useState } from "react";

import Style from "./card.module.css";

export default function CompCardReady({ nome, avatar, borda }){
    const [pronto, setPronto] = useState(false);
    return(
        <div className={Style.divCard}> 
            <img src={avatar} className={Style.avatar}
            alt="Imagem de Perfil" draggable="false"
            style={{
                border: `0.3rem solid ${borda}`
            }} />
            <h1>{nome}</h1>
            <div onClick={()=>{setPronto(!pronto)}}>
                <p>{pronto ? "✅Pronto" : "❌Não Pronto"}</p>
            </div>
        </div>
    )
}