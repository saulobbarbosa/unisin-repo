import React, { useState, useEffect, useRef } from "react";

import CarrosselStyle from "./carrossel.module.css";

// Import de Componentes
import TextType from "../../react-bits/text-type/TextType";

// Import Imagens
import img1 from "../../../imgs/carrossel-imgs/img1.webp";
import img2 from "../../../imgs/carrossel-imgs/img2.webp";
import img3 from "../../../imgs/carrossel-imgs/img3.webp";

const images = [
    { src: img1, text: "Melhor Rede de Ensino" },
    { src: img2, text: "Educação de Qualidade" },
    { src: img3, text: "Apoio ao Aluno" },
];

export default function Home_Carrossel() {
    const [current, setCurrent] = useState(0);
    const timerRef = useRef(null);

    const startAutoPlay = () => {
        if (timerRef.current) return;
        timerRef.current = setInterval(() => {
            setCurrent(prev => (prev === images.length - 1 ? 0 : prev + 1));
        }, 5000);
    };

    const stopAutoPlay = () => {
        if (timerRef.current) {
            clearInterval(timerRef.current);
            timerRef.current = null;
        }
    };

    useEffect(() => {
        startAutoPlay();
        return () => stopAutoPlay();
        // dependência vazia: não recria interval a cada render
    }, []);

    const nextSlide = () => setCurrent(prev => (prev === images.length - 1 ? 0 : prev + 1));
    const prevSlide = () => setCurrent(prev => (prev === 0 ? images.length - 1 : prev - 1));

    const handleNext = () => { nextSlide(); stopAutoPlay(); startAutoPlay(); };
    const handlePrev = () => { prevSlide(); stopAutoPlay(); startAutoPlay(); };

    return (
        <div
            className={CarrosselStyle.carouselContainer}
            onMouseEnter={stopAutoPlay}
            onMouseLeave={startAutoPlay}
        >
            {images.map((item, index) => (
                <div key={index}
                    className={`${CarrosselStyle.slide} ${index === current ? CarrosselStyle.active : ""}`}
                >
                    <img src={item.src} alt="slide" className={CarrosselStyle.image} draggable="false" />
                    <div className={CarrosselStyle.divText}>
                        {index === current && (
                        <h2 className={CarrosselStyle.text}>
                            <TextType
                                key={current}
                                text={item.text}
                                typingSpeed={75}
                                pauseDuration={1500}
                                showCursor={true}
                                cursorCharacter="_"
                            />
                        </h2>
                        )}
                    </div>
                </div>
            ))}

            <div className={CarrosselStyle.divArrows}>
                <button className={CarrosselStyle.arrow} onClick={handlePrev}>
                    <i className="pi pi-chevron-left" style={{ fontSize: '2rem', color: '#000' }}></i>
                </button>
                <button className={CarrosselStyle.arrow} onClick={handleNext}>
                    <i className="pi pi-chevron-right" style={{ fontSize: '2rem', color: '#000' }}></i>
                </button>
            </div>

            <div className={CarrosselStyle.divDot}>
                {images.map((_, index) => (
                    <span
                        key={index}
                        className={`${CarrosselStyle.dot} ${index === current ? CarrosselStyle.dotActive : ""}`}
                        onClick={() => {
                            setCurrent(index);
                            stopAutoPlay();
                            startAutoPlay()
                        }}
                    ></span>
                ))}
            </div>
        </div>
    )
}