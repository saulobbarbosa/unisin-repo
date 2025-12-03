import React from "react";

import Style from "./profHome.module.css";
import Ajuste from "../../../containerPadrao.module.css";

//Import de Componentes
import Header from "../../../layout/headers/HeaderAdm";

export default function TelaProfHome(){
    return(
        <div className={Ajuste.wrapper}>
            <Header titulo={"Professor"} />
            <main className={Ajuste.container}>
            </main>
        </div>
    )
}