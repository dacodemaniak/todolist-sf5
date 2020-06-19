/**
 * @name Main
 * @author Adrar - June 2020
 * @version 1.0.0
 * @abstract Entry point for the frontend application
 */

// Import some libraries
import $ from 'jquery'
import * as M from 'materialize-css'

// Imports styles
import './scss/main.scss'
import { DeleteCategoryHandler } from './category-module/delete-category-handler'

class Main {
    constructor() {
        console.log(`Frontend app works!`)

        // Make an instance of the handler for the table
        new DeleteCategoryHandler()
    }
}

// Bootstraping
$(document).ready(
    () => {
        // Materialize specific
        new Main()
    }
)

document.addEventListener('DOMContentLoaded', () => {
    var elems = document.querySelectorAll('select')
    const options = null
    var instances = M.FormSelect.init(elems, options)
  });