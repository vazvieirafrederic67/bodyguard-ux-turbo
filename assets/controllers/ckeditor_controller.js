// hello_controller.js
import { Controller } from "stimulus"

export default class extends Controller {
    
   connect(){

    CKEDITOR.replace( 'news_text' );
   }
}