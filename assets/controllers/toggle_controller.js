import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    // 1. Déclaration des éléments HTML cibles
 static targets = ["content","fond"];

 connect()
 {
    console.log("Je suis Connecte !");
 }
 toggle(){
    // La cible est automatiquement accessible via "this.contentTarget"
    this.contentTarget.classList.toggle('d-none'); // Masque ou affiche
 }
 fondBleu()
 {
    this.fondTarget.classList.add("bleu");
    this.fondTarget.classList.remove("rouge");
 }
 fondRouge()
 {
    this.fondTarget.classList.remove("bleu");

    this.fondTarget.classList.add("rouge");
 }
}

