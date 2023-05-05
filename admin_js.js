'use strict'

const boton = document.querySelectorAll('.boton')
const tab = document.querySelectorAll('.tab')

boton.forEach( ( cadaboton , i )=>{
    boton[i].addEventListener('click',()=>{
        boton.forEach( ( cadaboton , i )=>{
            boton[i].classList.remove('activo')
            tab[i].classList.remove('activo')
        })
        boton[i].classList.add('activo')
        tab[i].classList.add('activo')

    })
})