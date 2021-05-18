// hello_controller.js
import { Controller } from "stimulus"

export default class extends Controller {
    
   connect(){

        let buttons = document.querySelectorAll("div input#formshow") // Sélectionne tous les résultats

        // Les évènements
        for(let button = 0; button < buttons.length; button++){
            buttons[button].addEventListener("click", clicSpan)
        }

        function clicSpan(){
            let elementshidden = this.parentElement.parentElement;
            let hiddens = elementshidden.querySelectorAll(".hidden");

            hiddens.forEach(element => {
                element.classList.remove('hidden');

                elementshidden.querySelector("#showform").children[0].className += " hidden ";
                
            });


        }

   }
}