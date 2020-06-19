/**
 * @name Main
 * @author Adrar - June 2020
 * @version 1.0.0
 * @abstract Entry point for the frontend application
 */

// Import some libraries
import $ from 'jquery'

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
        new Main()
    }
)