import React from "react";

import FooterStyle from "./footer.module.css";

export default function CompFooterHome(){
    return(
       <div className={FooterStyle.containerFooter}>
            <div>
                <h1 className={FooterStyle.tituloFooter}>Desenvolvido Por:</h1>
                <ul>
                    <li>Guilherme Leite Freitas</li>
                    <li>Saulo Batista Barbosa</li>
                    <li>Leonardo Gomes da Silva</li>
                    <li>Uilton Gomes de Lima</li>
                </ul>
            </div>
            <div>
                <h1 className={FooterStyle.tituloFooter}>E-mails:</h1>
                <ul>
                    <li>guilherme.freitas27@fatec.sp.gov.br</li>
                    <li>saulo.barbosa2@fatec.sp.gov.br</li>
                    <li>leonardo.silva510@fatec.sp.gov.br</li>
                    <li>uilton.lima@fatec.sp.gov.br</li>
                </ul>
            </div>
            <div>
                <h1 className={FooterStyle.tituloFooter}>Tecnologias:</h1>
                <ul>
                    <li>
                        <a href="https://react.dev/" target="blank">
                            React.js
                            <i className="fa-brands fa-react" style={{ fontSize: "1rem", color: "#fff", marginLeft: "1rem" }}></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mysql.com/" target="blank">
                            MySQL
                            <i className="fa-solid fa-database" style={{ fontSize: "1rem", color: "#fff", marginLeft: "1rem" }}></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://laravel.com/" target="blank">
                            Laravel
                            <i className="fa-brands fa-laravel" style={{ fontSize: "1rem", color: "#fff", marginLeft: "1rem" }}></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div className={FooterStyle.divFooter}>
                <h1 className={FooterStyle.tituloFatec}>
                    FATEC LINS
                    <br />
                    CURSO - AMS 4°
                </h1>
            </div>
       </div>
    )
}