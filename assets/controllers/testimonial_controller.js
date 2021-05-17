// hello_controller.js
import { Controller } from "stimulus"

export default class extends Controller {
    
   connect(){

        (function ($) { 
            // Testimonials carousel
            $(".testimonial-carousel").owlCarousel({
                center: true,
                autoplay: true,
                smartSpeed: 2000,
                dots: true,
                loop: true,
                responsive: {
                    0:{
                        items:1
                    },
                    576:{
                        items:1
                    },
                    768:{
                        items:2
                    },
                    992:{
                        items:3
                    }
                }
            });
        })(jQuery);
   }
}