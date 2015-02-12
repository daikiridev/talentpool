$('.tags-field').tagsInput({
    //'autocomplete_url': url_to_autocomplete_api,
    //'autocomplete': { option: value, option: value},
    'height': '30px',
    'width': '400px',
    //'interactive':true,
    //'defaultText':'add a tag',
    //'onAddTag':callback_function,
    //'onRemoveTag':callback_function,
    //'onChange' : callback_function,
    //'removeWithBackspace' : true,
    //'minChars' : 0,
    //'maxChars' : 0 //if not provided there is no limit,
    //'placeholderColor' : '#666666'

});
// « add » button
var addButton = function () {
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

// div containing the collection of addresses
var addressCollection = $('#candidate_addresses');
addressCollection.after(addButton());
// div containing the collection of comments
var commentCollectionDB = $('#candidate_comments');
var commentCollection = $('#candidate_comments_new');
commentCollection.after(addButton());


$(document).ready(function () {
    // catches a click on an "add" button #}
    $('.add_item_link').on('click', function (e) {
        e.preventDefault();
        collection = $(this).parent().prev('.form-collection');
        //alert(collection.attr('id'));
        length = collection.is("#candidate_comments_new") ? commentCollectionDB.children().length : collection.children().length;
        addItemForm(collection, length);
    });
    // adds a remove button to each item of each form collection
    $('.form-collection').children('div').each(function () {
        addItemFormDeleteLink($(this));
    });
});