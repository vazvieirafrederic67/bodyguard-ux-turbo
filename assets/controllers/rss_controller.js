// rss_controller.js
import { Controller } from "stimulus"

export default class extends Controller {
    
    connect(){
        var carousel_item = document.getElementsByClassName('carousel-item rss');
        carousel_item[0].classList.add("active");

        var bootstrap = require('bootstrap');
        var myCarousel = document.querySelector('#carousel');

        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 3000,
            wrap: true,
            pause: false,
            touch: true,
            keyboard: false,
            ride: false,
            slide: true,
            cycle: true
        })
    }
}