/**
 * @name DeleteCategoryHandler
 * @author Adrar - June 2020
 * @version 1.0.0
 * @abstract Manage Delete button for the category admin
 */

// Import libraries and dependencies
import $ from 'jquery'
import { Modal } from '../modal-module/modal'

 export class DeleteCategoryHandler {
    constructor() {
        this._selector = $('[deleteCategory]') // Get a collection of deleteCategory components

        // Set event handlers
        this.clickEventHandler()
    }

    clickEventHandler() {
        this._selector.on(
            'click', // Event to listen
            (event) => { // Action to perform when the event is triggered
                // Get the real button clicked
                const button = $(event.target) // Specific Delete button clicked
                console.log(`${button.attr('deleteCategory')} button was clicked`)
                const trPlaceholder = button.parents('td').parent('tr')
                const titleColumn = trPlaceholder.children('td').eq(2)
                console.log(`Title is : ${titleColumn.html()}`)

                // Create the content object to pass to modal box
                const content = $('<blockquote>')
                const message = `Etes-vous sûr de vouloir supprimer "${titleColumn.html()}" ?`
                content.html(message)

                // Show a modal box
                const modal = new Modal(content)
                modal.show()

                // Listen for a doDelete event
                button.on(
                    'doDelete',
                    (event) => {
                        console.log(`Hey guys, i have to delete a row`)
                        // Send a request to the backend to remove the category with a specific ID
                        $.ajax({
                            url: 'http://127.0.0.1/category/delete/' + trPlaceholder.children('td').eq(1).html().toString(),
                            method: 'delete',
                            dataType: 'json', // Expected response mime type
                            success: (response) => {
                                // My logic if server respond with a 200 OK
                                // Remove the html table row associated to this ID
                                trPlaceholder.remove()
                            },
                            error: (XHR, response, status) => {
                                // What about failure
                            }        
                        })

                    }
                )
            }
        ) // Place an event handler on all elements of the collection
    }
 }