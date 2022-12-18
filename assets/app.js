/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
let toggle= document.getElementById('toggle-listener')
let maintenanceTableLine=document.getElementsByClassName('maintenanceReason')
let boatTableLine=document.getElementsByClassName('boatReason')
console.log('HHHAAAAA');
toggle.addEventListener("click",function() {
    for(let i=0; i < maintenanceTableLine.length; i++ ) {
        console.log(maintenanceTableLine[i])
        if (maintenanceTableLine[i].classList.contains("hidden")) {
            maintenanceTableLine[i].classList.remove("hidden")
            maintenanceTableLine[i].classList.add("shown")

        } else {
            maintenanceTableLine[i].classList.remove("shown")
            maintenanceTableLine[i].classList.add("hidden")
        }
    }
    for(let i=0; i < boatTableLine.length; i++ ){
        if (boatTableLine[i].classList.contains("shown")) {
            boatTableLine[i].classList.remove("shown")
            boatTableLine[i].classList.add("hidden")

        } else {
            boatTableLine[i].classList.remove("hidden")
            boatTableLine[i].classList.add('shown')
        }
    }
})


