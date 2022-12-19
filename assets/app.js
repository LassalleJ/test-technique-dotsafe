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

let toggle = document.getElementById('toggle-listener')
let showBoatTab = document.getElementById('show-boat-tab')
let showMaintenanceTab = document.getElementById('show-maintenance-tab')
let maintenanceTableLine = document.getElementsByClassName('maintenanceReason')
let boatTableLine = document.getElementsByClassName('boatReason')
let searchBoatForm = document.getElementById('searchBoatForm')

showBoatTab.addEventListener("click", function () {
    searchBoatForm.classList.add("shown")
    searchBoatForm.classList.remove("hidden")
    showBoatTab.classList.toggle('active-tab')
    showMaintenanceTab.classList.remove('active-tab')

    for (let i = 0; i < maintenanceTableLine.length; i++) {
        if (maintenanceTableLine[i].classList.contains('shown')) {
            maintenanceTableLine[i].classList.remove("shown")
            maintenanceTableLine[i].classList.add("hidden")
        } else {
            maintenanceTableLine[i].classList.add("shown")
            maintenanceTableLine[i].classList.remove("hidden")
        }
    }
    for (let i = 0; i < boatTableLine.length; i++) {
        boatTableLine[i].classList.remove("hidden")
        boatTableLine[i].classList.add("shown")
    }
})
showMaintenanceTab.addEventListener("click", function () {
    searchBoatForm.classList.toggle("shown")
    searchBoatForm.classList.toggle("hidden")
    showMaintenanceTab.classList.toggle('active-tab')
    showBoatTab.classList.remove('active-tab')
    for (let i = 0; i < maintenanceTableLine.length; i++) {
            maintenanceTableLine[i].classList.remove("hidden")
            maintenanceTableLine[i].classList.add("shown")
    }
    for (let i = 0; i < boatTableLine.length; i++) {
        if (boatTableLine[i].classList.contains("shown")) {
            boatTableLine[i].classList.remove("shown")
            boatTableLine[i].classList.add("hidden")
        } else {
            boatTableLine[i].classList.remove("hidden")
            boatTableLine[i].classList.add("shown")
        }

    }
})


