import React from "react";
import {BrowserRouter as Routers, Routes, Route} from "react-router-dom"

// Import
import Home from "./components/home/Home";
// Import Telas Aluno
import AlunoHome from "./components/aluno/home/AlunoHome";
import AlunoTrilha from "./components/aluno/trilha/Trilha";
import Atividade from "./components/aluno/atividade/Atividade";
import AlunoPerfil from "./components/aluno/perfil/PerfilAluno";
import AlunoLoja from "./components/aluno/loja/Loja";
import AlunoInventario from "./components/aluno/inventario/Inventario";
import AlunoAmigos from "./components/aluno/amigos/Amigos";
import AlunoRanking from "./components/aluno/ranking/Ranking";
import AlunoConquistas from "./components/aluno/conquistas/Conquistas";
import AlunoLobby from "./components/aluno/pvp/lobby/Lobby";
// Import Telas ADM
import EscolaHome from "./components/adm/escola/EscolaHome";
import ProfHome from "./components/adm/professor/home/ProfHome";
import ProfCadAtividade from "./components/adm/professor/cadastro-atividade/CadastroAtividade";

export default function App() { 
    return(
        <Routers>
            <Routes>
                {/* Rotas Padrões */}
                <Route path="/" element={<Home />} />

                {/* Rotas Aluno */}
                <Route path="/aluno/home" element={<AlunoHome />} />
                <Route path="/aluno/:materia/:idMateria" element={<AlunoTrilha />} />
                <Route path="/aluno/:materia/:idMateria/atividade/:idAtividade" element={<Atividade />} />
                <Route path="/aluno/perfil/:alunoId" element={<AlunoPerfil />} />
                <Route path="/aluno/amigos" element={<AlunoAmigos />} />
                <Route path="/aluno/loja" element={<AlunoLoja />} />
                <Route path="/aluno/inventario/:alunoId" element={<AlunoInventario />} />
                <Route path="/aluno/ranking" element={<AlunoRanking />} />
                <Route path="/aluno/conquistas" element={<AlunoConquistas />} />
                <Route path="/aluno/lobby/:adversarioId" element={<AlunoLobby />} />

                {/* Rotas ADM */}
                <Route path="/escola/home" element={<EscolaHome />} />
                <Route path="/professor/home" element={<ProfHome />} />
                <Route path="/professor/cadastro-atividade" element={<ProfCadAtividade />} />
            </Routes>
        </Routers>
    );
}