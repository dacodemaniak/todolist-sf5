/**
 * @name Modal
 * @author Adrar
 * @version 1.0.0
 * @abstract Manage Modal boxes from scratch
 */

// Imports libraries
import $ from 'jquery'

export class Modal {
    constructor(content) {
        this._content = content

        this._modal = this.buildModal() // Create the modal DOM structure

        // Sets the event handlers
        this.noButtonHandler()
        this.yesButtonHandler()
    }

    show() {
        $('body').append(this._modal)
    }

    remove() {
        this._modal.remove()
    }

    buildModal() {
        // First : create the outer modal box
        const outerModal = $('<div>') // Create a DIV element in the DOM
        // Associate modal-outer-box CSS class to the brand new div
        outerModal.addClass('modal-outer-box')

        // Second : create the inner modal box
        const innerModal = $('<div>')
        innerModal.addClass('modal-inner-box')

        // Add the content for the modal box
        innerModal.append(this._content)

        // Add select buttons : yes and no
        const noButton = $('<button>')
        noButton
            .html('Non')
            .addClass('btn')
            .addClass('waves-effect')
            .addClass('waves-light')
            .attr('modal-cancelation', 'modal-cancelation') // Polymorph method

        const yesButton = noButton.clone()
        yesButton
            .html('Oui')
            .removeAttr('modal-cancelation')
            .attr('modal-confirmation', 'modal-confirmation')
        innerModal.append(noButton)
        innerModal.append(yesButton)

        // Place innerModal into outerModal
        outerModal.append(innerModal)

        // Finally return the full nested object
        return outerModal
    }

    noButtonHandler() {
        $('body').on(
            'click',
            '[modal-cancelation]', // Event delegation
            (event) => {
                console.log(`Have to remove the Modal box`)
                this.remove()
            }
        )
    }

    /**
     * Yes handler doSomething
     */
    yesButtonHandler() {
        $('body').on(
            'click',
            '[modal-confirmation]', // Event delegation
            (event) => {
                console.log(`Have to remove the Modal box : yes mode`)
                this.remove()

                // Trigger an event to tell what to do
                $('body [deleteCategory]').trigger('doDelete')
            }
        )
    }
}

/**
 * <div class="modal-outer-box">
 *  <div class="modal-inner-box">
 *  </div>
 * </div>
 */