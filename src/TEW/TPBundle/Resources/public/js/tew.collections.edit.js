// collections management
// « add » button
function addButton() {
    var $addItemLink = $('<a href="#" class="add_item_link btn-xs btn-warning">Add</a>');
    return $('<span></span>').append($addItemLink);
};

// adapted from http://symfony.com/doc/2.3/cookbook/form/form_collections.html
function addItemForm(collectionHolder, length) {
    var prototype = collectionHolder.attr('data-prototype');
    // Replaces '__name__' in the prototype HTML by the index of the current item
    var newItemForm = prototype.replace(/__name__/g, length);
    // Displays the item form in a <div>, just before the "add" button
    var $newItemFormDiv = $('<div></div>').append(newItemForm);
    collectionHolder.append($newItemFormDiv);
    // add a "remove" link at the end of the new form
    addItemFormDeleteLink($newItemFormDiv);
}

function addItemFormDeleteLink($itemFormLi) {
    var $removeFormA = $('<a href="#" class="btn-xs btn-danger">Remove</a>');
    $itemFormLi.append($removeFormA);
    $removeFormA.on('click', function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            $itemFormLi.remove();
        }
    });
}