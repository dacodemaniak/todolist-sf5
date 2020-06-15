/**
 * @name Main
 * @author Adrar - June 2020
 * @version 1.0.0
 * @abstract Entry point for the frontend application
 */

// Import some libraries
import $ from 'jquery'

class Main {
    constructor() {
        console.log(`Frontend app works!`)
    }
}

// Bootstraping
$(document).ready(
    () => {
        new Main()
    }
)